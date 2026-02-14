<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementCourse extends Model
{
    protected $table = 'paiement_courses';
    protected $primaryKey = 'id_paiement';
    public $timestamps = false;

    protected $fillable = [
        'id_course',
        'id_portefeuille_passager',
        'id_portefeuille_chauffeur',
        'id_portefeuille_admin',
        'montant_total',
        'commission_points',
        'montant_chauffeur',
        'statut',
        'date_paiement',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
    ];
}
