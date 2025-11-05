<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ExplicationModel extends Model
{
    protected $table = 'explication';  // ⬅️ OBLIGATOIRE
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['libelle'];

    /**
     * Récupérer une explication par son numéro
     */
    public function getExplication($numero)
    {
        return $this->find($numero);
    }
}