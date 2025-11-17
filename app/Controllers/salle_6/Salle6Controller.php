<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;
use App\Controllers\salle_6\WifiController;

class Salle6Controller extends BaseController
{

    protected $WifiController;

    public function __construct()
    {
        $this->WifiController = new WifiController();
    }

    public function Index() : string
    {
        $data['intitule'] = "Ouah ce train à l'air étrange cliquez dessus pour en savoir plus";
        return view('salle_6\AccueilSalle6',$data).
            view('commun\footer');
    }

    /**
     * Données en dur des WiFi pour test
     */
    private function get_wifis() {
        return [
            [
                'id' => '1',
                'nom' => 'FreeWifi',
                'type' => 'Public',
                'chiffrement' => 'WPA2',
                'est_correct' => false
            ],
            [
                'id' => '2',
                'nom' => 'Livebox-A3F2',
                'type' => 'Privé',
                'chiffrement' => 'WPA3',
                'est_correct' => true
            ],
            [
                'id' => '3',
                'nom' => 'SFR-Guest',
                'type' => 'Public',
                'chiffrement' => 'WPA2-PSK',
                'est_correct' => false
            ]
        ];
    }

    public function Vpn():string
    {
        return view('commun\header').
            view('salle_6\Vpn').
            view('commun\footer');
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