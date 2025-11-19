<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;
use App\Models\salle_6\ProposerWifiModel;
use App\Models\salle_6\WifiModel;

class WifiController extends BaseController
{
    protected $proposerWifiModel;
    protected $wifiModel;

    public function __construct()
    {
        $this->proposerWifiModel = new ProposerWifiModel();
        $this->wifiModel = new WifiModel();
    }

    public function Index(): string
    {
        // ID de l'activité (à adapter selon votre logique)
        $activite_numero = 1; // Exemple

        // Récupérer les WiFi depuis la base de données
        $data['wifis'] = $this->proposerWifiModel->getWifiMelanges($activite_numero);

        // Alternative : récupérer séparément bon et mauvais WiFi
        // $wifiPourJeu = $this->proposerWifiModel->getWifiPourJeu($activite_numero);
        // $data['bon_wifi'] = $wifiPourJeu['bon'];
        // $data['mauvais_wifi'] = $wifiPourJeu['mauvais'];

        return view('commun\header') .
            view('salle_6\WifiCartes', $data) .
            view('commun\footer');
    }

    /**
     * Valide le choix du WiFi et redirige vers la page de résultat
     */
    public function validerCarte()
    {
        $this->proposerWifiModel = new ProposerWifiModel();
        $this->wifiModel = new WifiModel();

        $wifi_numero = $this->request->getPost('wifi_numero');
        $activite_numero = $this->request->getPost('activite_numero') ?? 1;

        // Si pas de wifi séléctionner
        if (!$wifi_numero) {
            return redirect()->to(base_url('Salle6/WifiCartes'));
        }

        // Vérifier si le choix est correct
        $est_correct = $this->proposerWifiModel->estBonneReponse($wifi_numero, $activite_numero);

        // Récupérer le WiFi sélectionné
        $wifi_selectionne = $this->wifiModel->getWifiByNumero($wifi_numero);

        // Récupérer le bon WiFi
        $wifi_correct = $this->proposerWifiModel->getBonWifiAlea($activite_numero);

        if ($est_correct) {
        // Stocker les valeurs dans data
        $data['wifi_choisi'] = $wifi_selectionne;
        $data['wifi_correct'] = $wifi_correct;
        $data['est_correct'] = $est_correct;

        return view('commun\header') .
            view('salle_6\WifiInfos', $data) .
            view('commun\footer');
        }
        else {
            return redirect()->to(base_url('/'));
        }
    }

    /**
     * Méthode de test pour afficher les données
     */
    public function testRecuperationWifi()
    {
        $activite_numero = 1;

        echo "<h2>Test de récupération des WiFi</h2>";

        echo "<h3>1 bon WiFi aléatoire :</h3>";
        $bonWifi = $this->proposerWifiModel->getBonWifiAlea($activite_numero);
        echo "<pre>";
        print_r($bonWifi);
        echo "</pre>";

        echo "<h3>2 mauvais WiFi aléatoires :</h3>";
        $mauvaisWifi = $this->proposerWifiModel->getMauvaisWifiAlea($activite_numero, 2);
        echo "<pre>";
        print_r($mauvaisWifi);
        echo "</pre>";

        echo "<h3>Tous les WiFi mélangés :</h3>";
        $wifiMelanges = $this->proposerWifiModel->getWifiMelanges($activite_numero);
        echo "<pre>";
        print_r($wifiMelanges);
        echo "</pre>";
    }
}
