<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class SalleModel extends Model
{
    protected $table = 'salle';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['libelle', 'bouton', 'image', 'intro_salle'];

    /**
     * Récupérer une salle par son numéro
     */
    public function getSalle($numero)
    {
        return $this->find($numero);
    }
}