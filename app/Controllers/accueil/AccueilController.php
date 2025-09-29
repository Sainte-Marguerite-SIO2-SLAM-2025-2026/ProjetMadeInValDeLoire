<?php
namespace App\Controllers\accueil;

use App\Controllers\BaseController;

class AccueilController extends BaseController
{
    public function index() : string
    {
        return view('accueil\Accueil');
    }

    public function Salle1() : string
    {
        return view('salle_1\AccueilSalle1');
    }

    public function Salle2() : string
    {
        return view('salle_2\AccueilSalle2');
    }

    public function Salle3() : string
    {
        return view('salle_3\AccueilSalle3');
    }

    public function Salle4() : string
    {
        return view('salle_4\AccueilSalle4');
    }

    public function Salle5() : string
    {
        return view('salle_5\AccueilSalle5');
    }

    public function Salle6() : string
    {
        return view('salle_6\AccueilSalle6');
    }
}