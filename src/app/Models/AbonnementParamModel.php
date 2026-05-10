<?php

namespace App\Models;

use CodeIgniter\Model;

class AbonnementParamModel extends Model
{
    protected $table = 'abonnement_params';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'code',
        'nom',
        'description',
        'prix',
        'remise',
        'duree_jours',
        'actif',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'code' => 'required|alpha_dash',
        'nom' => 'required|string|min_length[3]|max_length[100]',
        'prix' => 'required|numeric',
        'remise' => 'required|numeric',
        'duree_jours' => 'permit_empty|integer'
    ];
}
