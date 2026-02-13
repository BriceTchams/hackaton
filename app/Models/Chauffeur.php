<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chauffeur extends Model
{
    use HasFactory;

    protected $table = 'chauffeurs';

    protected $primaryKey = 'user_id';

    public $incrementing = false;
        public $timestamps = false; 


    protected $fillable = [
        'id_user',
        'numero_permis',
        'photo_piece_identite',
        'statut_validation',
        'note_moyenne',
        'latitude',
        'longitude',
        'est_en_ligne'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
    return  $this->belongsTo(User::class, 'id_user');   }
}
