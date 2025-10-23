<?php
namespace App\Controllers\accueil;

use App\Controllers\BaseController;

class AccueilController extends BaseController
{
    public function index() : string
    {
        return view('accueil\Accueil').
            view('commun\PiedDePage');
    }

    public function Salle1() : string
    {
        $data = [
            'auteur'  => 'Mario Rossi',
            'fonction' => 'Ingénieur Social',
            'message' => [
                'Bonjour, je suis ravi de te rencontrer dans cette salle d\'initiation.',
                'Peux-tu repérer les mots suspects dans cette phrase ?',
                'Clique sur les mots étranges ou douteux pour les marquer.'
            ],
            // liste des mots suspects pour les barrer après clic
            'suspects' => ['suspects', 'étranges', 'douteux']
        ];

        return view('salle_1\AccueilSalle1', $data).
            view('commun\PiedDePage');
    }

    public function Salle2() : string
    {
        return view('salle_2\AccueilSalle2').
            view('commun\PiedDePage');
    }

    public function Salle3() : string
    {
        return view('salle_3\AccueilSalle3').
            view('commun\PiedDePage');
    }

    public function Salle4() : string
    {
        return view('salle_4\AccueilSalle4').
            view('commun\PiedDePage');
    }

    public function Salle5() : string
    {
        return view('salle_5\AccueilSalle5').
            view('commun\PiedDePage');
    }

    public function Salle6() : string
    {
        return view('salle_6\AccueilSalle6').
            view('commun\PiedDePage');
    }
}