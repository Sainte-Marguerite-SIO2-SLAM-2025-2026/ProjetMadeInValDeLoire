<?php
namespace App\Controllers\accueil;

use App\Controllers\BaseController;

class AccueilController extends BaseController
{
    public function index() : string
    {
        return view('accueil\Accueil').
            view('commun\footer');
    }

    public function Salle1() : string
    {
        return view('commun\header').
            view('salle_1\AccueilSalle1').
            view('commun\footer');
    }

    public function Salle2() : string
    {
        return view('commun\header').
            view('salle_2\AccueilSalle2').
            view('commun\footer');
    }

    public function Salle3() : string
    {
        return view('commun\header').
            view('salle_3\AccueilSalle3').
            view('commun\footer');
    }

    public function Salle4() : string
    {
        return view('commun\header').
            view('salle_4\AccueilSalle4').
            view('commun\footer');
    }

    public function Salle5() : string
    {
        return view('commun\header').
            view('salle_5\AccueilSalle5').
            view('commun\footer');
    }

}