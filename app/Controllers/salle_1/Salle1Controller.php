<?php

namespace App\Controllers\salle_1;

use App\Controllers\BaseController;

class Salle1Controller extends BaseController
{
    public function accesMessage() : string
    {
        //$message = "Salut, j’ai reçu un email bizarre d’une banque inconnue qui me demande de cliquer sur un lien pour vérifier mon compte";
        $message = "Salut, j’ai reçu un email étrange d’un service inconnu me demandant mes identifiants. On me propose un remboursement si je clique rapidement sur un lien, mais l’adresse web semble bizarre. Je préfère vérifier auprès de la banque avant de donner mon mot de passe ou mes informations personnelles";
        $mots_suspects = [
            "email",
            "inconnu",
            "identifiants",
            "remboursement",
            "clique",
            "lien",
            "adresse web",
            "mot de passe",
            "informations personnelles",
            "banque"
        ];

        //$mots_suspects = ['email','bizarre','banque','lien','compte'];

        $data = [
            'nom_personnage' => 'Olivier',
            'mots_suspects' => $mots_suspects,
            'message' => $message,
        ];

        return view('salle_1\DiscussionSalle1', $data)
            . view('commun\PiedDePage');
    }

    public function accesCode() : string
    {
        return view('salle_1\CodeSalle1').
            view('commun\PiedDePage');
    }
}