<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;

class WifiController extends BaseController
{
    public function Index():string
    {
        return view('commun\header').
            view('salle_6\Wifi').
            view('commun\footer');
    }

    public function ResultatCarte():string
    {
        return view('commun\header').
            view('salle_6\WifiResultatCarte').
            view('commun\footer');
    }
}