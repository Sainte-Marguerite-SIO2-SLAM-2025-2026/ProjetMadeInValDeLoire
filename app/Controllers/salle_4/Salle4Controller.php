<?php

namespace App\Controllers\salle_4;

use App\Controllers\BaseController;

class Salle4Controller extends BaseController
{
    public function index():string
    {
        return view('accueil\Accueil');
    }

    public function pageFrise():string
    {
        return view('salle_4\test').
            view('commun/footer');
    }

    public function quizFinal():string
    {
        return view('salle_4\QuizSalle4').
            view('commun\footer');
    }
}