<?php

namespace App\Models\salle_4;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'question';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle', 'reponse', 'activite_numero'];

    /**
     * Récupère 6 questions aléatoires pour une activité
     */
    public function getRandomQuestions(int $activiteId, int $nombre = 6): array
    {
        return $this->where('activite_numero', $activiteId)
            ->orderBy('RAND()')
            ->limit($nombre)
            ->findAll();
    }

    /**
     * Vérifie une réponse
     */
    public function verifierReponse(int $questionId, string $reponse): array
    {
        $question = $this->find($questionId);

        if (!$question) {
            return [
                'success' => false,
                'message' => 'Question introuvable'
            ];
        }

        // Convertir la réponse utilisateur en tinyint (vrai = 1, faux = 0)
        $reponseInt = (strtolower($reponse) === 'vrai') ? 1 : 0;

        // Comparer avec la réponse en BDD (qui est déjà un tinyint)
        $correct = ($question['reponse'] == $reponseInt);

        return [
            'success' => true,
            'correct' => $correct,
            'bonne_reponse' => ($question['reponse'] == 1) ? 'vrai' : 'faux',
            'libelle' => $question['libelle']
        ];
    }
}