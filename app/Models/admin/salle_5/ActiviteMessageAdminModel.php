<?php

namespace App\Models\admin\salle_5;

use CodeIgniter\Model;

class ActiviteMessageAdminModel extends Model
{
    protected $table = 'activite_message';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['activite_numero', 'type_message', 'message'];

    public function getNbMessageSucces()
    {
        return $this->where('type_message', "succes")
            ->countAllResults();
    }

    public function getNbMessageEchec()
    {
        return $this->where('type_message', "echec")
        ->countAllResults();
    }
}