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

Route::get('/login' ,function (){
    return response()->json(['data' , "brice"]);
}

);
// Route::post('/verifyOtp' ,[AuthOtpController::class , 'verifyOtP']
// );


