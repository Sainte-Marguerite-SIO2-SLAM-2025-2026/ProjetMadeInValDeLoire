<?php

namespace App\Models\admin\salle_1;

use Closure;
use CodeIgniter\Model;

class AdminSalle1ActiviteModel extends Model
{

    protected $table = 'activites_salle1';
    protected $primaryKey = 'activite_numero';
    protected $allowedFields = ['libelle', 'difficulte_numero'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'libelle' => 'required|min_length[3]|max_length[1000]',
        'difficulte_numero' => 'required|integer|in_list[1,2,3]'
    ];

    protected $validationMessages = [
        'libelle' => [
            'required' => 'Le libellé est obligatoire',
            'min_length' => 'Le libellé doit contenir au moins 3 caractères'
        ],
        'difficulte_numero' => [
            'required' => 'La difficulté est obligatoire',
            'in_list' => 'La difficulté doit être 1, 2 ou 3'
        ]
    ];

    /**
     * Récupérer toutes les activités
     */
    public function getAllActivites()
    {
        return $this->orderBy('activite_numero', 'DESC')->findAll();
    }

    /**
     * Récupérer une activité par son ID
     */
    public function getActivite($id)
    {
        return $this->find($id);
    }

    /**
     * Ajouter une activité
     */
    public function addActivite($data)
    {
        return $this->insert($data);
    }

    /**
     * Modifier une activité
     */
    public function updateActivite($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Supprimer une activité et ses dépendances
     */
    public function deleteActivite($id)
    {
        // Supprimer d'abord les erreurs et indices liés
        $db = \Config\Database::connect();

        $db->table('erreurs_salle1')->where('activite_numero', $id)->delete();
        $db->table('indices_salle1')->where('activite_numero', $id)->delete();

        return $this->delete($id);
    }

    /**
     * Compter le nombre total d'activités
     */
    public function countActivites()
    {
        return $this->countAllResults();
    }

    /**
     * Récupérer les activités avec leurs statistiques
     */
    public function getActivitesWithStats()
    {
        return $this->select('activites_salle1.*, 
                            COUNT(DISTINCT erreurs_salle1.erreur_numero) as nb_erreurs,
                            COUNT(DISTINCT indices_salle1.indice_numero) as nb_indices')
            ->join('erreurs_salle1', 'erreurs_salle1.activite_numero = activites_salle1.activite_numero', 'left')
            ->join('indices_salle1', 'indices_salle1.activite_numero = activites_salle1.activite_numero', 'left')
            ->groupBy('activites_salle1.activite_numero')
            ->orderBy('activites_salle1.activite_numero', 'DESC')
            ->findAll();
    }
}