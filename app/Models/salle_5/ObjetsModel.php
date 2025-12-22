<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ObjetsModel extends Model
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

    public function getObjets()
    {
        return $this->findAll();
    }

    public function getObjetById($id)
    {
        return $this->find($id);
    }

    public function deleteObjet($id)
    {
        return $this->where('id', $id)->delete();
    }
}
