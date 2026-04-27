<?php

namespace App\Models\admin\salle_5;

use CodeIgniter\Model;

class ActiviteMessageAdminModel extends Model
{
    protected $table = 'activite_message';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['activite_numero', 'type_message', 'message'];

    public function getNbMessage()
    {
        return $this->countAllResults();
    }

    /**
     * Récupère les messages
     */
    public function getAllMessage()
    {
        return $this->FindAll();
    }

    /**
     * Récupère un message selon son id
     */
    public function getMessage(int $id)
    {
        return $this->where('id', $id)
            ->first();
    }

}