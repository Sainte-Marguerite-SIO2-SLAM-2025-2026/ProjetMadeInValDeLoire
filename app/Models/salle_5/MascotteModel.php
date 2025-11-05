<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class MascotteModel extends Model
{
    protected $table = 'mascotte';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['image', 'humeur', 'salle_numero'];

    /**
     * Récupérer la mascotte d'une salle
     */
    public function getMascotteBySalle($salle_numero)
    {
        return $this->where('salle_numero', $salle_numero)->first();
    }
}