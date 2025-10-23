<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table = 'activite';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['libelle', 'verrouillage', 'image', 'malveillant', 'difficulte_numero', 'salle_numero', 'auteur_numero', 'type_numero', 'explication_numero'];

    // Récupérer 2 activités aléatoires pour une salle
    public function getActivitesAleatoires($salle_numero, $limit = 2)
    {
        return $this->where('salle_numero', $salle_numero)
            ->orderBy('RAND()')
            ->limit($limit)
            ->findAll();
    }
}