<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class IndiceModel extends Model
{
    protected $table = 'indice';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['numero', 'libelle'];
    protected $returnType = 'object';

    /**
     * récupérer l'indice sur l'accueil de la salle 4
     */
    public function getIndice($numero)
    {
        return $this->find($numero);
    }
}