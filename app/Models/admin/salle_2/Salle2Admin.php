<?php

namespace App\Models;

use CodeIgniter\Model;

class Salle2Admin extends Model
{
    // Ce modèle servira de "Dashboard" pour gérer plusieurs tables,
    // donc on n'utilise pas la propriété $table par défaut ici,
    // on utilisera le Query Builder ($this->db->table).

    /**
     * Récupère les explications (Numéro et Libellé)
     * Correspond à la table 'explication' de ton diagramme.
     */
    public function getExplications()
    {
        return $this->db->table('explication')
            ->select('numero, libelle')
            // ASTUCE : Ta vue HTML attend une colonne 'id' pour les boutons delete/edit.
            // Comme ton diagramme indique que 'numero' est la clé, on crée un alias.
            ->select('numero as id')
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getIndices()
    {
        return $this->db->table('indice')
            ->select('numero, libelle')
            ->select('numero as id') // Alias pour le HTML
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getMdps()
    {
        return $this->db->table('mot_de_passe')
            ->select('numero, motPasse, Valeur')
            ->select('numero as id') // Alias pour le HTML
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }
}