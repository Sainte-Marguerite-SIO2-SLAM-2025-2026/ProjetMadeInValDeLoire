<?php

namespace App\Models\salle_4;

use CodeIgniter\Model;

class Salle4Model extends Model
{
    protected $table = 'carte';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['image', 'explication', 'activite_numero'];

    /**
     * Récupère les cartes liées à une activité donnée
     */
    public function getCartesByActivite(int $activiteId): array
    {
        return $this->where('activite_numero', $activiteId)
            ->findAll();
    }
}