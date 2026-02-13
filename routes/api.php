<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Importation du contrôleur pour l'utiliser dans les routes
use App\Http\Controllers\AuthOtpController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



   Route::POST('/login' ,[AuthOtpController::class , 'login']
    ) ;
       Route::POST('/register' ,[AuthOtpController::class , 'register']
    ) ;

    Route::post('/verifyOtp' ,[AuthOtpController::class , 'verifyOtP']
    );


// Groupe de routes pour les passagers
// Route::middleware(['role:passager'])->group(function () {
    Route::get('/accueil', function(){
        return response()->json(['message' => 'Profil passager']);
    });
    
// });






Route::middleware(['role:chauffeur'])->group(function () {
    // Route::get('/mes-reservations', [TrajetController::class, 'mesReservations']);
});

Route::middleware(['role:admin'])->group(function () {
    // Route::get('/mes-reservations', [TrajetController::class, 'mesReservations']);
});