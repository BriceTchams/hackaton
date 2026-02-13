<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\PortefeuilleController;
use App\Http\Controllers\TransactionPointsController;

// use App\Models\Portefeuille;

/*
|--------------------------------------------------------------------------
| API Routes (Sans Middlewares)
|--------------------------------------------------------------------------
*/

// --- AUTHENTIFICATION ---
Route::post('/register', [AuthOtpController::class, 'register']);
Route::post('/login', [AuthOtpController::class, 'login']);
Route::post('/verifyOtp', [AuthOtpController::class, 'verifyOtp']);

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/chauffeurs', [ChauffeurController::class, 'index']);
    Route::get('/chauffeurs/{id}', [ChauffeurController::class, 'show']);
    Route::patch('/chauffeurs/{id}/validate', [ChauffeurController::class, 'validateAccount']);
    Route::patch('/chauffeurs/{id}/status', [ChauffeurController::class, 'updateStatus']);

    // porte feuille
 Route::post('/wallet/show', [PortefeuilleController::class, 'show']);
    Route::post('/wallet/recharge', [TransactionPointsController::class, 'recharge']);
     Route::get('/wallet/historique', [TransactionPointsController::class, 'historique']);

});

//chauffeur
Route::group(['prefix' => 'chauffeur'], function () {
    Route::patch('/location/{id}', [ChauffeurController::class, 'updateLocation']);
    Route::get('/profile/{id}', [ChauffeurController::class, 'show']);
    //porteffeuille
  Route::post('/wallet/show', [PortefeuilleController::class, 'show']);
    Route::post('/wallet/recharge', [TransactionPointsController::class, 'recharge']);
     Route::get('/wallet/historique', [TransactionPointsController::class, 'historique']);

});

//passager
Route::group(['prefix' => 'passager'], function () {
    Route::patch('/location/{id}', [ChauffeurController::class, 'updateLocation']);
    Route::get('/liste-chauffeurs', [ChauffeurController::class, 'index']);
    Route::get('/recherche/{id}', [ChauffeurController::class, 'show']);
    //portefeuille
    Route::post('/wallet/show', [PortefeuilleController::class, 'show']);
    Route::post('/wallet/recharge', [TransactionPointsController::class, 'recharge']);
     Route::get('/wallet/historique', [TransactionPointsController::class, 'historique']);
});


// 
