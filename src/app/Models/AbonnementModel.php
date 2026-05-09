<?php

namespace App\Models;

use CodeIgniter\Model;

class AbonnementModel extends Model
{
    protected $table = 'abonnements';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'type',
        'date_debut',
        'date_fin'
    ];
}