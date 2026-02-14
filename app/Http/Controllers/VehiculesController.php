<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculesController extends Controller
{
    /**
     * ✅ Ajouter un véhicule
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_chauffeur' => ['required','integer','exists:chauffeurs,id_user'],
            'marque' => ['nullable','string','max:100'],
            'modele' => ['nullable','string','max:100'],
            'immatriculation' => ['nullable','string','max:50','unique:vehicules,immatriculation'],
            'couleur' => ['nullable','string','max:50'],
            'annee' => ['nullable','integer'],
            'type' => ['nullable','string']
        ]);

        $vehicule = Vehicule::create($data);

        return response()->json([
            'message' => 'Véhicule ajouté avec succès',
            'vehicule' => $vehicule
        ], 201);
    }

    /**
     * ✅ Voir véhicule d’un chauffeur
     */
    public function showByChauffeur($id_chauffeur)
    {
        $vehicule = Vehicule::where('id_chauffeur', $id_chauffeur)->first();

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule introuvable'], 404);
        }

        return response()->json($vehicule);
    }

    /**
     * ✅ Modifier un véhicule
     */
    public function update(Request $request, $id_vehicule)
    {
        $vehicule = Vehicule::find($id_vehicule);

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule introuvable'], 404);
        }

        $vehicule->update($request->only([
            'marque',
            'modele',
            'immatriculation',
            'couleur',
            'annee',
            'type'
        ]));

        return response()->json([
            'message' => 'Véhicule mis à jour',
            'vehicule' => $vehicule
        ]);
    }

    /**
     * ❌ Supprimer véhicule
     */
    public function destroy($id_vehicule)
    {
        $vehicule = Vehicule::find($id_vehicule);

        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule introuvable'], 404);
        }

        $vehicule->delete();

        return response()->json([
            'message' => 'Véhicule supprimé'
        ]);
    }
}
