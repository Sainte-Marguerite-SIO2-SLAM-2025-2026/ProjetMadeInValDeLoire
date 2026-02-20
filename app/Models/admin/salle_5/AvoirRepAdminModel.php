<?php

namespace App\Models\admin\salle_5;

use CodeIgniter\Model;

class AvoirRepAdminModel extends Model
{
    protected $table = 'avoir_rep';
    protected $primaryKey = ['objet_id', 'activite_numero'];
    protected $returnType = 'object';
    protected $allowedFields = ['objet_id', 'activite_numero'];

    public function getNbRep()
    {
        return $this->countAllResults();
    }
}