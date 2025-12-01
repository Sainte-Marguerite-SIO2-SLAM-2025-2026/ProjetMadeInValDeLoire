<?php
namespace App\Controllers\salle_4;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\commun\SalleModel;
use App\Models\salle_4\Salle4Model;
use App\Models\salle_4\QuizModel;

class Salle4Controller extends BaseController
{

    protected $salleModel;
    protected $mascotteModel;


    public function __construct()
    {
        $this->salleModel = new SalleModel();
        $this->mascotteModel = new MascotteModel();
    }

    public function index(): string
    {
        $session = session();

        // Vérifier si c'est la première visite de la salle 4
        $premiereVisite = !$session->has('salle4_visited');

        // Marquer la salle comme visitée
        if ($premiereVisite) {
            $session->set('salle4_visited', true);
        }
        $data = [
            'frise_validee' => true,
            'quiz_disponible' =>true,
            'premiere_visite' => $premiereVisite,
            'mascotte' => $this->mascotteModel->getMascottes(),
            'salle' => $this->salleModel->getSalleById(4),
        ];

        return view('salle_4/AccueilSalle4', $data) . view('commun/footer');
    }

    public function pageFrise(): string
    {
        $session = session();
        $salle4Model = new Salle4Model();

        // Choisir aléatoirement une activité parmi 1 et 2
        if (!$session->has('activite_choisie')) {
            $activitesPossibles = [401, 402];
            $session->set('activite_choisie', $activitesPossibles[array_rand($activitesPossibles)]);
        }

        $activiteChoisie = $session->get('activite_choisie');
        $cartes = $salle4Model->getCartesByActivite($activiteChoisie);

        // Positions fixes
        $positionsDisponibles = [
            ['x' => 4, 'y' => 8],
            ['x' => 8, 'y' => 43],
            ['x' => 35, 'y' => 2],
            ['x' => 45, 'y' => 35],
            ['x' => 78, 'y' => 24],
            ['x' => 57, 'y' => 8],
            ['x' => 32, 'y' => 63],
            ['x' => 70, 'y' => 66]
        ];

        // Mélanger les positions aléatoirement pour cette session
        if (!$session->has('positions_cartes_frise')) {
            shuffle($positionsDisponibles);
            $session->set('positions_cartes_frise', $positionsDisponibles);
        }

        $positions = $session->get('positions_cartes_frise');

        $data = [
            'activite' => $activiteChoisie,
            'cartes' => $cartes,
            'positions' => $positions,
            'mascotte' => $this->mascotteModel->getMascottes(),
            'salle' => $this->salleModel->getSalleById(4),
        ];

        return view('salle_4/friseSalle4', $data) . view('commun/footer');
    }

    public function verifierOrdre()
    {
        $session = session();


        $salle4Model = new Salle4Model();

        $activiteChoisie = $session->get('activite_choisie');
        $json = $this->request->getJSON(true);
        $ordreUtilisateur = $json['ordre'] ?? [];
        $forceCorrect = $json['force_correct'] ?? false;

        $resultat = $salle4Model->verifierOrdre($activiteChoisie, $ordreUtilisateur);

        // Si correct (par le modèle OU forcé par le JS), débloquer le quiz
        if ($resultat['correct'] || $forceCorrect) {
            $session->set('frise_validee', true);
            $session->set('quiz_disponible', true);
            $session->remove('activite_choisie');
            $session->remove('positions_cartes_frise');

            // Mettre à jour le résultat si forcé
            if ($forceCorrect) {
                $resultat['correct'] = true;
            }
        }

        return $this->response->setJSON($resultat);
    }

    public function quizFinal(): string
    {
        $session = session();
        $quizModel = new QuizModel();

        // Réinitialiser le quiz au chargement
        $session->remove('quiz_questions');
        $session->remove('quiz_reponses');
        $session->remove('quiz_score');

        // Récupérer 6 questions aléatoires
        $questions = $quizModel->getRandomQuestions(403, 6);
        $session->set('quiz_questions', $questions);
        $session->set('quiz_reponses', []);
        $session->set('quiz_score', 0);

        $questions = $session->get('quiz_questions');
        $reponses = $session->get('quiz_reponses');

        $data = [
            'questions' => $questions,
            'reponses' => $reponses,
            'mascotte' => $this->mascotteModel->getMascottes(),
            'salle' => $this->salleModel->getSalleById(4),
        ];

        return view('salle_4/QuizSalle4', $data) . view('commun/footer');
    }

    public function verifierReponseQuiz()
    {
        $session = session();
        $quizModel = new QuizModel();

        $questionId = $this->request->getJSON(true)['question_id'] ?? 0;
        $reponse = $this->request->getJSON(true)['reponse'] ?? '';

        $resultat = $quizModel->verifierReponse($questionId, $reponse);

        if ($resultat['success'] && $resultat['correct']) {
            $score = $session->get('quiz_score') ?? 0;
            $session->set('quiz_score', $score + 1);
        }

        // Enregistrer la réponse
        $reponses = $session->get('quiz_reponses') ?? [];
        $reponses[$questionId] = [
            'reponse_utilisateur' => $reponse,
            'correct' => $resultat['correct']
        ];
        $session->set('quiz_reponses', $reponses);

        $resultat['score'] = $session->get('quiz_score');
        $resultat['total_repondu'] = count($reponses);

        return $this->response->setJSON($resultat);
    }

    public function resetQuiz()
    {
        $session = session();
        $session->remove('quiz_questions');
        $session->remove('quiz_reponses');
        $session->remove('quiz_score');

        return redirect()->to(base_url('Salle4'));
    }

    public function resetSalle()
    {
        $session = session();
        $session->remove('frise_validee');
        $session->remove('activite_choisie');
        $session->remove('positions_cartes_frise');
        $session->remove('quiz_questions');
        $session->remove('quiz_reponses');
        $session->remove('quiz_score');

        return redirect()->to(base_url('Salle4'));
    }
}