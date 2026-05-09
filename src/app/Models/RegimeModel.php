<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table            = 'regimes';
    protected $primaryKey       = 'id';
    
    // Les champs modifiables
    protected $allowedFields    = [
        'nom', 
        'description', 
        'regime_user_id', 
        'calories', 
        'prix', 
        'duree_jours'
    ];
}