<?php

namespace App\Models\admin\salle_4;

use CodeIgniter\Model;

class QuestionAdminModel extends Model
{
    protected $table = 'question';
    protected $primaryKey = 'numero';
    protected $allowedFields = [
        'libelle',
        'reponse',
        'activite_numero'
    ];
    protected $useTimestamps = false;

    /**
     * Récupère toutes les questions liées à la salle 4 (activités 400-499)
     */
    public function getAllQuestionsWithActivite()
    {
        return $this->select('question.*, activite.libelle as activite_libelle')
            ->join('activite', 'activite.numero = question.activite_numero', 'left')
            ->where('activite.numero >=', 400)
            ->where('activite.numero <=', 499)
            ->orderBy('question.numero', 'ASC')
            ->findAll();
    }

    /**
     * Récupère une question par son ID avec les infos de l'activité
     */
    public function getQuestionById($id)
    {
        return $this->select('question.*, activite.libelle as activite_libelle')
            ->join('activite', 'activite.numero = question.activite_numero', 'left')
            ->where('question.numero', $id)
            ->first();
    }

    /**
     * Récupère les questions par activité (seulement salle 4)
     */
    public function getQuestionsByActivite($activite_id)
    {
        return $this->where('activite_numero', $activite_id)
            ->where('activite_numero >=', 400)
            ->where('activite_numero <=', 499)
            ->orderBy('numero', 'ASC')
            ->findAll();
    }

    /**
     * Compte les questions par réponse (vrai/faux) pour la salle 4
     */
    public function countByReponse()
    {
        $db = \Config\Database::connect();

        $vrai = $db->table('question')
            ->join('activite', 'activite.numero = question.activite_numero', 'left')
            ->where('question.reponse', 1)
            ->where('activite.numero >=', 400)
            ->where('activite.numero <=', 499)
            ->countAllResults();

        $faux = $db->table('question')
            ->join('activite', 'activite.numero = question.activite_numero', 'left')
            ->where('question.reponse', 0)
            ->where('activite.numero >=', 400)
            ->where('activite.numero <=', 499)
            ->countAllResults();

        return [
            'vrai' => $vrai,
            'faux' => $faux
        ];
    }

    /**
     * Récupère les activités de la salle 4 pour les dropdown
     */
    public function getActivites()
    {
        $db = \Config\Database::connect();
        return $db->table('activite')
            ->select('numero, libelle')
            ->where('numero >=', 400)
            ->where('numero <=', 499)
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Compte toutes les questions de la salle 4
     */
    public function countQuestionsSalle4()
    {
        return $this->select('question.*')
            ->join('activite', 'activite.numero = question.activite_numero', 'left')
            ->where('activite.numero >=', 400)
            ->where('activite.numero <=', 499)
            ->countAllResults();
    }
}