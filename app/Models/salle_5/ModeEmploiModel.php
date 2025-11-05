<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ModeEmploiModel extends Model
{
    protected $table = 'mode_emploi';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['explication_1', 'explication_2', 'explication_3', 'activite_numero'];

    /**
     * Récupérer le mode d'emploi d'une activité
     */
    public function getModeEmploiByActivite($activite_numero)
    {
        return $this->where('activite_numero', $activite_numero)->first();
    }
}