<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\admin\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

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
        $password = password_hash(esc($this->request->getPost('mdp')),PASSWORD_BCRYPT);
        //$password = esc($this->request->getPost('mdp'));


        // Chercher l’utilisateur
        $user = $userModel->getUser($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur inconnu');
        }

        // Vérification mot de passe
        if (password_verify($password,$user['mdp'])) {
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
        // Test si l'utilisateur est connecté
        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }

        if ($numero == 1) {
            return view('admin/salle_1/AccueilAdminSalle1');
        }
        elseif ($numero == 2) {
            return view('admin/salle_2/AccueilAdminSalle2');
        }
        elseif ($numero == 3) {
            return view('admin/salle_3/AccueilAdminSalle3');
        }
        elseif ($numero == 4) {
            return view('admin/salle_4/AccueilAdminSalle4');
        }
        elseif ($numero == 5) {
            return view('admin/salle_5/AccueilAdminSalle5');
        }
        elseif ($numero == 6) {
            return view('admin/salle_6/AccueilAdminSalle6');
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