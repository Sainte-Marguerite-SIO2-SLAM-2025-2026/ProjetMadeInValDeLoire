<?php

namespace App\Controllers;

class Introduction extends BaseController
{
    public function index()
    {
        return view('Introduction_view', [
            'title'   => 'Introduction — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error'   => session()->getFlashdata('error'),
        ]);
    }

    public function aide()
    {
        return view('Aide_view', [
            'title'   => 'Aide — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error'   => session()->getFlashdata('error'),
        ]);
    }

}