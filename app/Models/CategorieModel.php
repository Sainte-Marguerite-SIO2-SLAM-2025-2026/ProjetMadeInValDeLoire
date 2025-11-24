<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $DBGroup = 'dbQuizz';   // <- utiliser la seconde base celle du Quizz
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'theme'];
    protected $returnType = 'array';

    /**
     * Récupère toutes les catégories avec le nombre de questions
     */
    public function getCategoriesAvecNbQuestions()
    {
        $builder = $this->builder();
        $builder->select('categorie.*, COUNT(qc.question_numero) as nb_questions');
        $builder->join('question_categorie qc', 'qc.categorie_id = categorie.id', 'left');
        $builder->groupBy('categorie.id');
        $builder->orderBy('categorie.theme, categorie.nom');

        return $builder->get()->getResultArray();
    }

    /**
     * Récupère les catégories par thème
     */
    public function getCategoriesParTheme()
    {
        $categories = $this->orderBy('theme, nom')->findAll();

        $categoriesParTheme = [];
        foreach ($categories as $cat) {
            $categoriesParTheme[$cat['theme']][] = $cat;
        }

        return $categoriesParTheme;
    }
}