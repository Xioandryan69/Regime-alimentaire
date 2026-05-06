<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table = 'ue';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'nom', 'credits'];
    protected $useTimestamps = false;
}
