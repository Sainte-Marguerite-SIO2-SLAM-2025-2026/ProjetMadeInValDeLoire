<?php

namespace App\Models\salle_6;

use CodeIgniter\Model;

class Salle6Model extends Model
{
    protected $table      = 'salle';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle', 'bouton', 'intro_salle'];
    protected $returnType = 'array';

    /**
     * Récupère l'intitulé de la salle
     * @return array
     */
    public function getSalleById($numeroSalle)
    {
        return $this->where('numero', $numeroSalle)->first();
    }
}