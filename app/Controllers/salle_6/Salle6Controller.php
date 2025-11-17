<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;
use App\Controllers\salle_6\WifiController;
use App\Controllers\salle_6\VpnController;

class Salle6Controller extends BaseController
{

    protected $WifiController;
    protected $VpnController;

    public function __construct()
    {
        $this->WifiController = new WifiController();
        $this->VpnController = new VpnController();
    }

    public function Index() : string
    {
        $data['intitule'] = "Ouah ce train à l'air étrange cliquez dessus pour en savoir plus";
        return view('salle_6\AccueilSalle6',$data).
            view('commun\footer');
    }

    public function Vpn():string
    {
        // Appelle directement la méthode Index du VpnController
        return $this->VpnController->Index();
    }

    public function Enigme() : string
    {
        $numeroEnigme = random_int(1, 2);
        if ($numeroEnigme == 1) {
            return $this->Vpn();
        } else {
            return $this->WifiController->Index();
        }
    }

}