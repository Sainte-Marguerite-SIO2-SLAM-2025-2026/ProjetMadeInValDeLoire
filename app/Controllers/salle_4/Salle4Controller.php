<?php
namespace App\Controllers\salle_4;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\commun\SalleModel;
use App\Models\commun\IndiceModel;
use App\Models\salle_4\ExplicationModel;
use App\Models\salle_4\Salle4Model;
use App\Models\salle_4\QuizModel;

class Salle4Controller extends BaseController
{
    protected SalleModel $salleModel;
    protected ExplicationModel $explicationModel;
    protected MascotteModel $mascotteModel;
    protected IndiceModel $indice;
    protected QuizModel $quizModel;

    public function __construct()
    {
        $this->salleModel = new SalleModel();
        $this->explicationModel = new ExplicationModel();
        $this->mascotteModel = new MascotteModel();
        $this->indice = new IndiceModel();
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
            'frise_validee' => $session->get('frise_validee') ?? false,
            'quiz_disponible' => $session->get('quiz_disponible') ?? false,
            'premiere_visite' => $premiereVisite,
            'mascotte' => $this->mascotteModel->getMascottes(),
            'salle' => $this->salleModel->getSalleById(4),
            'indice' => $this->indice->getIndice(400),
        ];

        return view('salle_4/AccueilSalle4', $data) . view('commun/footer');
    }

    public function pageFrise(): string
    {
        $session = session();
        $salle4Model = new Salle4Model();

        // Choisir aléatoirement une activité parmi 401 et 402
        if (!$session->has('activite_choisie')) {
            $activitesPossibles = [401, 402];
            $session->set('activite_choisie', $activitesPossibles[array_rand($activitesPossibles)]);
        }

        $activiteChoisie = $session->get('activite_choisie');

        // Récupérer les cartes selon l'activité
        if ($activiteChoisie == 402) {
            // Pour l'activité 402 : récupérer 8 cartes (bonnes pratiques + pièges)
            $cartes = $salle4Model->getCartesActivite402(402);
            // Stocker les cartes en session pour la vérification
            $session->set('cartes_402', $cartes);
            // Initialiser le tableau des cartes jouées
            $session->set('cartes_jouees_402', []);
        } else {
            // Pour l'activité 401 : récupérer les cartes normalement
            $cartes = $salle4Model->getCartesByActivite($activiteChoisie);
        }

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
            'explication' => $this->explicationModel->getExplication($activiteChoisie),
            'indice' => $this->indice->getIndice($activiteChoisie),
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

    /**
     * Vérifie une carte pour l'activité 402
     * Route POST appelée à chaque clic sur une carte
     */
    public function verifierCarte402()
    {
        $session = session();
        $salle4Model = new Salle4Model();

        $json = $this->request->getJSON(true);
        $numeroCarte = $json['numero_carte'] ?? 0;

        // Récupérer les cartes jouées et toutes les cartes de la session
        $cartesJouees = $session->get('cartes_jouees_402') ?? [];
        $toutesLesCartes = $session->get('cartes_402') ?? [];

        if (empty($toutesLesCartes)) {
            return $this->response->setJSON([
                'erreur' => true,
                'message' => 'Aucune partie en cours'
            ]);
        }

        // Vérifier la carte
        $resultat = $salle4Model->verifierCarte402($numeroCarte, $cartesJouees, $toutesLesCartes);

        // Mettre à jour la session avec les cartes jouées
        if (isset($resultat['cartes_jouees'])) {
            $session->set('cartes_jouees_402', $resultat['cartes_jouees']);
        }

        // Si le jeu est terminé avec succès, débloquer le quiz
        if (!$resultat['continuer'] && $resultat['reussi']) {
            $session->set('frise_validee', true);
            $session->set('quiz_disponible', true);
            $session->remove('activite_choisie');
            $session->remove('positions_cartes_frise');
            $session->remove('cartes_402');
            $session->remove('cartes_jouees_402');
        }

        // Si le jeu est terminé avec échec, nettoyer la session
        if (!$resultat['continuer'] && !$resultat['reussi']) {
            $session->remove('activite_choisie');
            $session->remove('positions_cartes_frise');
            $session->remove('cartes_402');
            $session->remove('cartes_jouees_402');
        }

        return $this->response->setJSON($resultat);
    }

    /**
     * Réinitialise l'activité 402
     */
    public function resetActivite402()
    {
        $session = session();
        $session->remove('cartes_402');
        $session->remove('cartes_jouees_402');

        return redirect()->to(base_url('pageFrise'));
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
            'indice' => $this->indice->getIndice(403),
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
        $session->remove('cartes_402');
        $session->remove('cartes_jouees_402');
        $session->remove('quiz_questions');
        $session->remove('quiz_reponses');
        $session->remove('quiz_score');

        return redirect()->to(base_url('Salle4'));
    }
}