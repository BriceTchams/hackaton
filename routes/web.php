<?php
use App\Http\Controllers\AuthOtpController;
use App\Models\Chauffeur;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('welcome');
})->name('logout');

Route::get('/driver', function () {
    $drivers = DB::table('chauffeurs')
        ->join('users', 'chauffeurs.id_user', '=', 'users.id') // Jointure sur l'ID user
        ->select('users.name', 'users.email', 'chauffeurs.*') // On prend tout
        ->get();// On récupère tous les chauffeurs de la BDD
    return view('admin.drivers', compact('drivers'));
})->name('driver');

Route::post('/driver/verify', function (Illuminate\Http\Request $request) {
    // 1. On vérifie si l'ID arrive bien
    if (!$request->has('id_chauffeur')) {
        return redirect()->back()->with('error', 'ID manquant');
    }

    // 2. Mise à jour via Query Builder
    $affected = DB::table('chauffeurs')
        ->where('id_user', $request->id_chauffeur)
        ->update(['statut_validation' => 'Validé']);

    // 3. Retour avec message
    if ($affected) {
        $drivers = DB::table('chauffeurs')
        ->join('users', 'chauffeurs.id_user', '=', 'users.id') // Jointure sur l'ID user
        ->select('users.name', 'users.email', 'chauffeurs.*') // On prend tout
        ->get();// On récupère tous les chauffeurs de la BDD
    return view('admin.drivers', compact('drivers'));
        return redirect()->back()->with('success', 'Chauffeur validé !');
    }

    return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
})->name('driver.verify');


Route::get('/dashboard', function () {
    return view('admin.dashborad');
})->name('dashboard');

Route::post('/login', [AuthOtpController::class, 'logina'])->name('login');
