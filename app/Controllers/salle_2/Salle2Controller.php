<?php

namespace salle_2;

use App\Controllers\BaseController;
use App\Models\accueil\AccueilModel;
use CodeIgniter\RESTful\ResourceController;

class Salle2Controller extends BaseController
{

    public function index()
    {
        return view('salle2/salle2').
            view('commum/PiedDePage');
    }

    public function enigme(){
        return view('salle_2/EnigmeSalle2').
            view('commum/PiedDePage');
    }

    public function submit()
    {
        $request = service('request');
        $resultats = $request->getJSON(true)['resultat'] ?? [];

        $mailModel = new AccueilModel();
        $mails = $mailModel->getMail();

        $score = 0;
        $total = count($mails);

        foreach ($resultats as $reponse)
        {
            foreach ($mails as $mail)
            {
                if ($mail['id'] == $reponse['id'] && $mail['type'] == $reponse['choix'])
                {
                    $score++;
                    break;
                }
            }
        }

        $message = "Tu as obtenu $score bonne(s) réponse(s) sur $total !";

        return $this->response->setJSON([
            'success' => true,
            'message' => $message,
            'score' => $score,
            'total' => $total
        ]);
    }
}