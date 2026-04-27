<?php

namespace App\Models\admin\salle_5;

use CodeIgniter\Model;

class objetAdminModel extends Model
{
    protected $table      = 'objets';
    protected $primaryKey = 'id';

    protected $returnType = 'object';

    protected $allowedFields = [
        'nom',
        'x',
        'y',
        'width',
        'height',
        'image',
        'reponse',
        'zone_path',
        'texte',
        'texte_x',
        'texte_y',
        'rotate',
        'drag',
        'hover',
        'cliquable',
        'ratio'
    ];

    public function getNbObjets(){
        return $this->countAllResults();
    }

    public function getAllObjets()
    {
        return $this->findAll();
    }

    public function getObjetById($id)
    {
        return $this->find($id);
    }
}