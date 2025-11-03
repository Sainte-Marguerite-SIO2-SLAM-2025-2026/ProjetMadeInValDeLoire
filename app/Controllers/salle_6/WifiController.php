<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;

class WifiController extends BaseController
{
    public function Index():string
    {
        return view('commun\header').
            view('salle_6\Wifi').
            view('commun\footer');
    }
    /**
     * Données en dur des WiFi
     */
    private function getWifis()
    {
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

    /**
     * Valide le choix du WiFi et redirige vers la page de résultat
     */
    public function validerCarte()
    {
        $wifi_id = $this->request->getPost('wifi_id');

        if (!$wifi_id) {
            return redirect()->to(base_url('Salle6\Wifi'));
        }

        // Récupérer les données
        $wifis = $this->getWifis();
        $wifi_selectionne = null;
        $wifi_correct = null;

        // Trouver le WiFi sélectionné et le WiFi correct
        foreach ($wifis as $wifi) {
            if ($wifi['id'] == $wifi_id) {
                $wifi_selectionne = $wifi;
            }
            if ($wifi['est_correct']) {
                $wifi_correct = $wifi;
            }
        }

        // Vérifier si le choix est correct
        $est_correct = ($wifi_selectionne && $wifi_selectionne['est_correct']);

        // Stocker les données en session pour les afficher sur la page de résultat
        $session = session();
        $session->set([
            'wifi_choisi' => $wifi_selectionne,
            'wifi_correct' => $wifi_correct,
            'resultat_correct' => $est_correct
        ]);

        // Rediriger vers la page de résultat
        return redirect()->to(base_url('Salle6/wifi/resultat'));
    }

    /**
     * Page de résultat après validation
     */
    public function resultat()
    {
        $session = session();

        // Récupérer les données de la session
        $data['wifi_choisi'] = $session->get('wifi_choisi');
        $data['wifi_correct'] = $session->get('wifi_correct');
        $data['est_correct'] = $session->get('resultat_correct');

        // Si pas de données en session, rediriger vers l'accueil
        if (!$data['wifi_choisi']) {
            return redirect()->to(base_url('Salle6/Wifi'));
        }

        // Nettoyer la session
        $session->remove(['wifi_choisi', 'wifi_correct', 'resultat_correct']);

        return view('commun\header').
            view('salle_6\WifiResultatCarte', $data).
            view('commun\footer');
    }
}