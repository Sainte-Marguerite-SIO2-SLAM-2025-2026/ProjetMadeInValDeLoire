<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\admin\salle_2\Salle2Admin;
use App\Models\admin\UserModel;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ObjetDeclencheurModel;
use App\Models\salle_5\ObjetsModel;
use CodeIgniter\HTTP\RedirectResponse;
use App\Controllers\admin\salle_6\AdminSalle6Controller;

class AdminController extends BaseController
{
    public function index() : string
    {
        return view('commun/header') .
            view('admin/Connexion');
    }

    public function login() : string|RedirectResponse
    {
        $userModel = new UserModel();

        $username = esc($this->request->getPost('user'));
        $password = esc($this->request->getPost('mdp')); // Garder le mot de passe en clair

        // Chercher l'utilisateur
        $user = $userModel->getUser($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur inconnu');
        }

        // Vérification mot de passe - INVERSER la logique
        if (!password_verify($password, $user['mdp'])) {
            return redirect()->back()->with('error','Mot de passe incorrect');
        }

        // Connexion OK → enregistrer en session
        session()->set([
            'admin_id' => $user['numero'],
            'admin_user' => $user['login'],
        ]);

        return redirect()->to('/gingembre/accueil');
    }

    public function logout() : RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/gingembre');
    }

    public function accueil() : string|RedirectResponse
    {
        // Test si l'utilisateur est connecté
        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }
        return view('admin/adminAccueil');
    }

    public function createUser() {
        // Création d'utilisateur avec le model
    }

    public function salle($numero) : string|RedirectResponse
    {
        $salle6Controller = new AdminSalle6Controller();
        // Test si l'utilisateur est connecté
        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }

        if ($numero == 1) {
            return view('admin/salle_1/AccueilAdminSalle1');
        }
        elseif ($numero == 2) {
            $model = new Salle2Admin();
            $data = [
                'explications' => $model->getExplications(),
                'indices'      => $model->getIndices(),
                'mdps'         => $model->getMdps()
            ];

            return view('admin/salle_2/AccueilAdminSalle2', $data);
        }
        elseif ($numero == 3) {
            return view('admin/salle_3/AccueilAdminSalle3');
        }
        elseif ($numero == 4) {
            return view('admin/salle_4/AccueilAdminSalle4');
        }
        elseif ($numero == 5) {
            $enigmeModel = new ActiviteModel();
            $objets = new ObjetsModel();
            $objetsDeclencheurs = new ObjetDeclencheurModel();
            $data = [
                'enigme' => $enigmeModel->getActivites(5),
                'objets' => $objets->getObjets(),
                'objetsDeclencheurs' => $objetsDeclencheurs->getObjetsDeclencheurs()
            ];
            return view('admin/salle_5/AccueilAdminSalle5', $data);
        }
        elseif ($numero == 6) {
            return $salle6Controller->Index();
        }
        else {
            return view('admin/accueil');
        }
    }

    public function quiz() : string|RedirectResponse
    {
        // Test si l'utilisateur est connecté
        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }
        return view('admin/quiz/AccueilAdminquiz');
    }

    public function mascotte() : string|RedirectResponse
    {
        // Test si l'utilisateur est connecté
        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }
        return view('admin/mascotte/AccueilAdminmascotte');
    }
}