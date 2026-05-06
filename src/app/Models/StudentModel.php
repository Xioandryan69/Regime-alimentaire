<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'etudiant';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'email'];
    protected $useTimestamps = false;
}
