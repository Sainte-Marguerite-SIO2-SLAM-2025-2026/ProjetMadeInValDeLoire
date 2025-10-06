<?php

namespace salle_2;

use App\Controllers\BaseController;

class Salle2Controller extends BaseController
{
    public function index()
    {
        return view('salle2/salle2').
            view('commum/PiedDePage');
    }
}