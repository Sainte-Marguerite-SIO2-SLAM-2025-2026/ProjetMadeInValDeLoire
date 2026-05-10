<?php

namespace App\Controllers\salle_1;

use App\Controllers\BaseController;
use App\Models\admin\salle_1\Salle1Admin;
use CodeIgniter\HTTP\RedirectResponse;
class Salle1AdminController extends BaseController
{
    /**
     * Affiche la page d'administration avec toutes les données.
     */
    public function salle_1()
    {
        $model = new Salle1Admin();

        $data = [
            'auteurs' => $model->getAuteurs(),
            'messages' => $model->getMessages(),
            'reponses' => $model->getReponses(),
        ];

        // Statistiques simples
        $data['stats'] = [
            'auteurs' => count($data['auteurs']),
            'messages' => count($data['messages']),
            'reponses' => count($data['reponses']),
        ];

        $data['stats']['total'] = array_sum($data['stats']);

        return view('admin/salle_1', $data);
    }

    /**
     * Sauvegarde générique :
     * - auteur
     * - message
     * - reponse
     */
    public function saveGeneric()
    {
        // Vérification session admin
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $model = new Salle1Admin();

        // Données formulaire
        $id = trim((string)$this->request->getPost('id'));
        $type = trim((string)$this->request->getPost('type'));
        $content = trim((string)$this->request->getPost('content'));

        // Types autorisés
        $allowedTypes = ['auteur', 'message', 'reponse'];

        if (!in_array($type, $allowedTypes, true)) {
            return redirect()->back()
                ->with('error', 'Type invalide.');
        }

        // Validation simple
        if (empty($content)) {
            return redirect()->back()
                ->with('error', 'Le contenu ne peut pas être vide.');
        }

        /*
         * Construction des données selon le type
         */
        $dataToSave = [];

        switch ($type) {

            case 'auteur':
                $dataToSave = [
                    'nom' => $content
                ];
                break;

            case 'message':
                $dataToSave = [
                    'contenu' => $content
                ];
                break;

            case 'reponse':
                $dataToSave = [
                    'texte' => $content
                ];
                break;
        }

        // Sauvegarde via le modèle
        $ok = $model->saveElement(
            $type,
            $dataToSave,
            !empty($id) ? (int)$id : null
        );

        $redirectUrl = base_url('gingembre/salle/1') . '#section-' . $type;

        if (!$ok) {
            return redirect()->to($redirectUrl)
                ->with('error', 'Erreur lors de l\'enregistrement.');
        }

        return redirect()->to($redirectUrl)
            ->with('success', 'Enregistrement réussi.');
    }

    /**
     * Suppression d’un élément.
     */
    public function deleteElement($type, $id): RedirectResponse
    {
        // Vérification session admin
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        // Types autorisés
        $allowedTypes = ['auteur', 'message', 'reponse'];

        if (!in_array($type, $allowedTypes, true)) {
            return redirect()->back()
                ->with('error', 'Type invalide.');
        }

        $model = new Salle1Admin();

        $ok = $model->deleteElement($type, (int)$id);

        $redirectUrl = base_url('gingembre/salle/1') . '#section-' . $type;

        if (!$ok) {
            return redirect()->to($redirectUrl)
                ->with('error', 'Erreur lors de la suppression.');
        }

        return redirect()->to($redirectUrl)
            ->with('success', 'Suppression réussie.');
    }
}