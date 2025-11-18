<?php

namespace App\Models\salle_1;

use CodeIgniter\Model;

class Salle1Erreur extends Model
{
    protected $table = 'erreurs';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';

    /**
     * Récupère un message aléatoire de la salle 1 avec son auteur et le nombre d'erreurs.
     * @return object|null
     */
    public function getErreurSalle1()
    {
        return $this
            ->select('mot_incorrect, explication')
            ->where('activite_numero', getMessageSalle1())
            ->findAll();
    }
}