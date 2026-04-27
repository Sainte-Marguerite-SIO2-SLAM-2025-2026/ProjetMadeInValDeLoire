<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ObjetsActiviteModel extends Model
{
    protected $table = 'objets_activite';
    protected $primaryKey = ['numero_activite', 'objet_id'];

    protected $allowedFields = ['numero_activite', 'objet_id'];

    /**
     * Retourne la liste des objet associés à une activité
     *
     * @param int $numero_activite
     * @return array
     */
    public function getObjetsActivite(int $numero_activite): array
    {
        return $this->select('objets_activite.*, objets.*')
            ->join('objets', 'objets.id = objets_activite.objet_id')
            ->where('numero_activite', $numero_activite)
            ->findAll();
    }
}