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

    public function accueilEnigme()
    {
        $activiteModel = new ActiviteModel();
        $salleModel = new SalleModel();
        $mascotteModel = new MascotteModel();
        $objetModel = new ObjetModel();

        // Récupérer 2 activités aléatoires et stocker en session
        if (!session()->has('activites_salle5')) {
            $activites = $activiteModel->getActivitesAleatoires(5, 2);
            $activites_ids = array_column($activites, 'numero');
            session()->set('activites_salle5', $activites_ids);
            session()->set('activites_reussies', []); // Activités terminées
        } else {
            $activites_ids = session()->get('activites_salle5');
            $activites = $activiteModel->whereIn('numero', $activites_ids)->findAll();
        }

        // Récupérer tous les objets
        $objets = $objetModel->where('salle_numero', 5)->findAll();

        // Récupérer les activités déjà réussies
        $activites_reussies = session()->get('activites_reussies') ?? [];

        $data = [
            'activites' => $activites,
            'activites_reussies' => $activites_reussies,
            'objet' => $objets,
            'salle' => $salleModel->find(5),
            'mascotte' => $mascotteModel->where('salle_numero', 5)->first(),
        ];

        return view('commun\header').
            view('salle_5/AccueilEnigme', $data).
            view('commun\footer');
    }

    public function enigme($activite_numero)
    {
        $activiteModel = new ActiviteModel();
        $salleModel = new SalleModel();
        $mascotteModel = new MascotteModel();
        $modeEmploiModel = new ModeEmploiModel();
        $objetModel = new ObjetModel();

        // Vérifier que l'activité fait partie des activités sélectionnées
        $activites_ids = session()->get('activites_salle5');
        if (!in_array($activite_numero, $activites_ids)) {
            return redirect()->to(base_url('enigmeRetour'));
        }

        $activite = $activiteModel->find($activite_numero);

        if (!$activite) {
            return redirect()->to(base_url('enigmeRetour'))->with('error', 'Activité introuvable');
        }

        // Récupérer le mode d'emploi
        $mode_emploi = $modeEmploiModel->where('activite_numero', $activite_numero)->first();

        // Récupérer les objets spécifiques selon l'activité
        $usb_finance = $objetModel->where('libelle', 'usb_finance')->first();
        $usb_ano = $objetModel->where('libelle', 'usb_anonyme')->first();
        $usb_rh = $objetModel->where('libelle', 'usb_rh')->first();

        $data = [
            'enigme' => $activite,
            'salle' => $salleModel->find(5),
            'mascotte' => $mascotteModel->where('salle_numero', 5)->first(),
            'mode_emploi' => $mode_emploi,
            'usb_finance' => $usb_finance,
            'usb_ano' => $usb_ano,
            'usb_rh' => $usb_rh,
        ];

        return view('salle_5/Enigme', $data);
    }

    public function validerEnigme()
    {
        $activite_numero = $this->request->getPost('activite_numero');
        $reponse = $this->request->getPost('reponse');

        // Vérifier la réponse (à adapter selon ton énigme)
        $correct = ($reponse === 'B'); // USB anonyme = mauvaise réponse

        if ($correct) {
            // Ajouter l'activité aux activités réussies
            $activites_reussies = session()->get('activites_reussies') ?? [];
            if (!in_array($activite_numero, $activites_reussies)) {
                $activites_reussies[] = $activite_numero;
                session()->set('activites_reussies', $activites_reussies);
            }

            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Mauvaise réponse']);
    }

    public function resetSalle()
    {
        session()->remove(['activites_salle5', 'activites_reussies']);
        return redirect()->to(base_url('Salle5'));
    }

}