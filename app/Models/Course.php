<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'id_course';
    public $timestamps = false;

    protected $fillable = [
        'id_passager',
        'id_chauffeur',
        'lieu_depart',
        'lieu_dest',
        'coordonnees_gps',
        'heure_demande',
        'heure_fin',
        'statut_course',
        'prix_en_points',
    ];

    protected $casts = [
        'heure_demande' => 'datetime',
        'heure_fin' => 'datetime',
    ];


      public function passager()
    {
        return $this->belongsTo(Passager::class, 'id_passager', 'id_user');
    }

    // 🔹 Une course appartient à un chauffeur
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class, 'id_chauffeur', 'id_user');
    }
}
