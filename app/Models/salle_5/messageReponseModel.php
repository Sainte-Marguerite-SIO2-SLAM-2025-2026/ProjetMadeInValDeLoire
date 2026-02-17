<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class messageReponseModel extends Model
{
    protected $table = 'activite_message';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['activite_numero', 'type_message', 'message'];

    /**
     * Récupère un message selon l'activité et le type
     * type_message : succes | echec | partiel
     */
    public function getMessage(int $activite_numero, string $type)
    {
        return $this->where('activite_numero', $activite_numero)
            ->where('type_message', $type)
            ->first();
    }

    public function getMessageSucces(int $activite_numero)
    {
        return $this->getMessage($activite_numero, 'succes');
    }

    public function getMessageEchec(int $activite_numero)
    {
        return $this->getMessage($activite_numero, 'echec');
    }
}