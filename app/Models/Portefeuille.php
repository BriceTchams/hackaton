<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portefeuille extends Model
{
    use HasFactory;

    protected $table = 'portefeuilles';

    // Clé primaire personnalisée
    protected $primaryKey = 'id_portefeuille';

    // Auto-increment activé (par défaut true mais on le précise)
    public $incrementing = true;

    protected $keyType = 'int';

    // Pas de timestamps (car migration n’a pas timestamps())
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'solde_points',
        'date_derniere_maj',
    ];

    protected $casts = [
        'date_derniere_maj' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTHODES UTILES
    |--------------------------------------------------------------------------
    */

    public function crediter(int $points)
    {
        $this->solde_points += $points;
        $this->date_derniere_maj = now();
        $this->save();
    }

    public function debiter(int $points)
    {
        if ($this->solde_points < $points) {
            throw new \Exception("Solde insuffisant");
        }

        $this->solde_points -= $points;
        $this->date_derniere_maj = now();
        $this->save();
    }
}
