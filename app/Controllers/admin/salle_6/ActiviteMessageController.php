<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\ActiviteMessageAdminModel;
use App\Models\admin\commun\ActiviteAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ActiviteMessageController extends AdminSalle6Controller
{
    protected ActiviteMessageAdminModel $messageModel;
    protected ActiviteAdminModel $activiteModel;
    protected const SALLE_NUMERO = 6;

    public function __construct()
    {
        $this->messageModel = new ActiviteMessageAdminModel();
        $this->activiteModel = new ActiviteAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

// Force la salle 6
        $data = $this->getPaginatedData(
                $this->messageModel,
                'getMessageListBuilder',
                'countMessages',
                'id',
                self::SALLE_NUMERO
        );

        $data['messages'] = $data['results'];
        unset($data['results']);
        $data['current_salle'] = self::SALLE_NUMERO;

        return view('admin/salle_6/activiteMessage/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

// Récupérer uniquement les activités de la salle 6 (600-699)
        $activites = $this->activiteModel->getActivitesBySalle(self::SALLE_NUMERO);

        $data = [
                'activites' => $activites,
                'type_messages' => $this->messageModel->getTypeMessageOptions(),
                'current_salle' => self::SALLE_NUMERO
        ];

        return view('admin/salle_6/activiteMessage/create', $data);
    }

    public function Store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
                'activite_numero' => 'required|integer',
                'type_message' => 'required|in_list[succes,echec]',
                'message' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $activiteNumero = $this->request->getPost('activite_numero');

// Vérifier que l'activité appartient à la salle 6
        if ($activiteNumero < 600 || $activiteNumero > 699) {
            return redirect()->back()->withInput()->with('error', 'Activité non accessible pour la salle 6');
        }

        $data = [
                'activite_numero' => $activiteNumero,
                'type_message' => $this->request->getPost('type_message'),
                'message' => $this->request->getPost('message')
        ];

        if ($this->messageModel->createMessage($data)) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('success', 'Message créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function Edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $message = $this->messageModel->getMessageById($id);
        if (!$message) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('error', 'Message introuvable');
        }

// Vérifier que l'activité associée appartient à la salle 6
        if ($message['activite_numero'] < 600 || $message['activite_numero'] > 699) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('error', 'Message non accessible');
        }

        $activites = $this->activiteModel->getActivitesBySalle(self::SALLE_NUMERO);

        $data = [
                'message' => $message,
                'activites' => $activites,
                'type_messages' => $this->messageModel->getTypeMessageOptions(),
                'current_salle' => self::SALLE_NUMERO
        ];

        return view('admin/salle_6/activiteMessage/edit', $data);
    }

    public function Update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
                'activite_numero' => 'required|integer',
                'type_message' => 'required|in_list[succes,echec]',
                'message' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $activiteNumero = $this->request->getPost('activite_numero');

// Vérifier que l'activité appartient à la salle 6
        if ($activiteNumero < 600 || $activiteNumero > 699) {
            return redirect()->back()->withInput()->with('error', 'Activité non accessible pour la salle 6');
        }

        $data = [
                'activite_numero' => $activiteNumero,
                'type_message' => $this->request->getPost('type_message'),
                'message' => $this->request->getPost('message')
        ];

        if ($this->messageModel->updateMessage($id, $data)) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('success', 'Message modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function Delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

// Vérifier que le message appartient à une activité de la salle 6
        $message = $this->messageModel->getMessageById($id);
        if ($message && ($message['activite_numero'] < 600 || $message['activite_numero'] > 699)) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('error', 'Message non accessible');
        }

        if ($this->messageModel->deleteMessage($id)) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('success', 'Message supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('error', 'Erreur lors de la suppression');
        }
    }
}