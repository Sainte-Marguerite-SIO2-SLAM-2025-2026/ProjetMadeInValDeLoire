<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Etape extends BaseController
{

    public function etape1()
    {
        return view('Etape1_S3_View', [
            'title' => 'Etape 1 — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function etape1a()
    {
        return view('Etape1a_S3_View', [
            'title' => 'Etape 1 — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function etape2()
    {
        return view('Etape2_S3_View', [
            'title' => 'Etape 2 — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function etape2a()
    {
        return view('Etape2a_S3_View', [
            'title' => 'Etape 2 — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error'),
        ]);
    }


    public function etape3()
    {
        return view('Etape3_S3_View', [
            'title' => 'Etape 3 — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function etape4()
    {
        return view('Etape4_S3_View', [
            'title' => 'Etape 4 — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function etape5()
    {
        return view('Etape5_S3_View', [
            'title' => 'Etape 5 — Salle N°3',
            'message' => session()->getFlashdata('message'),
            'error' => session()->getFlashdata('error'),
        ]);
    }
}






