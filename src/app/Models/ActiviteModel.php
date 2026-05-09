<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table = 'activites';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'description',
        'calories_brulees',
        'duree_minutes'
    ];
}