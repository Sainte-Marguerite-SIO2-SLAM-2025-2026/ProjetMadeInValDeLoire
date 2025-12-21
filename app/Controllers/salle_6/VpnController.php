<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\salle_6\ProposerVpnModel;
use App\Models\salle_6\VpnModel;

class VpnController extends BaseController
{
    protected $proposerVpnModel;
    protected $vpnModel;

    protected MascotteModel $mascotteModel;

    public function __construct()
    {
        $this->proposerVpnModel = new ProposerVpnModel();
        $this->vpnModel = new VpnModel();
        $this->mascotteModel = new MascotteModel();
    }

    public function Index(): string
    {
        // ID de l'activité (à adapter selon votre logique)
        $activite_numero = 602; // Exemple pour VPN

        // Récupérer les VPN depuis la base de données
        $data['vpns'] = $this->proposerVpnModel->getVpnMelanges($activite_numero);
        //echo isset($data['vpns']) and !is_null(['vpns']);
        $data['intitule'] = "Clique sur les tuyaux pour commencer";

        // recuperer les mascottes
        $data['mascotte'] = $this->mascotteModel->getMascottes();

        // Debug : afficher ce qui est récupéré
        log_message('debug', 'VPN récupérés: ' . print_r($data['vpns'], true));

        // Si aucun VPN n'est trouvé, utiliser des données de test
        if (empty($data['vpns'])) {
            log_message('warning', 'Aucun VPN trouvé en base, utilisation des données de test');
            $data['vpns'] = [
                [   
                    'vpn_numero' => 1,
                    'libelle' => 'Un VPN chiffre votre connexion internet pour la sécuriser',
                    'bonne_reponse' => 1,
                    'activite_numero' => 602
                ],
                [
                    'vpn_numero' => 2,
                    'libelle' => 'Un VPN ralentit toujours votre connexion de 80%',
                    'bonne_reponse' => 0,
                    'activite_numero' => 602
                ],
                [
                    'vpn_numero' => 3,
                    'libelle' => 'Les VPN sont illégaux en France',
                    'bonne_reponse' => 0,
                    'activite_numero' => 602
                ]
            ];
        }

        return view('commun\header') .
            view('salle_6\Vpn', $data) .
            view('commun\footer');
    }

    /**
     * Valide le choix du VPN et redirige vers la page de résultat
     */
    public function validerCarte()
    {
        $vpn_numero = $this->request->getPost('vpn_numero');
        $activite_numero = $this->request->getPost('activite_numero') ?? 602;

        // Si pas de VPN sélectionné
        if (!$vpn_numero) {
            return redirect()->to(base_url('Salle6/VPN'));
        }

        // Vérifier si le choix est correct
        $est_correct = $this->proposerVpnModel->estBonneReponse($vpn_numero, $activite_numero);

        // Récupérer le VPN sélectionné
        $vpn_selectionne = $this->vpnModel->getVpnByNumero($vpn_numero);

        // Récupérer le bon VPN
        $vpn_correct = $this->proposerVpnModel->getBonVpnAlea($activite_numero);

        if ($est_correct) {
            // Stocker les valeurs dans data
            $data['vpn_choisi'] = $vpn_selectionne;
            $data['vpn_correct'] = $vpn_correct;
            $data['est_correct'] = $est_correct;

            return view('commun\header') .
                view('salle_6\VpnInfos', $data) .
                view('commun\footer');
        } else {
            return redirect()->to(base_url('/'));
        }
    }

    /**
     * Méthode de test pour afficher les données
     */
    public function testRecuperationVpn()
    {
        $activite_numero = 602;

        echo "<h2>Test de récupération des VPN</h2>";

        echo "<h3>1 bon VPN aléatoire :</h3>";
        $bonVpn = $this->proposerVpnModel->getBonVpnAlea($activite_numero);
        echo "<pre>";
        print_r($bonVpn);
        echo "</pre>";

        echo "<h3>2 mauvais VPN aléatoires :</h3>";
        $mauvaisVpn = $this->proposerVpnModel->getMauvaisVpnAlea($activite_numero, 2);
        echo "<pre>";
        print_r($mauvaisVpn);
        echo "</pre>";

        echo "<h3>Tous les VPN mélangés :</h3>";
        $vpnMelanges = $this->proposerVpnModel->getVpnMelanges($activite_numero);
        echo "<pre>";
        print_r($vpnMelanges);
        echo "</pre>";
    }
}