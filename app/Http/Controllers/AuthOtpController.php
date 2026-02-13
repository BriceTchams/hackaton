<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthOtpController extends Controller
{
    private int $otpMinutes = 12;
    private int $maxAttempts = 5;

    /**
     * 1) Vérifie email/password, génère OTP, envoie email.
     * Retourne otp_id.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Identifiants invalides.'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Optionnel: invalider les anciens OTP non utilisés
        LoginOtp::where('user_id', $user->id)
            ->where('used', false)
            ->update(['used' => true]);

        $code = (string) random_int(100000, 999999);

        $otp = LoginOtp::create([
            'user_id'    => $user->id,
            'code_hash'  => Hash::make($code),
            'expires_at' => now()->addMinutes($this->otpMinutes),
            'attempts'   => 0,
            'used'       => false,
        ]);

        Mail::to($user->email)->send(new LoginOtpMail($code));

        // Important: on ne renvoie PAS le code
        return response()->json([
            // 'message' => 'OTP envoyé par mail.',
            // 'otp_id'  => $otp->id,
            'user_id' => $user->id,
            'user'=>$user
        ]);
    }

    /**
     * 2) Vérifie OTP, crée token Sanctum, renvoie user + profil (admin/chauffeur/passager)
     */
    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'otp_id' => ['required', 'integer', 'exists:login_otps,id'],
            'code'   => ['required', 'digits:6'],
        ]);

        $otp = LoginOtp::with('user')->find($data['otp_id']);

        if (!$otp) {
            return response()->json(['message' => 'OTP inexistant.'], 404);
        }

        if ($otp->used) {
            return response()->json(['message' => 'OTP déjà utilisé.'], 409);
        }

        if (now()->greaterThan($otp->expires_at)) {
            return response()->json(['message' => 'OTP expiré.'], 410);
        }

        if ($otp->attempts >= $this->maxAttempts) {
            return response()->json(['message' => 'Trop de tentatives.'], 429);
        }

        // incrémente tentative à chaque essai
        $otp->attempts++;
        $otp->save();

        if (!Hash::check($data['code'], $otp->code_hash)) {
            return response()->json(['message' => 'Code incorrect.'], 422);
        }

        // Marquer utilisé
        $otp->used = true;
        $otp->save();

        /** @var \App\Models\User $user */
        $user = User::Where('id' , $otp->user_id)->get();

                 return response()->json([
                    'message' => 'Connexion validée.',
                    'user' => $user

                ]);

    }

    /**
     * Logout: supprimer le token courant.
     */
    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        // $user = $request->user();

        // if ($user && $request->user()->currentAccessToken()) {
        //     $request->user()->currentAccessToken()->delete();
        // }

        // return response()->json(['message' => 'Déconnecté.']);
    }
}
