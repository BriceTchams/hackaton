<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PaiementCourse;
use App\Models\Portefeuille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Créer et payer immédiatement la course
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'id_passager' => ['required', 'integer'],
        'id_chauffeur' => ['required', 'integer'],
        'prix_en_points' => ['required', 'integer', 'min:1'],
        'id_admin' => ['required', 'integer'] ,// On part du principe que c'est l'ID de l'USER admin
         'depart' => ['nullable', 'string', ],
        'dest' => ['nullable', 'string'] ,
    ]);

    return DB::transaction(function () use ($data) {

        // Utilisation de lockForUpdate() pour éviter les conditions de concurrence
        $walletPassager = Portefeuille::where('user_id', $data['id_passager'])->lockForUpdate()->first();
        $walletChauffeur = Portefeuille::where('user_id', $data['id_chauffeur'])->lockForUpdate()->first();
        
        // Correction ici : on cherche par user_id pour être cohérent avec les autres
        $walletAdmin = Portefeuille::where('user_id', $data['id_admin'])->lockForUpdate()->first();

        if (!$walletPassager || !$walletChauffeur || !$walletAdmin) {
            return response()->json(['message' => 'Un ou plusieurs portefeuilles sont introuvables'], 404);
        }

        $total = (int)$data['prix_en_points'];

        if ($walletPassager->solde_points < $total) {
            return response()->json(['message' => 'Solde insuffisant'], 400);
        }

        // Calculs
        $montantChauffeur = intdiv($total * 60, 100);
        $commission = $total - $montantChauffeur;

        // Mises à jour des soldes
        $walletPassager->decrement('solde_points', $total);
        $walletChauffeur->increment('solde_points', $montantChauffeur);
        $walletAdmin->increment('solde_points', $commission);

        // Création de la course
        $course = Course::create([
            'id_passager' => $data['id_passager'],
            'id_chauffeur' => $data['id_chauffeur'],
            'statut_course' => 'En cours',
            'prix_en_points' => $total,
            'lieu_depart'=>$data['depart'] ,
            'lieu_dest'=>$data['dest'] ,
        ]);

        // Enregistrement paiement
        PaiementCourse::create([
            'id_course' => $course->id_course, // Vérifie que $primaryKey est défini dans le modèle Course
            'id_portefeuille_passager' => $walletPassager->id_portefeuille,
            'id_portefeuille_chauffeur' => $walletChauffeur->id_portefeuille,
            'id_portefeuille_admin' => $walletAdmin->id_portefeuille,
            'montant_total' => $total,
            'commission_points' => $commission,
            'montant_chauffeur' => $montantChauffeur,
            'statut' => 'Paye',
            'date_paiement' => now(),
        ]);

        return response()->json([
            'message' => 'Course créée et payée avec succès',
            'course' => $course
        ], 201);
    });
}

    /**
     *  Annuler et rembourser automatiquement
     */
    public function cancel(Request $request)
    {
        $id_course = $request->idcourse;
        return DB::transaction(function () use ($id_course) {

            $course = Course::lockForUpdate()->find($id_course);

            if (!$course)
                return response()->json(['message' => 'Course introuvable'], 404);

            if ($course->statut_course === 'Annulee')
                return response()->json(['message' => 'Course déjà annulée'], 422);

            $paiement = PaiementCourse::where('id_course', $course->id_course)
                ->lockForUpdate()
                ->first();

            if (!$paiement || $paiement->statut !== 'Paye')
                return response()->json(['message' => 'Aucun paiement à rembourser'], 422);

            $walletPassager = Portefeuille::lockForUpdate()->find($paiement->id_portefeuille_passager);
            $walletChauffeur = Portefeuille::lockForUpdate()->find($paiement->id_portefeuille_chauffeur);
            $walletAdmin = Portefeuille::lockForUpdate()->find($paiement->id_portefeuille_admin);

            $total = $paiement->montant_total;
            $montantChauffeur = $paiement->montant_chauffeur;
            $commission = $paiement->commission_points;

            //  Rembourse passager
            $walletPassager->solde_points += $total;
            $walletPassager->save();

            //  Retirer chauffeur
            $walletChauffeur->solde_points -= $montantChauffeur;
            $walletChauffeur->save();

            //  Retirer admin
            $walletAdmin->solde_points -= $commission;
            $walletAdmin->save();

            $paiement->statut = 'Rembourse';
            $paiement->save();

            $course->statut_course = 'Annulee';
            $course->save();

            return response()->json([
                'message' => 'Course annulée et remboursée',
                'course' => $course
            ]);
        });
    }
}
