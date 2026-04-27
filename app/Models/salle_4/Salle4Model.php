<?php

namespace App\Models\salle_4;

use CodeIgniter\Model;

class Salle4Model extends Model
{
    protected $table = 'carte';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['image', 'explication', 'activite_numero', 'type_carte', 'explication_piege'];

    /**
     * Récupère les cartes liées à une activité donnée
     * IMPORTANT : Ne pas mélanger l'ordre ici, on garde l'ordre de la BDD
     */
    public function getCartesByActivite(int $activiteId): array
    {
        return $this->where('activite_numero', $activiteId)
            ->orderBy('rand()') // Ordre aléatoire
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

    /**
     * Récupère 8 cartes aléatoires pour l'activité 402 (bonnes pratiques vs pièges)
     * - Au moins 2 pièges
     * - Au moins 2 bonnes pratiques
     * - Total : 8 cartes
     *
     * @param int $activiteId L'ID de l'activité (402)
     * @return array Tableau de 8 cartes mélangées avec leurs informations
     */
    public function getCartesActivite402(int $activiteId = 402): array
    {
        // Récupérer toutes les bonnes pratiques de l'activité
        $bonnesPratiques = $this->where('activite_numero', $activiteId)
            ->where('type_carte', 'bonne_pratique')
            ->findAll();

        // Récupérer tous les pièges de l'activité
        $pieges = $this->where('activite_numero', $activiteId)
            ->where('type_carte', 'piege')
            ->findAll();

        // Vérifier qu'on a assez de cartes
        if (count($bonnesPratiques) < 2 || count($pieges) < 2) {
            throw new \Exception("Pas assez de cartes dans la base de données (minimum 2 bonnes pratiques et 2 pièges requis)");
        }

        // Mélanger les tableaux
        shuffle($bonnesPratiques);
        shuffle($pieges);

        // Définir combien de chaque type on veut (au moins 2 de chaque)
        $nbPieges = rand(2, min(4, count($pieges))); // Entre 2 et 4 pièges
        $nbBonnesPratiques = 8 - $nbPieges; // Le reste en bonnes pratiques

        // Vérifier qu'on a assez de bonnes pratiques
        if ($nbBonnesPratiques > count($bonnesPratiques)) {
            // Ajuster si pas assez de bonnes pratiques
            $nbBonnesPratiques = min($nbBonnesPratiques, count($bonnesPratiques));
            $nbPieges = 8 - $nbBonnesPratiques;
        }

        // Sélectionner les cartes
        $cartesSelectionnees = array_merge(
            array_slice($bonnesPratiques, 0, $nbBonnesPratiques),
            array_slice($pieges, 0, $nbPieges)
        );

        // Mélanger le résultat final
        shuffle($cartesSelectionnees);

        // Formater les données pour l'utilisation
        return array_map(function($carte) {
            return [
                'numero' => $carte['numero'],
                'image' => $carte['image'],
                'explication' => $carte['explication'],
                'type_carte' => $carte['type_carte'],
                'explication_piege' => $carte['explication_piege'] ?? null
            ];
        }, $cartesSelectionnees);
    }

    /**
     * Vérifie une carte pour l'activité 402
     * Le jeu se termine si :
     * - Le joueur clique sur un piège (échec)
     * - Toutes les bonnes pratiques sont trouvées (succès)
     *
     * @param int $numeroCarte Le numéro de la carte cliquée
     * @param array $cartesJouees Les numéros des cartes déjà jouées
     * @param array $toutesLesCartes Toutes les cartes de la partie (les 8 cartes)
     * @return array Résultat de la vérification
     */
    public function verifierCarte402(int $numeroCarte, array $cartesJouees, array $toutesLesCartes): array
    {
        // Récupérer les informations de la carte cliquée
        $carte = $this->find($numeroCarte);

        if (!$carte) {
            return [
                'erreur' => true,
                'message' => 'Carte introuvable'
            ];
        }

        $estBonnePratique = ($carte['type_carte'] === 'bonne_pratique');

        // Ajouter la carte aux cartes jouées
        $cartesJouees[] = $numeroCarte;

        // Compter le nombre de bonnes pratiques dans toutes les cartes
        $nbBonnesPratiques = 0;
        foreach ($toutesLesCartes as $c) {
            if ($c['type_carte'] === 'bonne_pratique') {
                $nbBonnesPratiques++;
            }
        }

        // Compter combien de bonnes pratiques ont été trouvées
        $bonnesPratiquesTouvees = count($cartesJouees);

        if (!$estBonnePratique) {
            // ÉCHEC : Le joueur a cliqué sur un piège
            return [
                'continuer' => false,
                'reussi' => false,
                'raison' => 'piege',
                'carte' => [
                    'numero' => $carte['numero'],
                    'image' => $carte['image'],
                    'explication' => $carte['explication'],
                    'type_carte' => $carte['type_carte'],
                    'explication_piege' => $carte['explication_piege']
                ],
                'score' => $bonnesPratiquesTouvees - 1, // -1 car on vient d'ajouter le piège
                'total_bonnes_pratiques' => $nbBonnesPratiques,
                'cartes_jouees' => $cartesJouees
            ];
        }

        // Le joueur a trouvé une bonne pratique
        if ($bonnesPratiquesTouvees === $nbBonnesPratiques) {
            // SUCCÈS : Toutes les bonnes pratiques ont été trouvées
            return [
                'continuer' => false,
                'reussi' => true,
                'raison' => 'toutes_trouvees',
                'carte' => [
                    'numero' => $carte['numero'],
                    'image' => $carte['image'],
                    'explication' => $carte['explication'],
                    'type_carte' => $carte['type_carte']
                ],
                'score' => $bonnesPratiquesTouvees,
                'total_bonnes_pratiques' => $nbBonnesPratiques,
                'cartes_jouees' => $cartesJouees
            ];
        }

        // Le jeu continue
        return [
            'continuer' => true,
            'reussi' => null,
            'carte' => [
                'numero' => $carte['numero'],
                'image' => $carte['image'],
                'explication' => $carte['explication'],
                'type_carte' => $carte['type_carte']
            ],
            'score' => $bonnesPratiquesTouvees,
            'total_bonnes_pratiques' => $nbBonnesPratiques,
            'cartes_jouees' => $cartesJouees,
            'message' => "Bonne pratique ! ({$bonnesPratiquesTouvees}/{$nbBonnesPratiques})"
        ];
    }

    /**
     * Récupère les détails des cartes jouées pour l'affichage final
     *
     * @param array $numerosCartes Tableau des numéros de cartes
     * @return array Détails des cartes
     */
    public function getDetailsCartes(array $numerosCartes): array
    {
        if (empty($numerosCartes)) {
            return [];
        }

        return $this->whereIn('numero', $numerosCartes)
            ->findAll();
    }
}