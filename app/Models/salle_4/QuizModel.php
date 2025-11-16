<?php

namespace App\Models\salle_4;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'question';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['question', 'reponse', 'activite_numero'];

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

        $correct = (strtolower($question['reponse']) === strtolower($reponse));

        return [
            'success' => true,
            'correct' => $correct,
            'bonne_reponse' => $question['reponse'],
            'question' => $question['question']
        ];
    }
}