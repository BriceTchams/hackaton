<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Portefeuille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortefeuilleController extends Controller
{
    /**
     *  Afficher le portefeuille de l'utilisateur connecté
     */
    public function show(Request $request)
    {
        $iduser = $request->iduser;

        $portefeuille = Portefeuille::where('user_id', $iduser)->first();

        if (!$portefeuille) {
            return response()->json([
                'message' => 'Portefeuille introuvable'
            ], 404);
        }

        return response()->json($portefeuille);
    }

 
 
}
