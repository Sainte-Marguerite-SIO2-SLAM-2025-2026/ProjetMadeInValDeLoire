<?php

namespace App\Controllers\salle_5;

use App\Controllers\BaseController;

class Salle5Controller extends BaseController
{
    public function index(){
        $data['enigme'] = [
            "image" => "/images/salle_5//bureau.png",
            "nom" => "cle etranges",
            "image_cle" => "/images/salle_5/cle.png",
            "instruction" => "Clique sur la clé que tu ne dois surtout pas brancher."
        ];
        $data['mascotte'] = [
            "image" => "/images/salle_5//mascot.webp"];

        return view('commun\header').
            view('salle_5\Enigme', $data).
            view('commun\footer');}
}