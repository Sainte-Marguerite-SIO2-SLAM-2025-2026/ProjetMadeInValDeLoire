<?php
namespace App\Controllers\accueil;

use App\Controllers\BaseController;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ExplicationModel;
use App\Models\salle_5\MascotteModel;
use App\Models\salle_5\SalleModel;

class AccueilController extends BaseController
{
    public function index() : string
    {
        return view('accueil\Accueil').
            view('commun\footer');
    }

    public function Salle1() : string
    {
        return view('salle_1\AccueilSalle1').
            view('commun\footer');
    }

    public function Salle2() : string
    {
        return view('salle_2\AccueilSalle2').
            view('commun\footer');
    }

    public function Salle3() : string
    {
        return view('salle_3\AccueilSalle3').
            view('commun\footer');
    }

    public function Salle4() : string
    {
        return view('salle_4\AccueilSalle4').
            view('commun\footer');
    }

    public function Salle5() : string
    {
        // Instancier les models
        $salleModel = new SalleModel();
        $mascotteModel = new MascotteModel();
        $explicationModel = new ExplicationModel();
        $activiteModel = new ActiviteModel();

        // Initialiser les activités en session si nécessaire
        if (!session()->has('activites_salle5')) {
            $activites = $activiteModel->getActivitesAleatoires(5, 2);

            if (count($activites) >= 2) {
                $activites_ids = array_column($activites, 'numero');
                session()->set('activites_salle5', $activites_ids);
                session()->set('activites_reussies', []);
                // 🆕 Réinitialiser l'état de la popup lors d'une nouvelle partie
                session()->remove('popup_salle5_vue');
            }
        }

        // Vérifier si toutes les énigmes sont terminées
        $activites_ids = session()->get('activites_salle5') ?? [];
        $activites_reussies = session()->get('activites_reussies') ?? [];

        $afficher_popup_succes = false;
        if (count($activites_reussies) === 2 && count($activites_ids) === 2) {
            $afficher_popup_succes = true;
            // NE PAS réinitialiser ici, on le fera après validation du popup
        }

        // 🆕 Vérifier si la popup a déjà été vue
        $afficher_popup = !session()->has('popup_salle5_vue');

        // 🆕 Marquer la popup comme vue
        if ($afficher_popup) {
            session()->set('popup_salle5_vue', true);
        }

        // Récupérer les données via les models
        $data = [
            'salle' => $salleModel->getSalle(5),
            'mascotte' => $mascotteModel->getMascotteBySalle(5),
            'explication' => $explicationModel->getExplication(1),
            'activites_selectionnees' => $activites_ids,
            'activites_reussies' => $activites_reussies,
            'afficher_popup' => $afficher_popup, // 🆕 Passer l'info à la vue
            'afficher_popup_succes' => $afficher_popup_succes

        ];

        return view('commun\header').
            view('salle_5\AccueilSalle5', $data).
            view('commun\footer');
    }

    public function Salle6() : string
    {
        return view('commun\header').
            view('salle_6\AccueilSalle6').
            view('commun\footer');
    }

}