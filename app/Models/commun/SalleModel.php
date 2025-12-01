<?php

namespace App\Models\commun;

use CodeIgniter\Model;

class SalleModel extends Model
{
    protected $table = 'salle';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle', 'bouton','intro_salle'];

    public function getSalleById($num) : array
    {
        $salle = $this->find($num);

        return [
            'libelle' => $salle['libelle'],
            'bouton' => $salle['bouton'],
            'intro_salle' => $salle['intro_salle']
        ];
    }
}