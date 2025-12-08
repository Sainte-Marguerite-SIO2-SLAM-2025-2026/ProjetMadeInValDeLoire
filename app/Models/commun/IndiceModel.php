<?php

namespace App\Models\commun;

use CodeIgniter\Model;

class IndiceModel extends Model
{
    protected $table = 'indice';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['numero', 'libelle'];
    protected $returnType = 'object';

    /**
     * récupérer l'indice sur l'accueil de la salle voulue
     */
    public function getIndice($numero)
    {
        return $this->find($numero);
    }
}