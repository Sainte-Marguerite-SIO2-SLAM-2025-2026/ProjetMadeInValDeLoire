<?php

namespace App\Models\admin\salle_5;

use CodeIgniter\Model;

class ObjetsActiviteAdminModel extends Model
{
    protected $table = 'objets_activite';
    protected $primaryKey = ['numero_activite', 'objet_id'];

    protected $allowedFields = ['numero_activite', 'objet_id'];

    public function getNbObjetActivite()
    {
        return $this->countAllResults();
    }
}