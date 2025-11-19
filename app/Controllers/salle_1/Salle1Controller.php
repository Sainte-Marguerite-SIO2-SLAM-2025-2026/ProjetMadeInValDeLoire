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

        // Vérifie si un message a été trouvé
        if (!$messageData) {
            // Message par défaut si aucune donnée en BDD
            $data = [
                'nom_personnage' => 'Jean-Michel',
                'mots_suspects' => ['urgente', 'immediate', 'mot-de-passe', 'bancaire', 'definitivement'],
                'message' => 'Bonjour, je suis Jean-Michel Dupuis du service informatique centrale. Nous avons detecté une intrusion urgente dans votre compte. Pour éviter une coupure immediate merci de m\'envoyer votre mot-de-passe personnel ainsi que votre identifiant bancaire pour vérification. Vous devez répondre dans les 5 minutes sinon votre accès entreprise sera definitivement suprimé.',
                'indices' => [],
                'erreurs_explications' => [],
                'image_perso' => 'salle_1/images/personnages/monstre1.webp'
            ];
        } else {
            // Récupère les mots suspects depuis la table erreur
            $motsSuspects = $messageModel->getMotsSuspects($messageData->numero);

            // Récupère les erreurs avec explications
            $erreursExplications = $messageModel->getErreursAvecExplications($messageData->numero);

            // Récupère les indices
            $indices = $messageModel->getIndices($messageData->numero);

            // Prépare le nom du personnage
            $nomPersonnage = !empty($messageData->prenom)
                ? $messageData->prenom . ' ' . ($messageData->nom ?? '')
                : 'Personnage';

            $data = [
                'activite_numero' => $messageData->numero,
                'nom_personnage' => trim($nomPersonnage),
                'fonction_role' => $messageData->fonction_role ?? '',
                'mots_suspects' => $motsSuspects,
                'message' => $messageData->libelle,
                'indices' => $indices,
                'erreurs_explications' => $erreursExplications,
                'image_perso' => !empty($messageData->image)
                    ? 'salle_1/images/personnages/' . $messageData->image
                    : 'salle_1/images/personnages/monstre1.webp'
            ];
        }

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