<?php

namespace App\Models\admin\salle_5;

use CodeIgniter\Model;

class ObjetsActiviteAdminModel extends Model
{
    protected $table = 'objets_activite';
    protected $primaryKey = ['numero_activite', 'objet_id'];

    protected $returnType = 'object';

    protected $allowedFields = ['numero_activite', 'objet_id'];

    public function getNbObjetActivite()
    {
        return $this->countAllResults();
    }

    public function getAllObjetsActivite()
    {
        return $this->select('objets_activite.*, objets.*')
            ->join('objets', 'objets.id = objets_activite.objet_id')
            ->findAll();
    }

    public function getObjetsActivite($numero, $objet_id)
    {
        return $this->where([
            'numero_activite' => $numero,
            'objet_id' => $objet_id
        ])->first();
    }

}