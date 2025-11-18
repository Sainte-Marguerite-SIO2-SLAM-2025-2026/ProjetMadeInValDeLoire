<?php

namespace App\Models\salle_1;

use CodeIgniter\Model;

class Salle1Message extends Model
{
    protected $table = 'activite';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';

    /**
     * Récupère un message aléatoire de la salle 1 avec son auteur et le nombre d'erreurs.
     * @return object|null
     */
    public function getMessageSalle1()
    {
        return $this
            ->select('libelle')
            ->orderBy('RAND()')
            ->limit(1)
            ->first();
    }
}