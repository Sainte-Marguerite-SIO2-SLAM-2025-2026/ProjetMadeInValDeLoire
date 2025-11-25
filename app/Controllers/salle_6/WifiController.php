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
        $activite_numero = 601; // Exemple

        // Récupérer les WiFi depuis la base de données
        $data['wifis'] = $this->proposerWifiModel->getWifiMelanges($activite_numero);
        $data['intitule'] = "Clique sur les cartes pour commencer";

        return view('commun\header') .
            view('salle_6\WifiCartes', $data) .
            view('commun\footer');
    }

    /**
     * Valide le choix du WiFi et redirige vers la page WifiInfos
     */
    public function validerCarte()
    {
        $wifi_numero = $this->request->getPost('wifi_numero');
        $activite_numero = $this->request->getPost('activite_numero') ?? 601;

        // Si pas de wifi sélectionné
        if (!$wifi_numero) {
            return redirect()->to(base_url('Salle6/Wifi'));
        }

        // Vérifier si le choix est correct
        $est_correct = $this->proposerWifiModel->estBonneReponse($wifi_numero, $activite_numero);

        // Si incorrect, rediriger vers Explication
        if (!$est_correct) {
            return redirect()->to(base_url('Salle6/Explication'));
        }

        // Si correct, continuer vers WifiInfos
        // Récupérer le WiFi sélectionné avec toutes ses informations
        $wifi_selectionne = $this->wifiModel->getWifiByNumero($wifi_numero);

        // Récupérer la zone cliquable correcte pour ce WiFi
        $zone_correcte = $this->proposerWifiModel->getZoneClique($wifi_numero, $activite_numero);

        // Stocker les valeurs dans data
        $data['wifi'] = $wifi_selectionne;
        $data['wifi_numero'] = $wifi_numero;
        $data['zone_correcte'] = $zone_correcte; // Ajouter la zone correcte
        $data['activite_numero'] = $activite_numero;
        $data['intitule'] = "Clique sur les cartes a nouveau pour commencer";

        return view('commun\header') .
            view('salle_6\WifiInfos', $data) .
            view('commun\footer');
    }

    /**
     * Méthode de test pour afficher les données
     */
    public function testRecuperationWifi()
    {
        $activite_numero = 601;

        echo "<h2>Test de récupération des WiFi</h2>";

        echo "<h3>1 bon WiFi aléatoire :</h3>";
        $bonWifi = $this->proposerWifiModel->getBonWifiAlea($activite_numero);
        echo "<pre>";
        print_r($bonWifi);
        echo "</pre>";

        echo "<h3>Zone cliquable pour le bon WiFi :</h3>";
        if ($bonWifi) {
            $zone = $this->proposerWifiModel->getZoneClique($bonWifi['wifi_numero'], $activite_numero);
            echo "Zone correcte : " . $zone;
        }

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