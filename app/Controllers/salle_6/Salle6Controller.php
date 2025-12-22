<?php

namespace App\Controllers\salle_6;

use App\Controllers\BaseController;
use App\Controllers\salle_6\WifiController;
use App\Controllers\salle_6\VpnController;
use App\Models\commun\MascotteModel;
use App\Models\salle_6\ExplicationModel;
use App\Models\salle_6\ProposerWifiModel;
use App\Models\salle_6\ProposerVpnModel;
use App\Models\salle_6\Salle6Model;

class Salle6Controller extends BaseController
{
    protected const NB_SALLE = 6;
    protected WifiController $WifiController;
    protected VpnController $VpnController;
    protected ExplicationModel $ExplicationModel;
    protected ProposerWifiModel $ProposerWifiModel;
    protected ProposerVpnModel $ProposerVpnModel;
    protected Salle6Model $Salle6Model;
    protected MascotteModel $mascotteModel;

    public function __construct()
    {
        $this->WifiController = new WifiController();
        $this->VpnController = new VpnController();
        $this->ExplicationModel = new ExplicationModel();
        $this->ProposerWifiModel = new ProposerWifiModel();
        $this->ProposerVpnModel = new ProposerVpnModel();
        $this->Salle6Model = new Salle6Model();
        $this->mascotteModel = new MascotteModel();
    }

    public function Index(): string
    {
        $session = session();
        $this->RazSession(); // pour éviter les bugs quand lien forcer

        // Vérifier si les deux énigmes sont complétées
        $wifiComplete = $session->get('wifi_complete') ?? false;
        $vpnComplete = $session->get('vpn_complete') ?? false;

        // Récupérer l'explication depuis la BDD (numéro à adapter selon vos données)
        $explication = $this->ExplicationModel->getExplication(601);

        // Récupérer les infos de la salle dans la bdd
        $infosSalle = $this->Salle6Model->getSalleById(self::NB_SALLE);
        $data['infosSalle'] = $infosSalle;
        $intitule = $this->ExplicationModel->getExplication(601);
        $data['intitule'] = $intitule['libelle'];

        // recuperer les mascottes
        $data['mascotte'] = $this->mascotteModel->getMascottes();

        // Passer l'explication à la vue
        $data['explication'] = $explication['libelle'] ?? 'Texte par défaut';

        return view('commun\header') .
            view('salle_6\AccueilSalle6', $data) .
            view('commun\footer');
    }

    public function Vpn(): string
    {
        return $this->VpnController->Index();
    }

    public function Wifi(): string
    {
        return $this->WifiController->Index();
    }

    public function Enigme()
    {
        $session = session();

        $wifiComplete = $session->get('wifi_complete') ?? false;
        $vpnComplete = $session->get('vpn_complete') ?? false;

        //Si l'utilisateur a fini toutes les énigmes
        if ($wifiComplete && $vpnComplete) {
            return redirect()->to('/Salle6');
        }

        //Si l'utilisateur a fini wifi
        if ($wifiComplete && !$vpnComplete) {
            return redirect()->to('/Salle6/vpn');
        }

        // Si l'utilisateur a fini vpn
        if ($vpnComplete && !$wifiComplete) {
            return redirect()->to('/Salle6/Wifi');
        }

        // Si l'utilisateur vient de commencer la salle
        $numeroEnigme = random_int(1, 2);

        if ($numeroEnigme == 1) {
            return redirect()->to('/Salle6/vpn');
        } else {
            return redirect()->to('/Salle6/Wifi');
        }
    }

    public function CompleteWifi()
    {
        $session = session();

        // Récupérer l'information sélectionnée depuis POST
        $info_selectionnee = $this->request->getPost('info_selectionnee');
        $wifi_numero = $this->request->getPost('wifi_numero');
        $activite_numero = $this->request->getPost('activite_numero') ?? 601;

        // Vérifier si tous les paramètres sont présents
        if (!$info_selectionnee || !$wifi_numero) {
            return redirect()->to('/Salle6/Explication');
        }

        // Récupérer la zone cliquable correcte depuis la base de données
        $zone_correcte = $this->ProposerWifiModel->getZoneClique($wifi_numero, $activite_numero);

        // Vérifier si la réponse est correcte
        if ($info_selectionnee === $zone_correcte) {
            // Marquer l'énigme comme complétée seulement si correct
            $session->set('wifi_complete', true);

            $vpnComplete = $session->get('vpn_complete') ?? false;

            if ($vpnComplete) {
                return redirect()->to('/Salle6/Explication');
            } else {
                return redirect()->to('/Salle6/vpn');
            }
        }

        // Si réponse incorrecte, rediriger vers Explication
        return redirect()->to('/Salle6/Explication');
    }

    public function CompleteVpn()
    {
        $session = session();

        // Récupérer le vpn_numero depuis POST
        $vpn_numero = $this->request->getPost('vpn_numero');
        $activite_numero = 602; // vpn

        // Vérifier si la réponse est correcte
        if ($vpn_numero) {
            $est_correct = $this->ProposerVpnModel->estBonneReponse($vpn_numero, $activite_numero);

            if ($est_correct) {
                // Marquer l'énigme comme complétée seulement si correct
                $session->set('vpn_complete', true);

                $wifiComplete = $session->get('wifi_complete') ?? false;

                if ($wifiComplete) {
                    return redirect()->to('/Salle6/Explication');
                } else {
                    return redirect()->to('/Salle6/Wifi');
                }
            }
        }

        // Si pas de vpn_numero ou réponse incorrecte, rediriger vers Explication
        return redirect()->to('/Salle6/Explication');
    }

    public function Fin(): string
    {
        // Récupérer l'explication pour la page de fin
        $explication = $this->ExplicationModel->getExplication(602);
        $data['explication'] = $explication['libelle'] ?? 'Vous maîtrisez maintenant les concepts de sécurité WiFi et vpn.';

        // Message de résultat optionnel (peut être personnalisé)
        $data['messageResultat'] = 'Vous avez brillamment résolu toutes les énigmes de cette salle !';

        return view('commun\header') .
            view('salle_6\Explication', $data) .
            view('commun\footer');
    }

    public function Explication()
    {
        $session = session();

        // Vérifier que les deux énigmes sont bien complétées
        $wifiComplete = $session->get('wifi_complete') ?? false;
        $vpnComplete = $session->get('vpn_complete') ?? false;

        // On test si l'utilisateur a fini la salle
        if (!$wifiComplete || !$vpnComplete) {
            $data['urlImgMascotte'] = base_url('images/commun/mascotte/mascotte_saoulee');
            $data['texteBtnValider'] = "Retour à l'accueil";

            // Récupérer les explications de la BDD
            $explication = $this->ExplicationModel->getExplication(604);
            $data['explication'] = $explication['libelle'] ?? "Tu n'as pas réussi à valider cette salle… cette fois-ci !
            Mais ne baisse pas les bras : chaque échec t'aide à mieux comprendre les mécanismes de sécurité et à renforcer tes compétences.
                Reviens quand tu veux pour retenter l'expérience : la salle t'attend, et je suis sûr que tu finiras par la résoudre !";
            $data['intituleMessage'] = 'Dommage !';
        }
        else{
            $data['urlImgMascotte'] = base_url('images/commun/mascotte/mascotte_contente');
            $data['texteBtnValider'] = "Continuer d'explorer le manoir";

            // Récupérer les félicitations de la BDD
            $explication = $this->ExplicationModel->getExplication(602);
            $data['explication'] = $explication['libelle'] ?? 'Vous maîtrisez maintenant les concepts de sécurité WiFi et vpn.';
            $data['messageResultat'] = 'Vous avez brillamment résolu toutes les énigmes de cette salle !';
            $data['intituleMessage'] = '🎉 Félicitations ! 🎉';
        }

        return view('salle_6\Explication', $data) .
            view('commun\footer');
    }

    public function RazSession()
    {
        $session = session();
        // Réinitialiser les sessions
        $session->remove('wifi_complete');
        $session->remove('vpn_complete');
    }

    // Permet de revenir à l'accueil depuis le bouton accueil
    public function QuitterSalleBtnAccueil()
    {
        $session = session();
        $this->RazSession();
        // Test si on est en mode jour ou nuit
        $mode = $session->get('mode') ?? 'nuit';
        $urlRetour = ($mode === 'jour') ? base_url() . 'manoirJour' : base_url();

        // Renvoie à la page d'accueil selon le mode
        return redirect()->to($urlRetour);
    }

    // Gère la réussite ou l'échec de la salle et reviens à l'accueil
    public function QuitterSalle()
    {
        $session = session();
        $mode = $session->get('mode') ?? 'nuit';

        // Vérifier que les deux énigmes sont bien complétées
        $wifiComplete = $session->get('wifi_complete') ?? false;
        $vpnComplete = $session->get('vpn_complete') ?? false;

        // Test si l'utilisateur a réussi la salle
        if ($wifiComplete && $vpnComplete) {
            // Test si on est en mode jour ou nuit
            $urlRetour = ($mode === 'jour') ? base_url() . 'validerJour/6' : base_url() . 'valider/6';
        }
        else {
            // Test si on est en mode jour ou nuit
            $urlRetour = ($mode === 'jour') ? base_url() . 'echouerJour/6' : base_url() . 'reset';
        }

        // Réinitialiser les sessions après avoir vérifié
        $this->RazSession();

        // Renvoie à la page d'accueil pour l'instant sans changement
        return redirect()->to($urlRetour);
    }
}