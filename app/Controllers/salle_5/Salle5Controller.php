<?php

namespace App\Controllers\salle_5;

use App\Controllers\BaseController;
use App\Models\salle_5\MascotteModel;
use App\Models\salle_5\ModeEmploiModel;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\SalleModel;
use App\Models\salle_5\ExplicationModel;
use App\Models\salle_5\ZoneModel;

class Salle5Controller extends BaseController
{
    // Liste des énigmes qui utilisent le fond de bureau
    private $enigmes_bureau = [2, 3, 4, 8, 9];

    public function enigme($activite_numero)
    {
        // Instancier les models
        $activiteModel = new ActiviteModel();
        $salleModel = new SalleModel();
        $mascotteModel = new MascotteModel();
        $modeEmploiModel = new ModeEmploiModel();
        $explicationModel = new ExplicationModel();

        // Vérifier que l'activité fait partie des activités sélectionnées
        $activites_ids = session()->get('activites_salle5') ?? [];
        if (!in_array($activite_numero, $activites_ids)) {
            return redirect()->to(base_url('Salle5'))
                ->with('error', 'Cette activité n\'est pas disponible');
        }

        // Vérifier si déjà réussie
        $activites_reussies = session()->get('activites_reussies') ?? [];
        if (in_array($activite_numero, $activites_reussies)) {
            return redirect()->to(base_url('Salle5'))
                ->with('info', 'Vous avez déjà réussi cette énigme !');
        }

        // Récupérer les données via les models
        $activite = $activiteModel->getActivite($activite_numero);

        if (!$activite) {
            return redirect()->to(base_url('Salle5'))
                ->with('error', 'Activité introuvable');
        }

        $mode_emploi = $modeEmploiModel->getModeEmploiByActivite($activite_numero);

        $explication = null;
        if ($activite->explication_numero) {
            $explication = $explicationModel->getExplication($activite->explication_numero);
        }

        // Données pour la vue
        $data = [
            'enigme' => $activite,
            'salle' => $salleModel->getSalle(5),
            'mascotte' => $mascotteModel->getMascotteBySalle(5),
            'mode_emploi' => $mode_emploi,
            'explication' => $explication,
        ];

        // Charger la vue selon si c'est une énigme bureau ou pas
        if (in_array($activite_numero, $this->enigmes_bureau)) {
            // Énigmes sur fond de bureau (2, 3, 4, 8, 9)
            return view('commun\header') .
                view('salle_5/EnigmeBureau', $data) .
                view('commun\footer');
        }

        // Vue par défaut pour les autres énigmes
        return view('commun\header') .
            view('salle_5/Enigme', $data) .
            view('commun\footer');
    }

    public function validerEnigme()
    {
        // Vérifier que c'est une requête AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Requête non autorisée'
            ]);
        }

        $activite_numero = $this->request->getPost('activite_numero');
        $reponse = $this->request->getPost('reponse');

        // Validation
        if (!$activite_numero || !$reponse) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données manquantes'
            ]);
        }

        // Vérifier que l'activité est bien sélectionnée
        $activites_ids = session()->get('activites_salle5') ?? [];
        if (!in_array($activite_numero, $activites_ids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Activité non autorisée'
            ]);
        }

        // Vérifier si déjà réussie
        $activites_reussies = session()->get('activites_reussies') ?? [];
        if (in_array($activite_numero, $activites_reussies)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Énigme déjà réussie'
            ]);
        }

        // Vérifier la réponse via les zones de la BDD
        $zoneModel = new ZoneModel();
        $resultat = $zoneModel->verifierZone($activite_numero, $reponse);

        if ($resultat['valid']) {
            // Ajouter aux activités réussies
            $activites_reussies[] = $activite_numero;
            session()->set('activites_reussies', $activites_reussies);

            // Messages personnalisés par activité
            $messages = [
                2 => 'Excellent ! Une clé USB inconnue est un risque majeur. Elle pourrait contenir un malware (attaque BadUSB).',
                3 => 'Bravo ! Un badge d\'entreprise ne doit jamais être laissé sans surveillance.',
                4 => 'Bien vu ! Les informations confidentielles ne doivent jamais être visibles.',
                5 => 'Parfait ! Les portes doivent toujours être fermées pour éviter les intrusions.',
                6 => 'Très bien ! Les écrans non verrouillés sont une faille de sécurité.',
                7 => 'Exact ! Les fenêtres ouvertes facilitent les vols et intrusions.',
                8 => 'Félicitations ! La politique "clean desk" est essentielle.',
                9 => 'Super ! Les mots de passe ne doivent jamais être notés.',
                10 => 'Bravo ! Les caméras internes doivent être utilisées avec proportionnalité.'
            ];

            return $this->response->setJSON([
                'success' => true,
                'message' => $messages[$activite_numero] ?? 'Bonne réponse !',
                'enigmes_restantes' => 2 - count($activites_reussies)
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Mauvaise réponse, réessayez !'
        ]);
    }

    public function resetSalle()
    {
        session()->remove('activites_salle5');
        session()->remove('activites_reussies');
        return redirect()->to(base_url('Salle5'));
    }
}