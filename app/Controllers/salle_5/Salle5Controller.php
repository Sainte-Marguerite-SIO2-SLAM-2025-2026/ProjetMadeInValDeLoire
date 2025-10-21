<?php

namespace App\Controllers\salle_5;

use App\Controllers\BaseController;
use App\Models\salle_5\MascotteModel;
use App\Models\salle_5\ModeEmploiModel;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ObjetModel;
use App\Models\salle_5\SalleModel;
use App\Models\salle_5\ExplicationModel;

class Salle5Controller extends BaseController
{

    public function index(){
        $salleModel = new SalleModel();
        $mascotteModel = new MascotteModel();
        $objetModel = new ObjetModel();
        $data['salle'] = $salleModel->getSalle(5);
        $data['mascotte'] = $mascotteModel->getMascotte(5);
        $data['objet'] = $objetModel->getObjet(5);
        return view('commun\header').
            view('salle_5\AccueilEnigme', $data).
            view('commun\footer');
    }

    public function enigme7(){
        $salleModel = new SalleModel();
        $mascotteModel = new MascotteModel();
        $activiteModel = new ActiviteModel();
        $modeEmploiModel = new ModeEmploiModel();
        $objetModel = new ObjetModel();
        $data['salle'] = $salleModel->getSalle(5);
        $data['mascotte'] = $mascotteModel->getMascotte(5);
        $data['enigme'] = $activiteModel->getActivite(5);
        $data['mode_emploi'] = $modeEmploiModel->getModeEmploi(7);
        $data['usb_finance'] = $objetModel->getUsbFinance(5);
        $data['usb_rh'] = $objetModel->getUsbRh(5);
        $data['usb_ano'] = $objetModel->getUsbAno(5);

        return view('commun\header').
            view('salle_5\Enigme', $data).
            view('commun\footer');}
}