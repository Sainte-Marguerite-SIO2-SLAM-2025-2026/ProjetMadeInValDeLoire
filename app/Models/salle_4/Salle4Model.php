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
     * IMPORTANT : Ne pas mélanger l'ordre ici, on garde l'ordre de la BDD
     */
    public function getCartesByActivite(int $activiteId): array
    {
        return $this->where('activite_numero', $activiteId)
            ->orderBy('rand()')// Ordre de la base de données
            ->findAll();
    }

    /**
     * Vérifie si l'ordre des cartes est correct
     * Compare les numéros de carte dans l'ordre donné par l'utilisateur
     */
    public function verifierOrdre(int $activiteId, array $ordreUtilisateur): array
    {
        // Récupérer les cartes dans l'ordre correct (ordre de la BDD)
        $cartesCorrectes = $this->where('activite_numero', $activiteId)
            ->orderBy('numero', 'ASC')
            ->findAll();

        // L'ordre correct est basé sur le champ 'numero' de la BDD
        $ordreCorrect = array_column($cartesCorrectes, 'numero');

        // Comparer les deux tableaux
        $estCorrect = ($ordreUtilisateur === $ordreCorrect);

        return [
            'correct' => $estCorrect,
            'ordre_correct' => $ordreCorrect,
            'ordre_utilisateur' => $ordreUtilisateur,
            'details' => array_map(function ($carte) {
                return [
                    'numero' => $carte['numero'],
                    'explication' => $carte['explication']
                ];
            }, $cartesCorrectes)
        ];
    }
}