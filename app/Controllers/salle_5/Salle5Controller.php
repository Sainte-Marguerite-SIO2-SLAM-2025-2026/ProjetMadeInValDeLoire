<?php

namespace App\Controllers\salle_5;

use App\Controllers\BaseController;
use App\Models\salle_5\MascotteModel;
use App\Models\salle_5\ModeEmploiModel;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ObjetModel;
use App\Models\salle_5\SalleModel;
use App\Models\salle_5\ExplicationModel;

class Salle5Controller extends BaseController
{

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

        // Charger la vue selon l'activité
        if ($activite_numero == 2) {
            // Énigme des clés USB
            return view('commun\header') .
                view('salle_5/enigmes/ClesUsb', $data) .
                view('commun\footer');
        }

        // Vue par défaut
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

        // Vérifier la réponse via le model
        $activiteModel = new ActiviteModel();
        $resultat = $activiteModel->verifierReponse($activite_numero, $reponse);

        if ($resultat['valid']) {
            // Ajouter aux activités réussies
            $activites_reussies[] = $activite_numero;
            session()->set('activites_reussies', $activites_reussies);

            return $this->response->setJSON([
                'success' => true,
                'message' => $resultat['message'],
                'enigmes_restantes' => 2 - count($activites_reussies)
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => $resultat['message']
        ]);
    }

    public function resetSalle()
    {
        session()->remove('activites_salle5');
        session()->remove('activites_reussies');
        return redirect()->to(base_url('Salle5'));
    }

}