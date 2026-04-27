<?php

namespace App\Models\admin\salle_2;

use CodeIgniter\Model;

/**
 * Modèle d’administration pour la Salle 2.
 * Fournit des accès listés aux tables explication, indice et mot_de_passe,
 * ainsi que des opérations génériques d’insertion/mise à jour/suppression
 * pilotées par le type d’élément.
 */
class Salle2Admin extends Model
{
    /**
     * Récupère les explications (numéro < 100), triées par numéro croissant.
     * @return array Liste des lignes: {id, numero, libelle}
     */
    public function getExplications()
    {
        return $this->db->table('explication')
            ->select('numero as id, numero, libelle')
            -> where('numero < 100')
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les indices (numéro < 300), triés par numéro croissant.
     * @return array Liste des lignes: {id, numero, libelle}
     */
    public function getIndices()
    {
        return $this->db->table('indice')
            ->select('numero as id, numero, libelle')
            -> where('numero < 300')
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les mots de passe triés par numéro croissant.
     * @return array Liste des lignes: {id, numero, motPasse, Valeur}
     */
    public function getMdps()
    {
        return $this->db->table('mot_de_passe')
            ->select('numero as id, numero, motPasse, Valeur')
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Enregistre un élément générique selon son type.
     * - type=explication: écrit numero, libelle
     * - type=indice:      écrit numero, libelle
     * - type=mdp:         écrit numero, motPasse, Valeur
     *
     * Si $ancienNumero est fourni, effectue une mise à jour (WHERE numero = $ancienNumero),
     * sinon effectue une insertion.
     *
     * @param string $type         'explication' | 'indice' | 'mdp'
     * @param array  $data         Données brutes issues du formulaire: {numero, description, valeur}
     * @param string|null $ancienNumero Numero existant (pour update), sinon null (insert)
     * @return bool true si l’opération a réussi, false sinon
     */
    public function saveElement(string $type, array $data, ?string $ancienNumero = null): bool
    {
        $table  = '';
        $dbData = [];

        if ($type === 'explication') {
            $table  = 'explication';
            $dbData = [
                'numero'  => (int) $data['numero'],
                'libelle' => (string) $data['description'],
            ];
        } elseif ($type === 'indice') {
            $table  = 'indice';
            $dbData = [
                'numero'  => (int) $data['numero'],
                'libelle' => (string) $data['description'],
            ];
        } elseif ($type === 'mdp') {
            $table  = 'mot_de_passe';
            $dbData = [
                'numero'   => (int) $data['numero'],
                'motPasse' => (string) $data['description'],
                'Valeur'   => (string) ($data['valeur'] ?? ''),
            ];
        } else {
            return false;
        }

        if (!empty($ancienNumero)) {
            // Mise à jour par clé fonctionnelle 'numero'
            return (bool) $this->db->table($table)
                ->where('numero', (int) $ancienNumero)
                ->update($dbData);
        }

        // Insertion
        return (bool) $this->db->table($table)->insert($dbData);
    }

    /**
     * Supprime un élément générique par son type et son numéro.
     *
     * @param string $type   'explication' | 'indice' | 'mdp'
     * @param int    $numero Numéro (clé fonctionnelle) de la ligne à supprimer
     * @return bool true si la suppression a eu lieu, false sinon
     */
    public function deleteElement(string $type, int $numero): bool
    {
        $table = '';
        if ($type === 'explication') {
            $table = 'explication';
        } elseif ($type === 'indice') {
            $table = 'indice';
        } elseif ($type === 'mdp') {
            $table = 'mot_de_passe';
        } else {
            return false;
        }

        if ($table && $numero > 0) {
            return (bool) $this->db->table($table)->where('numero', $numero)->delete();
        }

        return false;
    }
}