<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $DBGroup = 'dbQuizz';   // <- utiliser la seconde base celle du Quizz
    protected $table = 'question';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle', 'niveau_difficulte'];
    protected $returnType = 'array';

    /**
     * Récupère une question avec ses propositions et catégories
     */
    public function getQuestionComplete($numeroQuestion)
    {
        $question = $this->find($numeroQuestion);
        if (!$question) {
            return null;
        }
        // Propositions
        $builder = $this->db->table('question_proposition qp');
        $builder->select('p.numero, p.libelle, qp.bonne_reponse');
        $builder->join('proposition p', 'p.numero = qp.numero_proposition');
        $builder->where('qp.numero_question', $numeroQuestion);
        $propositions = $builder->get()->getResultArray();

        // Catégories
        $builderCat = $this->db->table('question_categorie qc');
        $builderCat->select('c.id, c.nom, c.theme');
        $builderCat->join('categorie c', 'c.id = qc.categorie_id');
        $builderCat->where('qc.question_numero', $numeroQuestion);
        $categories = $builderCat->get()->getResultArray();

        $question['propositions'] = $propositions;
        $question['categories'] = $categories;

        return $question;
    }


    /**
     * Récupère des questions aléatoires selon des critères
     */
    public function getQuestionsAleatoires($nombre = 10, $categorieId = null, $niveauDifficulte = null)
    {
        $builder = $this->builder();

        if ($categorieId) {
            $builder->join('question_categorie qc', 'qc.question_numero = question.numero');
            $builder->where('qc.categorie_id', $categorieId);
        }

        if ($niveauDifficulte) {
            $builder->where('niveau_difficulte', $niveauDifficulte);
        }

        $builder->orderBy('RAND()');
        $builder->limit($nombre);

        return $builder->get()->getResultArray();
    }

    /**
     * Vérifie si une réponse est correcte
     */
    public function verifierReponse($numeroQuestion, $numeroProposition)
    {
        return $this->db->table('question_proposition')
                ->where('numero_question', $numeroQuestion)
                ->where('numero_proposition', $numeroProposition)
                ->where('bonne_reponse', 1)
                ->countAllResults() > 0;
    }


    /**
     * Récupère toutes les bonnes réponses d'une question
     */
    public function getBonnesReponses($numeroQuestion)
    {
        return $this->db->table('question_proposition qp')
            ->select('qp.numero_proposition, p.libelle')
            ->join('proposition p', 'p.numero = qp.numero_proposition')
            ->where('qp.numero_question', $numeroQuestion)
            ->where('qp.bonne_reponse', 1)
            ->get()->getResultArray();
    }


    /**
     * Compte le nombre de propositions pour une question
     */
    public function getNombrePropositions($numeroQuestion)
    {
        $builder = $this->db->table('question_proposition');
        $builder->where('numero_question', $numeroQuestion);

        return $builder->countAllResults();
    }
}