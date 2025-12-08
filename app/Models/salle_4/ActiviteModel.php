<?php

namespace App\Models\salle_4;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table = 'activite';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = [
        'libelle', 'verrouillage', 'image', 'malveillant',
        'difficulte_numero', 'salle_numero', 'auteur_numero',
        'type_numero', 'explication_numero'
    ];

    /**
     * Récupérer une activité
     */
    public function getActivite($numero)
    {
        return $this->find($numero);
    }


    /**
     * @param $id
     * @return array|bool[]|\bool[][]|float[]|\float[][]|int[]|\int[][]|null[]|\null[][]|object|object[]|\object[][]|string[]|\string[][]|null
     */
    public function getExplicationByActivite($id)
    {
        return $this->where('numero', $id)
            ->find('explication_numero');
    }
}