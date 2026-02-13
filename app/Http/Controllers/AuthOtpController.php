<?php

namespace App\Http\Controllers;

use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use App\Models\User;
use App\Models\Admin; // Changed from admin
use App\Models\Chauffeur;
use App\Models\Passager; // Changed from passager
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
    

use Illuminate\Support\Facades\Log;

class AuthOtpController extends Controller
{
    private int $otpMinutes = 12;
    private int $maxAttempts = 5;

    // ================= LOGIN =================

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Identifiants invalides.'], 401);
        }

        $user = Auth::user();

        LoginOtp::where('user_id', $user->id)
            ->where('used', false)
            ->update(['used' => true]);

        $code = (string) random_int(100000, 999999);

        $otp = LoginOtp::create([
            'user_id' => $user->id,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes($this->otpMinutes),
            'attempts' => 0,
            'used' => false
        ]);

        Mail::to($user->email)->send(new LoginOtpMail($code));

        return response()->json([
            'message' => 'OTP envoyé par mail.',
            'otp_id' => $otp->id
        ]);
    }

    // ================= REGISTER =================

   
    
 
        public function register(Request $request)
        {
            // 1. Validation stricte selon votre schéma SQL
            $validated = $request->validate([
                'nom' => ['required', ],
                'prenom' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', ],
                'telephone' => ['required', ],
                'password' => ['required', ],
                'role' => ['required', ], // Respecter la casse ENUM
                
                // Champs spécifiques
                'niveau_acces' => ['nullable',],
                'numero_permis' => ['nullable', 'max:50'],
                'photo_piece_identite' => ['nullable', 'string', 'max:255'],
            ]);
    
                // 2. Utilisation d'une transaction pour éviter les comptes "orphelins"
                    
                    // Création dans la table 'utilisateur'
                    // Note : mot_de_passe doit être haché
                    $user = User::create([
                        'name' => $validated['nom'],
                        'prenom' => $validated['prenom'],
                        'email' => $validated['email'],
                        'telephone' => $validated['telephone'],
                        'password' => Hash::make($validated['password']),
                        'role' => $validated['role'],
                    ]);
    
                    // 3. Création dans les tables liées (id_user est la clé primaire/étrangère)
                    if ($validated['role'] === 'admin') {
                        Admin::create([
                            'id_user' => $user->id_user,
                            'niveau_acces' => $validated['niveau_acces']
                        ]);

                         return response()->json([
                        'status' => 'success',
                        'message' => 'Inscription réussie',
                        'data' => $user
                    ], 201);
                    } 
                    elseif ($validated['role'] === 'chauffeur') {
                        Chauffeur::create([
                            'id_user' => $user->id_user,
                            'numero_permis' => $validated['numero_permis'],
                            'photo_piece_identite' => $validated['photo_piece_identite'] ?? null,
                            
                        ]);
                         return response()->json([
                        'status' => 'success',
                        'message' => 'Inscription réussie',
                        'data' => $user
                    ], 201);
                    } 
                    elseif ($validated['role'] === 'passager') {
                        Passager::create([
                            'id_user' => $user->id_user,
                            'score_fidelite' => 0,
                            'ville'=>$request->ville

                        ]);
                         return response()->json([
                        'status' => 'success',
                        'message' => 'Inscription réussie',
                        'data' => $user

                    ], 201);
                    }
                    //dsfdsfdsf
    
                    // return response()->json([
                    //     'status' => 'success',
                    //     'message' => 'Inscription réussie',
                    //     'data' => $usersddsf
                    // ], 201);
    
                // En cas d'erreur, on log pour débugger et on renvoie une réponse JSON
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Une erreur est survenue lors de la création du compte.',
                ], 500);
        }
        
    }

