<?php

namespace salle_1;

use App\Controllers\BaseController;

class Salle1Controller extends BaseController
{
    public function AccesMessage() : string
    {
        $data['message'] = [
                'personne' => 'Mario',
                'fonction' => 'Détective',
                'texte' => "Bonjour, je suis le détective Mario. Je crois qu’il y a un mensonge ici.",
                'mots_suspects' => ['mensonge']
        ];

        return view('salle_1\DiscussionSalle1', $data).
            view('commun\PiedDePage');
    }
}