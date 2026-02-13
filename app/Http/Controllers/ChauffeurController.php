<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChauffeurController extends Controller
{
    /**
     * Récupérer tous les chauffeurs (Utile pour un Admin)
     */
    public function index()
    {
        $chauffeurs = Chauffeur::all();
        
     
        return response()->json(['status' => 'success', 'data' => $chauffeurs]);
    }

    /**
     * Récupérer les infos d'un chauffeur spécifique
     */
    public function show($id)
    {
        $chauffeur = Chauffeur::with('user')->where('id_user', $id)->first();

        if (!$chauffeur) {
            return response()->json(['message' => 'Chauffeur non trouvé'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $chauffeur]);
    }

    /**
     * Mettre à jour la position GPS (Pour Flutter)
     */
    public function updateLocation(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $chauffeur = Chauffeur::where('id_user', $id)->firstOrFail();
        $chauffeur->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Position mise à jour']);
    }

    /**
     * Valider ou Bloquer un chauffeur (Admin seulement)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'statut_validation' => 'required|in:En attente,Valide,Bloque'
        ]);

        $chauffeur = Chauffeur::where('id_user', $id)->firstOrFail();
        $chauffeur->update(['statut_validation' => $request->statut_validation]);

        return response()->json(['message' => 'Statut mis à jour avec succès']);
    }

 /**
 * Valider spécifiquement la création du compte (Admin seulement)
 */
        public function validateAccount($id)
        {
            // On cherche le chauffeur par son id_user
            $chauffeur = Chauffeur::where('id_user', $id)->first();

            if (!$chauffeur) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Chauffeur non trouvé.'
                ], 404);
            }

            // Mise à jour du statut vers 'Valide'
            $chauffeur->update([
                'statut_validation' => 'Valide'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Le compte du chauffeur a été validé avec succès. Il peut désormais se connecter et travailler.',
                'data' => $chauffeur
            ], 200);
        }
 
}