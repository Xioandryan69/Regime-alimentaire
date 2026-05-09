<?php

namespace App\Models;

use CodeIgniter\Model;

class UserObjectifModel extends Model
{
    protected $table = 'user_objectifs';
    protected $primaryKey = null;

    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'objectif_id'
    ];
}