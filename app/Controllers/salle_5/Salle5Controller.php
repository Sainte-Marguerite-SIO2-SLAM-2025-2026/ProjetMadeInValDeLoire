<?php

namespace App\Controllers\salle_5;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\commun\SalleModel;
use App\Models\salle_5\AvoirRepModel;
use App\Models\commun\IndiceModel;
use App\Models\salle_5\messageReponseModel;
use App\Models\salle_5\ModeEmploiModel;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ExplicationModel;
use App\Models\salle_5\ObjetsActiviteModel;

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
        $indiceModel = new IndiceModel();
        $objetsActiviteModel = new ObjetsActiviteModel();

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
            'salle' => $salleModel->getSalleById(5),
            'mascotte' => $mascotteModel->getMascottes(),
            'mode_emploi' => $mode_emploi,
            'explication' => $explication,
            'indice' => $indiceModel->getIndice($activite_numero),
            'objets_activite' => $objetsActiviteModel->getObjetsActivite($activite_numero),
        ];

        return view('commun/header') .
            view('salle_5/Enigme', $data) .
            view('commun/footer');
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
        $avoirRepModel = new AvoirRepModel();
        $resultat = $avoirRepModel->verifierZone($activite_numero, $reponse);

        $messageReponse = new messageReponseModel();
        $msg = $messageReponse->getMessageEchec($activite_numero);


        if (!$resultat['valid']) {
            // Mauvaise réponse
            return $this->response->setJSON([
                'success' => false,
                'is_correct' => false,
                'message' => $msg->message ?? 'Mauvaise réponse ! Echec de la salle !'
            ]);
        }

        // Bonne réponse : l'ajouter aux réponses de l'utilisateur
        if (!in_array($reponse, $reponses_utilisateur)) {
            $reponses_utilisateur[] = $reponse;
            session()->set('reponses_activite_' . $activite_numero, $reponses_utilisateur);
        }

        // Compter le nombre de bonnes réponses attendues
        $nb_bonnes_reponses_attendues = $avoirRepModel->countBonnesReponses($activite_numero);
        $nb_reponses_trouvees = count($reponses_utilisateur);

        // Vérifier si toutes les bonnes réponses ont été trouvées
        if ($nb_reponses_trouvees >= $nb_bonnes_reponses_attendues) {
            // Activité complétée !
            $activites_reussies[] = $activite_numero;
            session()->set('activites_reussies', $activites_reussies);
            session()->remove('reponses_activite_' . $activite_numero);


            $msg = $messageReponse->getMessageSucces($activite_numero);

            return $this->response->setJSON([
                'success' => true,
                'is_correct' => true,
                'completed' => true,
                'message' => $msg->message ?? 'Félicitations ! Énigme réussie !',
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
}