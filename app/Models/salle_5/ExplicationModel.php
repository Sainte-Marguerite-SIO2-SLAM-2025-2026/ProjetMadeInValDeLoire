<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ExplicationModel extends Model
{
    protected $table = 'explication';  // ⬅️ OBLIGATOIRE
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['libelle'];
}