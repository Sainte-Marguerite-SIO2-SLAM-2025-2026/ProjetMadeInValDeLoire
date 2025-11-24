<?php

namespace App\Models\salle_6;

use CodeIgniter\Model;

class ExplicationModel extends Model
{
    protected $table = 'explication';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle'];

    /**
     * Récupère une explication par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getExplication(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupère toutes les explications
     * @return array
     */
    public function getAllExplications(): array
    {
        return $this->findAll();
    }
}