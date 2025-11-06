<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class Salle2Controller extends BaseController
{
    public function index() : string
    {
        return view('salle_2/EnigmeSalle2').
            view('commun/PiedDePage');
    }

}