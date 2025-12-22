<?php

namespace App\Models\admin\salle_1;

use CodeIgniter\Model;

class AdminSalle1ErreurModel extends Model
{
    protected $table = 'erreurs_salle1';
    protected $primaryKey = 'erreur_numero';
    protected $allowedFields = ['activite_numero', 'mot_incorrect', 'explication'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'activite_numero' => 'required|integer',
        'mot_incorrect' => 'required|min_length[1]|max_length[255]',
        'explication' => 'required|min_length[3]|max_length[1000]'
    ];

    protected $validationMessages = [
        'activite_numero' => [
            'required' => 'L\'activité est obligatoire',
            'integer' => 'L\'activité doit être un nombre'
        ],
        'mot_incorrect' => [
            'required' => 'Le mot incorrect est obligatoire'
        ],
        'explication' => [
            'required' => 'L\'explication est obligatoire',
            'min_length' => 'L\'explication doit contenir au moins 3 caractères'
        ]
    ];

    /**
     * Récupérer toutes les erreurs avec info activité
     */
    public function getAllErreurs()
    {
        return $this->select('erreurs_salle1.*, activites_salle1.libelle as activite_libelle')
            ->join('activites_salle1', 'activites_salle1.activite_numero = erreurs_salle1.activite_numero', 'left')
            ->orderBy('erreurs_salle1.erreur_numero', 'DESC')
            ->findAll();
    }

    /**
     * Récupérer les erreurs d'une activité
     */
    public function getErreursByActivite($activiteId)
    {
        return $this->where('activite_numero', $activiteId)
            ->orderBy('erreur_numero', 'DESC')
            ->findAll();
    }

    /**
     * Récupérer une erreur
     */
    public function getErreur($id)
    {
        return $this->find($id);
    }

    /**
     * Ajouter une erreur
     */
    public function addErreur($data)
    {
        return $this->insert($data);
    }

    /**
     * Modifier une erreur
     */
    public function updateErreur($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Supprimer une erreur
     */
    public function deleteErreur($id)
    {
        return $this->delete($id);
    }

    /**
     * Compter le nombre total d'erreurs
     */
    public function countErreurs()
    {
        return $this->countAllResults();
    }

    /**
     * Compter les erreurs par activité
     */
    public function countByActivite($activiteId)
    {
        return $this->where('activite_numero', $activiteId)->countAllResults();
    }
}