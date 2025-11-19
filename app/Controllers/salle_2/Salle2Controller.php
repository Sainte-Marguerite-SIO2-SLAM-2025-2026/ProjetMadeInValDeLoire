<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\salle_2\Salle2Model;
use App\Models\salle_2\IndicesModel;
use CodeIgniter\RESTful\ResourceController;

class Salle2Controller extends BaseController
{
    public function index() : string
    {
        $idActivite = 1;

        $model = new Salle2Model();

        $data = $model->orderBy('RAND()')->limit(10)->find();

        $modelIndices = new IndicesModel();
        $indices = $modelIndices->getIndices($idActivite);

        return view('salle_2/EnigmeSalle2', ['mails' => $data, 'idActivite' => $idActivite, 'indices' => $indices]).
            view('commun/footer');
    }


}