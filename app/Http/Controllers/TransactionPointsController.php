<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Portefeuille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionPointsController extends Controller
{
    /**
     * Recharge du portefeuille
     */
    public function recharge(Request $request)
    {
        $request->validate([
            'montant' => ['required','integer','min:1'],
        ]);

        $user = $request->iduser;

        // Récupérer portefeuille
        $portefeuille = Portefeuille::where('user_id', $user)->first();

        if (!$portefeuille) {
            return response()->json([
                'message' => 'Portefeuille introuvable'
            ], 404);
        }

        DB::transaction(function () use ($portefeuille, $request) {

            // 1️ Mise à jour du solde
            $portefeuille->solde_points += $request->montant/250;
            $portefeuille->date_derniere_maj = now();
            $portefeuille->save();

            //  Enregistrer transaction
            DB::table('transaction_points')->insert([
                'id_portefeuille' => $portefeuille->id_portefeuille,
                'type_mouv' => 'Recharge',
                'montant' => $request->montant,
                'valeur_points' => $request->montant/250 ,
                'date_heure' => now(),
            ]);
        });

        return response()->json([
            'message' => 'Recharge effectuée avec succès',
            'nouveau_solde' => $portefeuille->solde_points
        ]);
    }

    /**
     * 🔹 Historique des transactions
     */
    public function historique(Request $request)
    {
        $user = $request->iduser;

        $portefeuille = Portefeuille::where('user_id', $user)->first();

        if (!$portefeuille) {
            return response()->json([
                'message' => 'Portefeuille introuvable'
            ], 404);
        }

        $transactions = DB::table('transaction_points')
            ->where('id_portefeuille', $portefeuille->id_portefeuille)
            ->orderByDesc('date_heure')
            ->get();

        return response()->json($transactions);
    }
}
