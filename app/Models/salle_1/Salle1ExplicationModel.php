<?php

namespace App\Models\salle_1;

use CodeIgniter\Model;

class Salle1ExplicationModel extends Model
{
    protected $table = 'explication';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';

    /**
     * Récupère l'explication de la salle 1
     * @return string|null
     */
    public function getExplicationSalle1()
    {
        $row = $this->where('numero', 1)->first();
        return $row ? $row->libelle : null;
    }
}