<?php

namespace App\Controllers;

use App\Models\QuestionModel;
use App\Models\CategorieModel;
use App\Controllers\BaseController;

class QuizControlleur extends BaseController
{
    protected $questionModel;
    protected $categorieModel;
    protected $session;

    // Types de quiz disponibles
    private const TYPE_DROITE = 'droite';
    private const TYPE_GAUCHE = 'gauche';
    private const TYPE_NUIT = 'nuit';

    // Configuration des types de quiz
    private const CONFIG_QUIZ = [
        self::TYPE_DROITE => [
            'view_choix' => 'quiz/choix_droite',
            'view_question' => 'quiz/question_droite',
            'route_question' => '/quiz/question/droite',
            'route_resultats' => '/quiz/resultats/droite',
        ],
        self::TYPE_GAUCHE => [
            'view_choix' => 'quiz/choix_gauche',
            'view_question' => 'quiz/question_gauche',
            'route_question' => '/quiz/question/gauche',
            'route_resultats' => '/quiz/resultats/gauche',
        ],
        self::TYPE_NUIT => [
            'view_choix' => 'quiz/choix_nuit',
            'view_question' => 'quiz/question_nuit',
            'route_question' => '/quiz/question/nuit',
            'route_resultats' => '/quiz/resultats/nuit',
            'nb_questions' => 8,
            'niveau_difficulte' => 0,
        ],
    ];

    public function __construct()
    {
        $this->questionModel = new QuestionModel();
        $this->categorieModel = new CategorieModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Page d'accueil du quiz - Sélection des paramètres
     */
    public function index()
    {
        $data = [
            'title' => 'Salle Quiz',
            'categories' => $this->categorieModel->getCategoriesAvecNbQuestions()
        ];

        return view('quiz/index', $data).view('commun/footer');
    }

    /**
     * Affiche la page de choix pour un type de quiz
     *
     * @param string $type Type de quiz (droite, gauche, nuit)
     */
    public function demarrer(string $type)
    {
        if (!$this->isValidType($type)) {
            return redirect()->to('/quiz')->with('error', 'Type de quiz invalide.');
        }

        return view(self::CONFIG_QUIZ[$type]['view_choix']).view('commun/footer');
    }

    /**
     * Démarre une nouvelle partie de quiz avec les paramètres choisis
     *
     * @param string $type Type de quiz (droite, gauche, nuit)
     */
    public function choix(string $type)
    {
        if (!$this->isValidType($type)) {
            return redirect()->to('/quiz')->with('error', 'Type de quiz invalide.');
        }

        // Récupérer les paramètres selon le type de quiz
        if ($type === self::TYPE_NUIT) {
            // Configuration prédéfinie pour le quiz de nuit
            $nbQuestions = self::CONFIG_QUIZ[$type]['nb_questions'];
            $categorieId = null;
            $niveauDifficulte = self::CONFIG_QUIZ[$type]['niveau_difficulte'];
            $questions = $this->questionModel->getQuestionsAleatoiresNuit();
        } else {
            // Configuration depuis le formulaire pour droite/gauche
            $nbQuestions = $this->request->getPost('nb_questions') ?? 10;
            $categorieId = $this->request->getPost('categorie_id') ?? null;
            $niveauDifficulte = $this->request->getPost('niveau_difficulte') ?? null;
            $questions = $this->questionModel->getQuestionsAleatoires(
                $nbQuestions,
                $categorieId,
                $niveauDifficulte
            );
        }

        // Vérifier si des questions sont disponibles
        if (empty($questions)) {
            return redirect()->to('/quiz')->with('error', 'Aucune question disponible avec ces critères.');
        }

        // Initialiser la session
        $this->initSession($questions);

        return redirect()->to(self::CONFIG_QUIZ[$type]['route_question']);
    }

    /**
     * Affiche la question courante
     *
     * @param string $type Type de quiz (droite, gauche, nuit)
     */
    public function question(string $type)
    {
        if (!$this->isValidType($type)) {
            return redirect()->to('/quiz')->with('error', 'Type de quiz invalide.');
        }

        $questions = $this->session->get('quiz_questions');
        $index = $this->session->get('quiz_index');

        // Vérifier l'état de la session
        if (!$questions) {
            return redirect()->to('/quiz');
        }

        // Vérifier si le quiz est terminé
        if ($index >= count($questions)) {
            return redirect()->to(self::CONFIG_QUIZ[$type]['route_resultats']);
        }

        // Récupérer et préparer la question
        $numeroQuestion = $questions[$index];
        $question = $this->questionModel->getQuestionComplete($numeroQuestion);
        shuffle($question['propositions']);

        $data = [
            'title' => 'Question ' . ($index + 1) . '/' . count($questions),
            'question' => $question,
            'index' => $index + 1,
            'total' => count($questions),
            'progression' => round((($index + 1) / count($questions)) * 100),
            'show_results' => false
        ];

        return view(self::CONFIG_QUIZ[$type]['view_question'], $data).view('commun/footer');
    }

    /**
     * Traite la réponse soumise
     *
     * @param string $type Type de quiz (droite, gauche, nuit)
     */
    public function repondre(string $type)
    {
        if (!$this->isValidType($type)) {
            return redirect()->to('/quiz')->with('error', 'Type de quiz invalide.');
        }

        $questions = $this->session->get('quiz_questions');
        $index = $this->session->get('quiz_index');
        $score = $this->session->get('quiz_score');
        $reponses = $this->session->get('quiz_reponses') ?? [];

        $numeroQuestion = $questions[$index];
        $numeroProposition = $this->request->getPost('proposition');

        // Vérifier la réponse
        $estCorrect = $this->questionModel->verifierReponse($numeroQuestion, $numeroProposition);

        if ($estCorrect) {
            $score++;
        }

        // Enregistrer la réponse
        $reponses[$numeroQuestion] = [
            'proposition_choisie' => $numeroProposition,
            'correct' => $estCorrect,
            'temps_reponse' => time()
        ];

        // Mettre à jour la session
        $this->session->set([
            'quiz_score' => $score,
            'quiz_index' => $index + 1,
            'quiz_reponses' => $reponses
        ]);

        // Rediriger vers la prochaine question ou les résultats
        if ($index + 1 >= count($questions)) {
            return redirect()->to(self::CONFIG_QUIZ[$type]['route_resultats']);
        }

        return redirect()->to(self::CONFIG_QUIZ[$type]['route_question']);
    }

    /**
     * Affiche les résultats finaux en modale
     *
     * @param string $type Type de quiz (droite, gauche, nuit)
     */
    public function resultats(string $type)
    {
        if (!$this->isValidType($type)) {
            return redirect()->to('/quiz')->with('error', 'Type de quiz invalide.');
        }

        $questions = $this->session->get('quiz_questions');
        $score = $this->session->get('quiz_score');
        $reponses = $this->session->get('quiz_reponses');
        $debut = $this->session->get('quiz_debut');

        if (!$questions) {
            return redirect()->to('/quiz');
        }

        // Calculer les statistiques
        $total = count($questions);
        $pourcentage = round(($score / $total) * 100);
        $duree = time() - $debut;

        // Récupérer les détails des questions et réponses
        $details = $this->prepareDetailsResultats($questions, $reponses);

        $data = [
            'title' => 'Résultats du Quiz',
            'score' => $score,
            'total' => $total,
            'pourcentage' => $pourcentage,
            'duree' => $duree,
            'details' => $details,
            'show_results' => true,
            'question' => null,
            'progression' => 100
        ];

        return view(self::CONFIG_QUIZ[$type]['view_question'], $data).view('commun/footer');
    }

    /**
     * Termine le quiz et nettoie la session
     */
    public function terminer()
    {
        $this->session->remove([
            'quiz_questions',
            'quiz_index',
            'quiz_score',
            'quiz_reponses',
            'quiz_debut'
        ]);

        return redirect()->to('/quiz');
    }

    // ========================================
    // MÉTHODES PRIVÉES UTILITAIRES
    // ========================================

    /**
     * Vérifie si le type de quiz est valide
     *
     * @param string $type Type à vérifier
     * @return bool
     */
    private function isValidType(string $type): bool
    {
        return isset(self::CONFIG_QUIZ[$type]);
    }

    /**
     * Initialise la session pour un nouveau quiz
     *
     * @param array $questions Liste des questions
     */
    private function initSession(array $questions): void
    {
        $this->session->set([
            'quiz_questions' => array_column($questions, 'numero'),
            'quiz_index' => 0,
            'quiz_score' => 0,
            'quiz_reponses' => [],
            'quiz_debut' => time()
        ]);
    }

    /**
     * Prépare les détails des résultats
     *
     * @param array $questions Liste des numéros de questions
     * @param array $reponses Réponses de l'utilisateur
     * @return array
     */
    private function prepareDetailsResultats(array $questions, array $reponses): array
    {
        $details = [];

        foreach ($questions as $numQuestion) {
            $question = $this->questionModel->getQuestionComplete($numQuestion);
            $bonnesReponses = $this->questionModel->getBonnesReponses($numQuestion);
            $reponseUtilisateur = $reponses[$numQuestion] ?? null;

            $details[] = [
                'question' => $question,
                'bonnes_reponses' => $bonnesReponses,
                'reponse_utilisateur' => $reponseUtilisateur
            ];
        }

        return $details;
    }

}