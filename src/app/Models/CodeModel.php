<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table = 'codes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'code',
        'valeur',
        'utilise'
    ];

    public function trouverValide(string $code): ?array
    {
        $normalizedCode = strtoupper(trim($code));

        return $this->where('utilise', 0)
            ->where('code', $normalizedCode)
            ->first();
    }

    public function marquerUtilise(int $codeId): bool
    {
        return (bool) $this->update($codeId, ['utilise' => 1]);
    }
}