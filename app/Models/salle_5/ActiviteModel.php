<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table = 'activite';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = [
        'libelle', 'verrouillage', 'image', 'malveillant',
        'difficulte_numero', 'salle_numero', 'auteur_numero',
        'type_numero', 'explication_numero'
    ];


// Récupérer N activités aléatoires pour une salle
    /**
     * Récupérer N activités aléatoires pour une salle
     */
    public function getActivitesAleatoires($salle_numero, $limit = 2)
    {
        return $this->where('salle_numero', $salle_numero)
            ->orderBy('RAND()')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Récupérer plusieurs activités par leurs IDs
     */
    public function getActivitesByIds(array $ids)
    {
        return $this->whereIn('numero', $ids)->findAll();
    }

    /**
     * Récupérer une activité
     */
    public function getActivite($numero)
    {
        return $this->find($numero);
    }

    /**
     * Vérifier si une réponse est correcte
     */
    public function verifierReponse($activite_numero, $reponse)
    {
        $activite = $this->find($activite_numero);

        if (!$activite) {
            return [
                'valid' => false,
                'message' => 'Activité introuvable'
            ];
        }

        // Messages personnalisés par activité
        $messages = [
            2 => [
                'success' => 'Excellent ! Une clé USB inconnue est un risque majeur. Elle pourrait contenir un malware (attaque BadUSB).',
                'error' => 'Cette clé semble légitime. Réfléchissez : laquelle est la plus suspecte ?'
            ],
            // Ajoute d'autres activités ici
        ];

        $correct = ($reponse === 'B'); // USB anonyme pour l'activité 2

        return [
            'valid' => $correct,
            'message' => $correct ?
                ($messages[$activite_numero]['success'] ?? 'Bonne réponse !') :
                ($messages[$activite_numero]['error'] ?? 'Mauvaise réponse, réessayez !')
        ];
    }
}