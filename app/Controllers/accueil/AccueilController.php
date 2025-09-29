<?php

class AccueilController extends \App\Controllers\BaseController
{
    public function index() : string
    {
        return view('menu_principal');
    }

    public function Salle1() : string
    {
        return view('Salle1');
    }

    public function Salle2() : string
    {
        return view('Salle2');
    }

    public function Salle3() : string
    {
        return view('Salle3');
    }

    public function Salle4() : string
    {
        return view('Salle4');
    }

    public function Salle5() : string
    {
        return view('Salle5');
    }

    public function Salle6() : string
    {
        return view('Salle6');
    }
}