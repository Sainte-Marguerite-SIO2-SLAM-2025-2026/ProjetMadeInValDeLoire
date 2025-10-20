<?php

namespace App\Controllers\salle_5;

use App\Controllers\BaseController;
use App\salle_5\ActiviteModel;
use App\Models\salle_5\SalleModel;
use App\Models\salle_5\ExplicationModel;

class Salle5Controller extends BaseController
{
    public function index(){
        $data['enigme'] = getActivite(5);
        $data['salle'] = getSalle(5);

        return view('commun\header').
            view('salle_5\Enigme', $data).
            view('commun\footer');}
}