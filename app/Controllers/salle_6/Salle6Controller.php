<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;

class Salle6Controller extends BaseController
{
    public function Index() : string
    {
        $data['intitule'] = "Ouah ce train à l'air étrange cliquez dessus pour en savoir plus";
        return view('salle_6\AccueilSalle6',$data).
            view('commun\footer');
    }



    public function Vpn():string
    {
        return view('commun\header').
            view('salle_6\Vpn').
            view('commun\footer');
    }

}