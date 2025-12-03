<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\admin\UserModel;

class AdminController extends BaseController
{
    public function index()
    {
        return view('commun/header') .
            view('admin/Connexion');
    }

    public function login()
    {

        $userModel = new UserModel();

        $username = $this->request->getPost('user');
        $password = $this->request->getPost('mdp');

        // Chercher l’utilisateur
        $user = $userModel->getUser($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur inconnu');
        }

        // Vérification mot de passe
        if ($password !== $user['mdp']) {
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        }

        // Connexion OK → enregistrer en session
        session()->set([
            'admin_id' => $user['id'],
            'admin_user' => $user['user'],
            'is_admin' => true,
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}