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

        // Récupérer ou initialiser les réponses de l'utilisateur pour cette activité
        $reponses_utilisateur = session()->get('reponses_activite_' . $activite_numero) ?? [];

        // Vérifier la réponse via les zones de la BDD
        $zoneModel = new ZoneModel();
        $resultat = $zoneModel->verifierZone($activite_numero, $reponse);

        if (!$resultat['valid']) {
            // Mauvaise réponse
            return $this->response->setJSON([
                'success' => false,
                'is_correct' => false,
                'message' => 'Mauvaise réponse, réessayez !'
            ]);
        }

        // Bonne réponse : l'ajouter aux réponses de l'utilisateur
        if (!in_array($reponse, $reponses_utilisateur)) {
            $reponses_utilisateur[] = $reponse;
            session()->set('reponses_activite_' . $activite_numero, $reponses_utilisateur);
        }

        // Compter le nombre de bonnes réponses attendues
        $nb_bonnes_reponses_attendues = $zoneModel->countBonnesReponses($activite_numero);
        $nb_reponses_trouvees = count($reponses_utilisateur);

        // Vérifier si toutes les bonnes réponses ont été trouvées
        if ($nb_reponses_trouvees >= $nb_bonnes_reponses_attendues) {
            // Activité complétée !
            $activites_reussies[] = $activite_numero;
            session()->set('activites_reussies', $activites_reussies);
            session()->remove('reponses_activite_' . $activite_numero);

            // Messages personnalisés par activité
            $messages = [
                2 => 'Excellent ! Une clé USB inconnue est un risque majeur. Elle pourrait contenir un malware (attaque BadUSB).',
                3 => 'Bravo ! Un badge d\'entreprise ne doit jamais être laissé sans surveillance.',
                4 => 'Bien vu ! Les informations confidentielles ne doivent jamais être visibles.',
                8 => 'Félicitations ! La politique "clean desk" est essentielle.',
                9 => 'Super ! Les mots de passe ne doivent jamais être notés et il faut toujours choisir des MDP forts.',
            ];

            return $this->response->setJSON([
                'success' => true,
                'is_correct' => true,
                'completed' => true,
                'message' => $messages[$activite_numero] ?? 'Félicitations ! Énigme réussie !',
                'enigmes_restantes' => 2 - count($activites_reussies)
            ]);
        }

        // Bonne réponse mais il en reste d'autres à trouver
        return $this->response->setJSON([
            'success' => true,
            'is_correct' => true,
            'completed' => false,
            'message' => 'Bonne réponse ! Continuez, il en reste d\'autres.',
            'reponses_trouvees' => $nb_reponses_trouvees,
            'total_attendu' => $nb_bonnes_reponses_attendues
        ]);
    }

    public function resetSalle()
    {
        session()->remove('activites_salle5');
        session()->remove('activites_reussies');
        return redirect()->to(base_url('Salle5'));
    }


    public function finSalle()
    {
        // Réinitialiser toutes les sessions de la salle 5
        session()->remove('activites_salle5');
        session()->remove('activites_reussies');
        session()->remove('popup_salle5_vue');

        // Supprimer les réponses temporaires de toutes les activités
        for ($i = 1; $i <= 10; $i++) {
            session()->remove('reponses_activite_' . $i);
        }

        // Rediriger vers la page d'accueil du site
        return redirect()->to(base_url('/'));
    }
}