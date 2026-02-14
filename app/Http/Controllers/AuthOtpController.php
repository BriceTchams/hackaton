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
use App\Models\Portefeuille;
use Illuminate\Support\Facades\DB;
    

use Illuminate\Support\Facades\Log;

class AuthOtpController extends Controller
{
    private int $otpMinutes = 12;
    private int $maxAttempts = 5;

    // ================= LOGIN =================
    public function logina(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Identifiants invalides.'], 401);
        }

        $user = Auth::user();

     
    
        return redirect()->route('dashboard');
        // return response()->json([
        //     'message' => 'success.',
        //     'user' => $user
        // ]);
    }
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

    public function verifyOtp(Request $request){
        $data = $request->validate([
        'otp_id' => ['required','integer','exists:login_otps,id'],
        'code' => ['required','digits:6'],
        ]);

        $otp = LoginOtp::with('user')->find($data['otp_id']);

        // verifie si l'otp existe
        if (!$otp) {
            return response()->json([
                'message' => "otp inexistant"
            ]);
 
            }
            // verfie si l'otp est expire
           if (now()->greaterThan($otp->expires_at)) {
                return response()->json([
                'erreur' => "otp expiré"
            ]);
              }
            // verifie si le nombre de tentative a ete atteint
            if ($otp->attempts >= $this->maxAttempts) {
                return response()->json(['message'=>"trop de tentative "]);

              }

                  $otp->attempts++; // incremente le nombre de tentative
                 $otp->save();

                // verifie si le code correspon au code enregistrer 
                if (!Hash::check($data['code'], $otp->code_hash)) {
                       return response()->json(['message'=>"code incorrecte "]);
                 }

                //  / marquer utilisé
                $otp->used = true;
                $otp->save();

                    // créer session (cookie)
                //  Auth::loginUsingId($otp->id);
                // retour final si tout s'est bien passé

                $user = User::Where('id' , $otp->user_id)->get();

                 return response()->json([
                    'message' => 'Connexion validée.',
                    'user' => $user 

                ]);





    }



    // ================= REGISTER =================

   
        public function register(Request $request)
        {
            // 1. Validation stricte selon votre schéma SQL
           
    
                // 2. Utilisation d'une transaction pour éviter les comptes "orphelins"
                    
                    // Création dans la table 'utilisateur'
                    // Note : mot_de_passe doit être haché
                    $user = User::create([
                        'name' => $request->nom,
                        'prenom' => $request->prenom,
                        'email' => $request->email,
                        'telephone' => $request->telephone,
                        'password' => Hash::make($request->password),
                        'role' => $request->role,
                      
                    ]);
            //creation du portefeuille de l'utilisateur
                    Portefeuille::create([
                        'user_id' => $user->id,
                        'solde_points' => 0,
                        'date_derniere_maj' => now(),
                    ]);
    
                    // 3. Création dans les tables liées (id_user est la clé primaire/étrangère)
                    if ($request->role === 'admin') {
                        Admin::create([
                            'id_user' => $user->id,
                            'niveau_acces' => $request->niveau_acces,
                        ]);

                         return response()->json([
                        'status' => 'success',
                        'message' => 'Inscription réussie',
                        'data' => $user
                    ], 201);
                    } 
                   if ($request->role === 'passager') {
                        Passager::create([
                            'id_user' => $user->id,
                            'ville' => $request->ville,
                            'score_fidelit' => $request->score_fidelit,
                            
                        ]);
                         return response()->json([
                        'status' => 'success',
                        'message' => 'Inscription réussie',
                        'data' => $user
                    ], 201);
                    } 
                    if ($request->role === 'chauffeur') {
    
                        $path = null;

                        // // Vérification et enregistrement de l'image
                        if ($request->hasFile('photo_piece_identite')) {
                            $file = $request->file('photo_piece_identite');
                            
                            // Créer un nom unique : ID_USER_TIMESTAMP.EXTENSION
                            $fileName = 'cni_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            
                            // Stockage dans storage/app/public/pieces_identite
                            $path = $file->storeAs('pieces_identite', $fileName, 'public');
                        }

                        Chauffeur::create([
                            'id_user' => $user->id,
                            'numero_permis' => $request->numero_permis,
                            'photo_piece_identite' => $request->photo_piece_identite, // On enregistre le chemin relatif
                        ]);

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Inscription chauffeur réussie avec pièce d\'identité',
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
                    'status' => $user,
                    'message' => 'Une erreur est survenue lors de la création du compte.',
                ], 500);
        }




        
        
    }