<?php

namespace App\Controllers;

class Accueil extends BaseController
{
    // Change cette constante pour pointer vers ta vraie route de la suite du jeu
    private const NEXT_ROUTE = 'porte'; // ex: 'porte' ou 'jeu/etape1'

    public function index()
    {
        return view('Accueil_view', [
            'title'   => 'Accueil — Porte',
            'message' => session()->getFlashdata('message'),
            'error'   => session()->getFlashdata('error'),
        ]);
    }

}