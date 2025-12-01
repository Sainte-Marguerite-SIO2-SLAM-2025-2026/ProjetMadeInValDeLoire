<?php

namespace App\Controllers;

use App\Models\salle_1\Salle1ExplicationModel;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ExplicationModel;
use App\Models\salle_5\IndiceModel;
use App\Models\salle_5\MascotteModel;
use App\Models\salle_5\SalleModel;
use CodeIgniter\HTTP\RedirectResponse;
use App\Controllers\salle_6\Salle6Controller;

class HomeControlleur extends BaseController
{

    // Constantes de configuration
    private const MIN_ROOM = 1;
    private const MAX_ROOM = 6;

    // Clés de session
    private const SESSION_CURRENT_ROOM = 'current_room';
    private const SESSION_COMPLETED_ROOMS = 'completed_rooms';
    private const SESSION_FAILED_ROOMS = 'failed_rooms';

    /**
     * Page d'accueil du manoir
     *
     * @return string
     */
    public function index(): string
    {
        $this->initSession();
        session()->set('mode', 'nuit');
        $data = [
            'current_room' => session()->get(self::SESSION_CURRENT_ROOM),
            'completed_rooms' => session()->get(self::SESSION_COMPLETED_ROOMS)
        ];
        $this->resetSalle4();
        $this->resetSalle5();

        return view('commun/header.php').
            view('manoir_home', $data).
            view('commun/footer.php');
    }

    /**
     * Page du mode jour
     *
     * @return string
     */
    public function pagejour(): string
    {
        session()->set('mode', 'jour');
        $this->resetSalle4();
        $this->resetSalle5();
        return view('commun/header.php').
            view('manoir_jour_home').
            view('commun/footer.php');
    }

    /**
     * Affiche une salle spécifique
     *
     * @param int $numero Numéro de la salle
     * @return string|RedirectResponse
     */
    public function salle($numero) : string|RedirectResponse
    {
        // Validation du numéro de salle
        if (!$this->salleValide($numero)) {
            return redirect()->to('/')
                ->with('error', 'Numéro de salle invalide');
        }

        // Vérification de l'existence de la vue
        $viewPath = "salle_{$numero}/AccueilSalle{$numero}";
        if (!$this->controleExisteView($viewPath)) {
            log_message('error', "Vue manquante : {$viewPath}");
            return redirect()->to('/')
                ->with('error', 'Salle indisponible');
        }

        if ((int)$numero === 1)
        {
            $explicationModel = new Salle1ExplicationModel();
            $data = ['explication' => $explicationModel->getExplicationSalle1()];
            return view('salle_1/AccueilSalle1', $data).
                view('commun/footer');
        }

        if ((int)$numero === 4){
            $session = session();

            // Vérifier si c'est la première visite de la salle 4
            $premiereVisite = !$session->has('salle4_visited');

            // Marquer la salle comme visitée
            if ($premiereVisite) {
                $session->set('salle4_visited', true);
            }
            $data = [
                'frise_validee' => false,
                'quiz_disponible' =>false,
                'premiere_visite' => $premiereVisite,
            ];

            return view('salle_4/AccueilSalle4', $data) . view('commun/footer');
        }


        if ((int)$numero === 5){
            // Instancier les models
            $salleModel = new SalleModel();
            $mascotteModel = new MascotteModel();
            $explicationModel = new ExplicationModel();
            $activiteModel = new ActiviteModel();
            $IndiceModel = new IndiceModel();

            // 🔥 Vérifier si on arrive avec un échec
            $echec = $this->request->getGet('echec');
            $activite_echec = $this->request->getGet('activite');

            if ($echec == 1 && $activite_echec) {
                // ❌ ÉCHEC : Réinitialiser la progression de cette énigme
                $activites_reussies = session()->get('activites_reussies') ?? [];

                // Retirer l'activité des réussies si elle y était
                $activites_reussies = array_diff($activites_reussies, [$activite_echec]);
                session()->set('activites_reussies', $activites_reussies);

                // Supprimer les réponses temporaires de cette activité
                session()->remove('reponses_activite_' . $activite_echec);
            }

            // Initialiser les activités en session si nécessaire
            if (!session()->has('activites_salle5')) {
                $activites = $activiteModel->getActivitesAleatoires(5, 2);

                if (count($activites) >= 2) {
                    $activites_ids = array_column($activites, 'numero');
                    session()->set('activites_salle5', $activites_ids);
                    session()->set('activites_reussies', []);
                    session()->remove('popup_salle5_vue');
                }
            }

            // Vérifier si toutes les énigmes sont terminées
            $activites_ids = session()->get('activites_salle5') ?? [];
            $activites_reussies = session()->get('activites_reussies') ?? [];

            $afficher_popup_succes = false;
            if (count($activites_reussies) === 2 && count($activites_ids) === 2) {
                $afficher_popup_succes = true;
            }

            // Vérifier si la popup a déjà été vue
            $afficher_popup = !session()->has('popup_salle5_vue');

            // Marquer la popup comme vue
            if ($afficher_popup) {
                session()->set('popup_salle5_vue', true);
            }

            // 🔥 Popup d'échec si paramètre présent
            $afficher_popup_echec = ($echec == 1 && $activite_echec);

            // Récupérer les données via les models
            $data = [
                'salle' => $salleModel->getSalle(5),
                'mascotte' => $mascotteModel->getMascotteBySalle(5),
                'explication' => $explicationModel->getExplication(0),
                'activites_selectionnees' => $activites_ids,
                'activites_reussies' => $activites_reussies,
                'afficher_popup' => $afficher_popup,
                'afficher_popup_succes' => $afficher_popup_succes,
                'afficher_popup_echec' => $afficher_popup_echec,
                'indice' => $IndiceModel->getIndice(500),
            ];
        }

        if ((int)$numero === 6)
        {
            $salle6 = new Salle6Controller();
            return $salle6->Index();
        }

        $data['numero_salle'] = $numero;

        return view('commun/header').
            view($viewPath, $data).
            view('commun/footer');
    }

    /**
     * Valide la complétion d'une salle et génère la suivante
     *
     * @param int $numero Numéro de la salle complétée
     * @return RedirectResponse
     */
    public function valider($numero): RedirectResponse
    {
        // contrôle sur le numéro de salle
        if (!$this->salleValide($numero)) {
            return redirect()->to('/')
                ->with('error', 'Numéro de salle invalide');
        }
        $this->resetSalle4();
        $this->resetSalle5();

        // Marque la salle comme complétée
        $this->ajouteSalleComplete($numero);

        // Détermine la prochaine salle
        $nextRoom = $this->getSalleSuivante();

        // Toutes les salles sont complétées
        if ($nextRoom === null) {
            session()->set(self::SESSION_CURRENT_ROOM, -1);
//            return redirect()->to('/')
//                ->with('success', 'Félicitations ! Vous avez terminé toutes les salles !');
            return redirect()->to('/quiz/choix/nuit');
        }

        // Stocke la prochaine salle
        session()->set(self::SESSION_CURRENT_ROOM, $nextRoom);

        return redirect()->to('/')
            ->with('success', "Salle {$numero} complétée ! Direction la salle {$nextRoom}.");

    }

    /**
     * Valide la salle en mode jour
     *
     * @param int $numero Numéro de la salle complétée
     * @return RedirectResponse
     */
    public function validerJour($numero): RedirectResponse
    {
        // contrôle sur le numéro de salle
        if (!$this->salleValide($numero)) {
            return redirect()->to('manoirJour')
                ->with('error', 'Numéro de salle invalide');
        }
        $this->resetSalle4();
        $this->resetSalle5();
        // Marque la salle comme complétée
        $this->ajouteSalleComplete($numero);

        return redirect()->to('manoirJour')
            ->with('success', "Salle {$numero} complétée !");
    }

    public function echouerJour($numero): RedirectResponse
    {
        if (!$this->salleValide($numero)) {
            return redirect()->to('manoirJour')
                ->with('error', 'Numéro de salle invalide');
        }
        $this->resetSalle4();
        $this->resetSalle5();
        // Marque la salle comme échouée
        $this->ajouteSalleEchouee($numero);
        log_message('warning', 'salle échouée --echouerJour-- : ' . $numero);

        return redirect()->to('manoirJour')
            ->with('error', "Salle {$numero} échouée !");
    }

    /**
     * Réinitialise la progression du joueur
     *
     * @return RedirectResponse
     */
    public function reset(): RedirectResponse
    {
        session()->remove(self::SESSION_CURRENT_ROOM);
        session()->remove(self::SESSION_COMPLETED_ROOMS);
        session()->remove('mode');
        return redirect()->to('/')
            ->with('success', 'Parcours réinitialisé ! Bonne chance !');
    }

    /**
     * Réinitialise la progression du joueur
     *
     * @return RedirectResponse
     */
    public function resetSalleJour(): RedirectResponse
    {
        session()->remove(self::SESSION_CURRENT_ROOM);
        session()->remove(self::SESSION_COMPLETED_ROOMS);
        session()->remove(self::SESSION_FAILED_ROOMS);

        return redirect()->to('/manoirJour');
    }


    /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /*                         méthodes privées ... internes donc ...                         */
    /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /**
     * Initialise les données de session si nécessaire
     *
     * @return void
     */
    private function initSession(): void
    {
        if (!session()->has(self::SESSION_CURRENT_ROOM)) {
            session()->set(self::SESSION_CURRENT_ROOM, rand(self::MIN_ROOM, self::MAX_ROOM));
        }

        if (!session()->has(self::SESSION_COMPLETED_ROOMS)) {
            session()->set(self::SESSION_COMPLETED_ROOMS, []);
        }

        if (!session()->has(self::SESSION_FAILED_ROOMS)) {
            session()->set(self::SESSION_FAILED_ROOMS, []);
        }

    }

    /**
     * Vérifie si un numéro de salle est valide
     *
     * @param int $numero Numéro de salle à vérifier
     * @return bool
     */
    private function salleValide(int $numero): bool
    {
        return $numero >= self::MIN_ROOM && $numero <= self::MAX_ROOM;
    }

    /**
     * Vérifie si une vue existe
     *
     * @param string $viewPath Chemin de la vue
     * @return bool
     */
    private function controleExisteView(string $viewPath): bool
    {
        $viewFile = APPPATH . 'Views/' . $viewPath . '.php';
        return file_exists($viewFile);
    }

    /**
     * Marque (ajoute) une salle comme complétée
     *
     * @param int $numero Numéro de la salle à marquer
     * @return void
     */
    private function ajouteSalleComplete(int $numero): void
    {
        $completed = session()->get(self::SESSION_COMPLETED_ROOMS) ?? [];

        if (!in_array($numero, $completed, true)) {
            $completed[] = $numero;
            session()->set(self::SESSION_COMPLETED_ROOMS, $completed);

        }
        // Retirer de failed_rooms si présent
        $failed = session()->get(self::SESSION_FAILED_ROOMS) ?? [];
        if (($key = array_search($numero, $failed, true)) !== false) {
            unset($failed[$key]);
            // ré-indexer le tableau pour éviter les trous
            $failed = array_values($failed);
            session()->set(self::SESSION_FAILED_ROOMS, $failed);
        }
    }

    /**
     * Marque (ajoute) une salle comme échouée
     *
     * @param int $numero Numéro de la salle à marquer
     * @return void
     */
    private function ajouteSalleEchouee(int $numero): void
    {
        $failed = session()->get(self::SESSION_FAILED_ROOMS) ?? [];
        if (!in_array($numero, $failed, true)) {
            $failed[] = $numero;
            session()->set(self::SESSION_FAILED_ROOMS, $failed);
        }
        // Retirer de completed_rooms si présent
        $completed = session()->get(self::SESSION_COMPLETED_ROOMS) ?? [];
        if (($key = array_search($numero, $completed, true)) !== false) {
            unset($completed[$key]);
            // ré-indexer le tableau pour éviter les "trous"
            $completed = array_values($completed);
            session()->set(self::SESSION_COMPLETED_ROOMS, $completed);
        }
    }


    /**
     * Détermine la prochaine salle aléatoire parmi celles non complétées
     * constantes définies à 1 en min et 6 en max
     * @return int|null Numéro de la prochaine salle ou null si toutes sont complétées
     */
    private function getSalleSuivante(): ?int
    {
        $completed = session()->get(self::SESSION_COMPLETED_ROOMS) ?? [];
        $allRooms = range(self::MIN_ROOM, self::MAX_ROOM);
        $remainingRooms = array_diff($allRooms, $completed);

        if (empty($remainingRooms)) {
            return null;
        }
        $index = random_int(0, count($remainingRooms) - 1);
        return $remainingRooms[array_rand($remainingRooms)];
    }

    /**
     * vide toutes les sessions de la salle 5
     * @return void
     */
    private function resetSalle5()
    {
        // Réinitialiser toutes les sessions de la salle 5
        session()->remove('activites_salle5');
        session()->remove('activites_reussies');
        session()->remove('popup_salle5_vue');

        // Supprimer les réponses temporaires de toutes les activités
        for ($i = 1; $i <= 10; $i++) {
            session()->remove('reponses_activite_' . $i);
        }
    }


    /**
     * vide toutes les sessions de la salle 4
     * @return RedirectResponse
     */
    public function resetSalle4()
    {
        $session = session();
        $session->remove('salle4_visited');
        $session->remove('frise_validee');
        $session->remove('activite_choisie');
        $session->remove('positions_cartes_frise');
        $session->remove('quiz_questions');
        $session->remove('quiz_reponses');
        $session->remove('quiz_score');

        return redirect()->to(base_url('Salle4'));
    }
}

