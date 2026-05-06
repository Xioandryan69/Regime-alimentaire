<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table = 'note';
    protected $primaryKey = 'id';
    protected $allowedFields = ['etudiant_id', 'ue_id', 'note', 'created_at'];
    protected $useTimestamps = false;
}
