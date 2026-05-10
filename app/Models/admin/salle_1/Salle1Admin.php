<?php

namespace App\Models\admin\salle_1;

use CodeIgniter\Model;

class Salle1Admin extends Model
{
    protected $table = 'activite';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';

    /**
     * Récupère un message aléatoire de la salle 1 avec son auteur.
     * @return object|null
     */
    public function getTousMessageSalle1()
    {
        return $this->db->table('activite a')
            ->select('a.numero, a.libelle')
            ->where('a.salle_numero', 1)
            ->orderBy('RAND()')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère tous les mots suspects (erreurs) pour une activité donnée.
     * @param int $activite_numero
     * @return array
     */
    public function getTousMotsSuspects(int $activite_numero): array
    {
        $erreurs = $this->db->table('erreur')
            ->select('mot_incorrect, explication')
            ->get()
            ->getResultArray();

        // Retourne uniquement les mots incorrects
        return array_column($erreurs, 'mot_incorrect');
    }

    /**
     * Récupère toutes les erreurs avec leurs explications pour une activité.
     * @param int $activite_numero
     * @return array
     */
    public function getTousErreursAvecExplications(int $activite_numero): array
    {
        return $this->db->table('erreur')
            ->select('numero, mot_incorrect, explication')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les indices pour une activité donnée.
     * @param int $activite_numero
     * @return array
     */
    public function getTousIndices(int $activite_numero): array
    {
        return $this->db->table('avoir_indice ai')
            ->select('i.numero, i.libelle')
            ->join('indice i', 'i.numero = ai.indice_numero')
            ->get()
            ->getResultArray();
    }
}