<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\admin\UserModel;

class AdminController extends BaseController
{
    public function index() : string
    {
        return view('commun/header') .
            view('admin/Connexion');
    }

    public function login()
    {

        $userModel = new UserModel();

        $username = esc($this->request->getPost('user'));
        $password = esc($this->request->getPost('mdp'));

        // Chercher l’utilisateur
        $user = $userModel->getUser($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur inconnu');
        }

        // Vérification mot de passe
        //if (encrypt_aes256_cbc($password) !== $user['mdp']) {
        if ($password !== $user['mdp']) {
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        }

        // Connexion OK → enregistrer en session
        session()->set([
            'admin_id' => $user['numero'],
            'admin_user' => $user['login'],
        ]);

        return redirect()->to('/gingembre/accueil');
    }

    public function checkConnexion()
    {

    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/gingembre');
    }

    public function accueil() {
        return view('admin/adminAccueil');
    }

    public function createUser() {
        // Création d'utilisateur avec le model
    }

    public function salle($numero) : string
    {
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

    public function quiz() : string
    {
        return view('admin/quiz/AccueilAdminquiz');
    }

    public function mascotte() : string
    {
        return view('admin/mascotte/AccueilAdminmascotte');
    }

}