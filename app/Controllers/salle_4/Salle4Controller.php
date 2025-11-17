<?php

namespace App\Controllers\salle_4;

use App\Controllers\BaseController;
use App\Models\salle_4\Salle4Model;

class Salle4Controller extends BaseController
{
    public function index():string
    {
        return view('accueil\Accueil');
    }

    public function pageFrise():string
    {
        $session = session();
        $salle4Model = new Salle4Model();

        if (!$session->has('activite_choisie')) {
            $activitesPossibles = [1, 2];
            $session->set('activite_choisie', $activitesPossibles[array_rand($activitesPossibles)]);
        }

        $activiteChoisie = $session->get('activite_choisie');
        $cartes = $salle4Model->getCartesByActivite($activiteChoisie);

        $data = [
            'activite' => $activiteChoisie,
            'cartes'   => $cartes
        ];


        return view('salle_4/test', $data).
            view('commun/footer');
    }

    public function quizFinal():string
    {
        return view('salle_4\QuizSalle4').
            view('commun\footer');
    }
}