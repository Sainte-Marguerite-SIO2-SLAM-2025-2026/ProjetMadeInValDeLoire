<?php

namespace App\Controllers\salle_1;

use App\Controllers\BaseController;
use App\Models\salle_1\Salle1Message;

class Salle1Controller extends BaseController
{
    public function accesMessage() : string
    {
        $messageModel = new Salle1Message();
        $messageData = $messageModel->getMessageSalle1();
        $message = 'Bonjour, je suis Jean-Michel Dupuis du service informatique centrale. Nous avons detecté une intrusion urgente dans votre compte. Pour éviter une coupure immediate, merci de m’envoyer votre mot-de-passe personnel ainsi que votre identifiant bancaire pour vérification. Vous devez répondre dans les 5 minutes sinon votre accès entreprise sera definitivement suprimé.';
        $mots_suspects = [
            "urgente",
            "immediate,",
            "mot-de-passe",
            "bancaire",
            "definitivement"
        ];

        $data = [
            'nom_personnage' => 'Jean-Michel',
            'mots_suspects' => $mots_suspects,
            'message' => $message,
        ];

        return view('salle_1\DiscussionSalle1', $data)
            . view('commun\footer');
    }

    public function accesCode() : string
    {
        return view('salle_1\CodeSalle1').
            view('commun\footer');
    }
}