<?php

namespace App\Models\salle_4;

use CodeIgniter\Model;

class ExplicationModel extends Model
{
    protected $table = 'explication';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle'];

    function getExplication($numero)
    {
        return $this->find($numero);
    }
}