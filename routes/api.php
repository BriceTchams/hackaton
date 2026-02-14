<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\PortefeuilleController;
use App\Http\Controllers\TransactionPointsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VehiculesController;



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

     // vehicule
        Route::prefix('vehicules')->group(function () {

        Route::post('/', [VehiculesController::class, 'store']);
        Route::get('/chauffeur/{id_chauffeur}', [VehiculesController::class, 'showByChauffeur']);
        Route::put('/{id_vehicule}', [VehiculesController::class, 'update']);
        Route::delete('/{id_vehicule}', [VehiculesController::class, 'destroy']);

    });

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

     //paiement course
         Route::post('/coursepay', [CourseController::class, 'store']);
         Route::post('/cancelcourse', [CourseController::class, 'cancel']);

});

   

// 
