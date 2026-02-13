<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passager extends Model
{
    protected $table = 'passager'; // Si c'est 'passagers' dans votre DB, ajoutez le 's'
    // Indiquez le nom exact de la table
    
    // Indiquez la clé primaire personnalisée
    protected $primaryKey = 'id_user'; 
    
    // TRÈS IMPORTANT : Désactivez l'auto-incrément car l'ID vient de la table utilisateur
    public $incrementing = false; 
    
    // Désactivez les timestamps si les colonnes created_at/updated_at n'existent pas
    public $timestamps = false; 

    // AUTORISEZ l'id_user à être rempli manuellement
    protected $fillable = [
        'id_user', 
        'score_fidelite'
    ];
}
