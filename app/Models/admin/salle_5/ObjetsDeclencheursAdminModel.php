<?php

namespace App\Models\admin\salle_5;

use CodeIgniter\Model;

class ObjetsDeclencheursAdminModel extends Model
{
    protected $table = 'objet_declencheur_enigme';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id', 'nom', 'x', 'y', 'image_path',
        'width', 'height', 'zone_path', 'clip_path_name',
        'visible_si_selectionnee', 'visible_si_non_reussie', 'numero_activite'
    ];

    public function getNbObjetsDeclencheurs(){
        return $this->countAllResults();
    }
}