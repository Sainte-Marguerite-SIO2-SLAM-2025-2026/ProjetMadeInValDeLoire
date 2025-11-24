<?php

namespace App\Controllers\salle_1;

use App\Controllers\BaseController;
use App\Models\salle_1\Salle1Message;

class Salle1Controller extends BaseController
{
    public function accesMessage(): string
    {
        $messageModel = new Salle1Message();

        // Récupère un message aléatoire de la base de données
        $messageData = $messageModel->getMessageSalle1();

        // Récupère les mots suspects depuis la table erreur
        $motsSuspects = $messageModel->getMotsSuspects($messageData->numero);

        // Récupère les erreurs avec explications
        $erreursExplications = $messageModel->getErreursAvecExplications($messageData->numero);

        // Récupère les indices
        $indices = $messageModel->getIndices($messageData->numero);

        // Prépare le nom du personnage
        $nomPersonnage = $messageData->prenom . ' ' . $messageData->nom;

        $data = [
            'activite_numero' => $messageData->numero,
            'nom_personnage' => $nomPersonnage,
            'mots_suspects' => $motsSuspects,
            'message' => $messageData->libelle,
            'indices' => $indices,
            'erreurs_explications' => $erreursExplications,
            ];

        return view('salle_1/DiscussionSalle1', $data)
            . view('commun/footer');
    }

    public function accesCode(): string
    {
        return view('salle_1/CodeSalle1')
            . view('commun/footer');
    }

    /**
     * API pour récupérer l'explication d'un mot suspect
     */
    public function getExplicationMot()
    {
        $messageModel = new Salle1Message();

        $activiteNumero = $this->request->getPost('activite_numero');
        $mot = $this->request->getPost('mot');

        if (!$activiteNumero || !$mot) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Paramètres manquants'
            ]);
        }

        // Récupère toutes les erreurs pour cette activité
        $erreurs = $messageModel->getErreursAvecExplications($activiteNumero);

        // Cherche l'explication du mot
        $explication = '';
        foreach ($erreurs as $erreur) {
            if (trim($erreur['mot_incorrect']) === trim($mot)) {
                $explication = $erreur['explication'];
                break;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'explication' => $explication
        ]);
    }
}