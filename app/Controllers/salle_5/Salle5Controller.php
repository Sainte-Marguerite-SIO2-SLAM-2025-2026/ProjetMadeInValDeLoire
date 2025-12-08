<?php

namespace App\Controllers\salle_5;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\commun\SalleModel;
use App\Models\salle_5\IndiceModel;
use App\Models\salle_5\ModeEmploiModel;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ExplicationModel;
use App\Models\salle_5\ZoneModel;

class Salle5Controller extends BaseController
{
    // Liste des énigmes qui utilisent le fond de bureau
    private $enigmes_bureau = [502, 503, 504, 508, 509];

    public function enigme($activite_numero)
    {
        // Instancier les models
        $activiteModel = new ActiviteModel();
        $salleModel = new SalleModel();
        $mascotteModel = new MascotteModel();
        $modeEmploiModel = new ModeEmploiModel();
        $explicationModel = new ExplicationModel();
        $indiceModel = new IndiceModel();

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
//            'salle' => $salleModel->getSalle(5),
//            'mascotte' => $mascotteModel->getMascotteBySalle(5),
            'salle' => $salleModel->getSalleById(5),
            'mascotte' => $mascotteModel->getMascottes(),
            'mode_emploi' => $mode_emploi,
            'explication' => $explication,
            'indice' => $indiceModel->getIndice($activite_numero),
        ];

        // Charger la vue selon si c'est une énigme bureau ou pas
        if (in_array($activite_numero, $this->enigmes_bureau)) {
            // Énigmes sur fond de bureau (2, 3, 4, 8, 9)
            return view('commun/header') .
                view('salle_5/EnigmeBureau', $data) .
                view('commun/footer');
        }

        // Vue par défaut pour les autres énigmes
        return view('commun/header') .
            view('salle_5/EnigmeSalle', $data) .
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
        $zoneModel = new ZoneModel();
        $resultat = $zoneModel->verifierZone($activite_numero, $reponse);

        $messages_echec = [
            501 => ' Échec ! Ce n\'était pas le bon écran à risque, cet écran est vérouillé',
            502 => ' Raté ! Vous ne pouvez pas être sur que cette clé USB est sûre. Elle peut contenir un malware (attaque BadUSB) !',
            503 => ' Incorrect ! Cet objet ne compromet pas directement la sécurité physique.',
            504 => ' Dommage ! Cette zone ne présente pas d\'information confidentielle visible. Cherchez des post-it ou documents sensibles !',
            505 => ' Mauvaise réponse ! La porte entrouverte permet le tailgating (intrusion par filature). Une porte doit toujours être fermée !',
            506 => ' Échec ! Ce n\'est pas la bonne protection contre l\'épaule-surfing (shoulder surfing). Un filtre de confidentialité est nécessaire !',
            507 => ' Raté ! Cette action n\'est pas une contre-mesure efficace. Pensez à fermer/sécuriser la fenêtre et éloigner le matériel sensible.',
            508 => ' Incorrect ! Ce n\'est pas une violation de la politique "clean desk". Un bureau propre ne doit avoir AUCUN document, carnet de mots de passe ou clé USB visible.',
            509 => ' Échec ! Vous n\'avez pas identifié les bonnes erreurs. Les secrets physiques (codes, badges) ne doivent JAMAIS être notés ou affichés, et les mots de passe doivent être forts !',
            510 => ' Mauvaise réponse ! Une caméra de surveillance interne peut poser des problèmes de conformité RGPD. Sûreté ≠ espionnage ; respectez la proportionnalité !'
        ];

        if (!$resultat['valid']) {
            // Mauvaise réponse
            return $this->response->setJSON([
                'success' => false,
                'is_correct' => false,
                'message' => $messages_echec[$activite_numero] ?? 'Mauvaise réponse ! Echec de la salle !'
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
                501 => 'Excellent ! Laisser un poste ouvert permet l\'accès aux données sensibles. Toujours verrouiller (Win+L) !',
                502 => 'Bravo ! Une clé USB inconnue peut contenir un malware (attaque BadUSB).',
                503 => 'Parfait ! Un badge d\'entreprise ne doit jamais être laissé sans surveillance.',
                504 => 'Bien vu ! Les informations confidentielles ne doivent jamais être visibles.',
                505 => 'Excellent ! Les portes doivent être fermées pour éviter les intrusions (tailgating).',
                506 => 'Bravo ! Le shoulder-surfing est un risque physique simple à exploiter (espionner un écran pour voir les données).',
                507 => 'Parfait ! La sécurité physique inclut aussi les ouvrants (risque de vol).',
                508 => 'Félicitations ! La politique "clean desk" réduit le risque de perte/vol d\'infos.  
                Ce terme désigne une approche systématique visant à garantir la sécurité des données sensibles et la confidentialité des informations critiques pour l\'entreprise.',
                509 => 'Super ! Les secrets physiques ne doivent jamais être affichés et les MDP doivent être forts.',
                510 => 'Bien vu ! Sûreté ≠ espionnage interne ; respecter le principe de proportionnalité.'
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



}