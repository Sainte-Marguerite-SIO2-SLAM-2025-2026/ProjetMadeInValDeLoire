<?php

namespace App\Models\salle_1;

use CodeIgniter\Model;

class Salle1Message extends Model
{
    protected $table = 'activite';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';

    /**
     * Récupère un message aléatoire de la salle 1 avec son auteur.
     * @return object|null
     */
    public function getMessageSalle1()
    {
        return $this->db->table('activite a')
            ->select('a.numero, a.libelle')
            ->where('a.salle_numero', 1)
            ->orderBy('RAND()')
            ->limit(1)
            ->get()
            ->getRow();
    }

    /**
     * Récupère tous les mots suspects (erreurs) pour une activité donnée.
     * @param int $activite_numero
     * @return array
     */
    public function getMotsSuspects(int $activite_numero): array
    {
        $erreurs = $this->db->table('erreur')
            ->select('mot_incorrect, explication')
            ->where('activite_numero', $activite_numero)
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
    public function getErreursAvecExplications(int $activite_numero): array
    {
        return $this->db->table('erreur')
            ->select('numero, mot_incorrect, explication')
            ->where('activite_numero', $activite_numero)
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les indices pour une activité donnée.
     * @param int $activite_numero
     * @return array
     */
    public function getIndices(int $activite_numero): array
    {
        return $this->db->table('avoir_indice ai')
            ->select('i.numero, i.libelle')
            ->join('indice i', 'i.numero = ai.indice_numero')
            ->where('ai.activite_numero', $activite_numero)
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère le mode d'emploi pour une activité.
     * @param int $activite_numero
     * @return object|null
     */
    public function getModeEmploi(int $activite_numero)
    {
        return $this->db->table('mode_emploi')
            ->select('explication_1, explication_2, explication_3')
            ->where('activite_numero', $activite_numero)
            ->get()
            ->getRow();
    }
}