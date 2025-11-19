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
        $session = session();

        // Vérifier si les deux énigmes sont complétées
        $wifiComplete = $session->get('wifi_complete') ?? false;
        $vpnComplete = $session->get('vpn_complete') ?? false;

        if ($wifiComplete && $vpnComplete) {
            // Réinitialiser les sessions pour la prochaine fois
            $session->remove('wifi_complete');
            $session->remove('vpn_complete');
            $data['intitule'] = "Félicitations ! Vous avez terminé toutes les énigmes de cette salle !";
            $data['showCongrats'] = true;
        } else {
            $data['intitule'] = "Ouah ce train à l'air étrange cliquez dessus pour en savoir plus";
            $data['showCongrats'] = false;
        }

        return view('salle_6\AccueilSalle6', $data).
            view('commun\footer');
    }

    public function Vpn():string
    {
        // Appelle directement la méthode Index du VpnController
        return $this->VpnController->Index();
    }

    public function Wifi():string
    {
        // Appelle directement la méthode Index du WifiController
        return $this->WifiController->Index();
    }

    public function Enigme()
    {
        $session = session();

        // Vérifier quelles énigmes ont été complétées
        $wifiComplete = $session->get('wifi_complete') ?? false;
        $vpnComplete = $session->get('vpn_complete') ?? false;

        // Si les deux sont complètes, retourner à l'accueil
        if ($wifiComplete && $vpnComplete) {
            return redirect()->to('/Salle6');
        }

        // Si seulement Wifi est complète, aller sur VPN
        if ($wifiComplete && !$vpnComplete) {
            return redirect()->to('/Salle6/VPN');
        }

        // Si seulement VPN est complète, aller sur Wifi
        if ($vpnComplete && !$wifiComplete) {
            return redirect()->to('/Salle6/Wifi');
        }

        // Si aucune n'est complète, choisir aléatoirement
        $numeroEnigme = random_int(1, 2);

        if ($numeroEnigme == 1) {
            return redirect()->to('/Salle6/VPN');
        } else {
            return redirect()->to('/Salle6/Wifi');
        }
    }

    public function CompleteWifi()
    {
        $session = session();
        $session->set('wifi_complete', true);

        // Vérifier si VPN est déjà complété
        $vpnComplete = $session->get('vpn_complete') ?? false;

        if ($vpnComplete) {
            // Les deux sont complétés, retourner à l'accueil
            return redirect()->to('/Salle6/Resultat');
        } else {
            // Aller sur VPN
            return redirect()->to('/Salle6/VPN');
        }
    }

    public function CompleteVpn()
    {
        $session = session();
        $session->set('vpn_complete', true);

        // Vérifier si Wifi est déjà complété
        $wifiComplete = $session->get('wifi_complete') ?? false;

        if ($wifiComplete) {
            // Les deux sont complétés, retourner à l'accueil
            return redirect()->to('/Salle6/Resultat');
        } else {
            // Aller sur Wifi
            return redirect()->to('/Salle6/Wifi');
        }
    }

    public function Fin() : string
    {
        return view('commun\header') .
        view('salle_6\Explication') .
        view('commun\footer');
    }

}