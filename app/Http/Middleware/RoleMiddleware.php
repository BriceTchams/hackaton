<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return response()->json(['message' => 'Non authentifié.'], 401);
        }

        $user = Auth::user();

        // 2. Vérifier si le rôle de l'utilisateur est dans la liste autorisée
        // Note : On suppose que votre table 'users' a une colonne 'role'
        if (!in_array($user->role, $roles)) {
            return response()->json([
                'message' => 'Accès refusé. Rôle insuffisant.'
            ], 403);
        }

        return $next($request);
    }
}