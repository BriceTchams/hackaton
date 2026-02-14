<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicule extends Model
{
    use HasFactory;

    protected $table = 'vehicules';
    protected $primaryKey = 'id_vehicule';
    public $timestamps = false;

    protected $fillable = [
        'id_chauffeur',
        'marque',
        'modele',
        'immatriculation',
        'couleur',
        'annee',
        'type',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // 🔹 Un véhicule appartient à un chauffeur
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class, 'id_chauffeur', 'id_user');
    }
}
