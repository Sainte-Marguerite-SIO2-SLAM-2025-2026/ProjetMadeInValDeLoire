<?php

namespace App\Controllers\salle_3;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\salle_3\ExplicationsModel;
use App\Models\salle_3\Salle3Model;
use App\Models\salle_3\IndicesModel;
use CodeIgniter\RESTful\ResourceController;

class Salle3Controller extends BaseController
{

    public function index() : string
    {
        $idActivite = 301;

        $model = new Salle3Model();
        $data = $model->orderBy('RAND()')->limit(10)->find();

        $modelIndices = new IndicesModel();
        $indices = $modelIndices->getIndices($idActivite);

        $modelExplication = new ExplicationsModel();
        $explication = $modelExplication->getExplication($idActivite);

        $mascotteModel = new MascotteModel();
        $mascottes = $mascotteModel->getMascottes();

        return view('salle_3/EnigmeSalle3', ['mails' => $data, 'idActivite' => $idActivite, 'indices' => $indices, 'explication' => $explication, 'mascotte' => $mascottes]).
            view('commun/footer');
    }
}