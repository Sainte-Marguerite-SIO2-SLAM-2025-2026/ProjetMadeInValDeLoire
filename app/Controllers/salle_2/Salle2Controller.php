<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\salle_2\Salle2Model;
use CodeIgniter\RESTful\ResourceController;

class Salle2Controller extends BaseController
{
    public function index() : string
    {
        $model = new Salle2Model();
        $data = $model->orderBy('RAND()')->limit(10)->find();

        return view('salle_2/EnigmeSalle2', ['mails' => $data]).
            view('commun/PiedDePage');
    }


}