<?php
////
////namespace App\Controllers\salle_4;
////
////use App\Controllers\BaseController;
////use App\Models\salle_4\Salle4Model;
////
////class Salle4Controller extends BaseController
////{
////    public function index():string
////    {
////        return view('accueil\Accueil');
////    }
////
////    public function pageFrise():string
////    {
////        $session = session();
////        $salle4Model = new Salle4Model();
////
////        if (!$session->has('activite_choisie')) {
////            $activitesPossibles = [1];
//////            $session->set('activite_choisie', $activitesPossibles[array_rand($activitesPossibles)]);
////            $session->set('activite_choisie', 1);
////        }
////
////        $activiteChoisie = $session->get('activite_choisie');
////        $cartes = $salle4Model->getCartesByActivite($activiteChoisie);
////
////        $data = [
////            'activite' => $activiteChoisie,
////            'cartes'   => $cartes
////        ];
////
////
////        return view('salle_4/test_2', $data).
////            view('commun/footer');
////    }
////
////    public function quizFinal():string
////    {
////        return view('salle_4\QuizSalle4').
////            view('commun\footer');
////    }
////}
//
//
//namespace App\Controllers\salle_4;
//
//use App\Controllers\BaseController;
//use App\Models\salle_4\Salle4Model;
//use App\Models\salle_4\QuizModel;
//
//class Salle4Controller extends BaseController
//{
//    public function index(): string
//    {
//        return view('salle_4/AccueilSalle4') . view('commun/footer');
//    }
//
//    public function pageFrise():string
//    {
//        $session = session();
//        $salle4Model = new Salle4Model();
//
//        if (!$session->has('activite_choisie')) {
//            $activitesPossibles = [1];
////            $session->set('activite_choisie', $activitesPossibles[array_rand($activitesPossibles)]);
//            $session->set('activite_choisie', 1);
//        }
//
//        $activiteChoisie = $session->get('activite_choisie');
//        $cartes = $salle4Model->getCartesByActivite($activiteChoisie);
//
//        $data = [
//            'activite' => $activiteChoisie,
//            'cartes'   => $cartes
//        ];
//
//
//        return view('salle_4/friseSalle4', $data).
//            view('commun/footer');
//    }
//
//    public function verifierOrdre()
//    {
//        $session = session();
//        $salle4Model = new Salle4Model();
//
//        $activiteChoisie = $session->get('activite_choisie');
//        $ordreUtilisateur = $this->request->getJSON(true)['ordre'] ?? [];
//
//        $resultat = $salle4Model->verifierOrdre($activiteChoisie, $ordreUtilisateur);
//
//        return $this->response->setJSON($resultat);
//    }
//
//    public function quizFinal(): string
//    {
//        $session = session();
//        $session->destroy(); // Reset total de la session
//        $session = session(); // On redémarre une session propre
//        $quizModel = new QuizModel();
//
//        // Récupérer ou générer 6 questions aléatoires
//        if (!$session->has('quiz_questions')) {
//            $questions = $quizModel->getRandomQuestions(3, 6); // Activité 3 = Quiz
//            $session->set('quiz_questions', $questions);
//            $session->set('quiz_reponses', []);
//            $session->set('quiz_score', 0);
//        }
//
//        $questions = $session->get('quiz_questions');
//        $reponses = $session->get('quiz_reponses');
//
//        $data = [
//            'questions' => $questions,
//            'reponses' => $reponses
//        ];
//
//        return view('salle_4/QuizSalle4', $data).
//            view('commun/footer');
//    }
//
//    public function verifierReponseQuiz()
//    {
//        $session = session();
//        $quizModel = new QuizModel();
//
//        $questionId = $this->request->getJSON(true)['question_id'] ?? 0;
//        $reponse = $this->request->getJSON(true)['reponse'] ?? '';
//
//        $resultat = $quizModel->verifierReponse($questionId, $reponse);
//
//        if ($resultat['success'] && $resultat['correct']) {
//            $score = $session->get('quiz_score') ?? 0;
//            $session->set('quiz_score', $score + 1);
//        }
//
//        // Enregistrer la réponse
//        $reponses = $session->get('quiz_reponses') ?? [];
//        $reponses[$questionId] = [
//            'reponse_utilisateur' => $reponse,
//            'correct' => $resultat['correct']
//        ];
//        $session->set('quiz_reponses', $reponses);
//
//        $resultat['score'] = $session->get('quiz_score');
//        $resultat['total_repondu'] = count($reponses);
//
//        return $this->response->setJSON($resultat);
//    }
//
//    public function resetQuiz()
//    {
//        $session = session();
//        $session->remove('quiz_questions');
//        $session->remove('quiz_reponses');
//        $session->remove('quiz_score');
//
//        return redirect()->to(base_url('Salle4'));
//    }
//}


namespace App\Controllers\salle_4;

use App\Controllers\BaseController;
use App\Models\salle_4\Salle4Model;
use App\Models\salle_4\QuizModel;

class Salle4Controller extends BaseController
{
    public function index(): string
    {
        $session = session();

        $data = [
            'frise_validee' => $session->get('frise_validee') ?? false,
            'quiz_disponible' => $session->get('frise_validee') ?? false
        ];

        return view('salle_4/AccueilSalle4', $data) . view('commun/footer');
    }

    public function pageFrise(): string
    {
        $session = session();
        $salle4Model = new Salle4Model();

        // Vérifier si la frise est déjà validée
        if ($session->get('frise_validee')) {
            return redirect()->to(base_url('Salle4'));
        }

        // Choisir aléatoirement une activité parmi 1 et 2
        if (!$session->has('activite_choisie')) {
            $activitesPossibles = [1, 2];
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
            'positions' => $positions
        ];

        return view('salle_4/friseSalle4', $data) . view('commun/footer');
    }

    public function verifierOrdre()
    {
        $session = session();
        $salle4Model = new Salle4Model();

        $activiteChoisie = $session->get('activite_choisie');
        $ordreUtilisateur = $this->request->getJSON(true)['ordre'] ?? [];

        $resultat = $salle4Model->verifierOrdre($activiteChoisie, $ordreUtilisateur);

        // Si correct, débloquer le quiz et bloquer la frise
        if ($resultat['correct']) {
            $session->set('frise_validee', true);
            $session->remove('activite_choisie');
            $session->remove('positions_cartes_frise');
        }

        return $this->response->setJSON($resultat);
    }

    public function quizFinal(): string
    {
        $session = session();

        // Vérifier si la frise a été validée
        if (!$session->get('frise_validee')) {
            return view('salle_4/QuizSalle4') . view('commun/footer');
        }

        $quizModel = new QuizModel();

        // Récupérer ou générer 6 questions aléatoires
        if (!$session->has('quiz_questions')) {
            $questions = $quizModel->getRandomQuestions(3, 6);
            $session->set('quiz_questions', $questions);
            $session->set('quiz_reponses', []);
            $session->set('quiz_score', 0);
        }

        $questions = $session->get('quiz_questions');
        $reponses = $session->get('quiz_reponses');

        $data = [
            'questions' => $questions,
            'reponses' => $reponses
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