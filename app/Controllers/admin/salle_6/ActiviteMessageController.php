<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\ActiviteMessageAdminModel;
use App\Models\admin\commun\ActiviteAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ActiviteMessageController extends AdminSalle6Controller
{
    protected ActiviteMessageAdminModel $messageModel;
    protected ActiviteAdminModel $activiteModel;

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

        $salleNumero = $this->request->getGet('salle') ? (int)$this->request->getGet('salle') : null;

        $data = $this->getPaginatedData(
            $this->messageModel,
            'getMessageListBuilder',
            'countMessages',
            'id',
            $salleNumero
        );

        $data['messages'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/activiteMessage/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'activites' => $this->activiteModel->findAll(),
            'type_messages' => $this->messageModel->getTypeMessageOptions()
        ];

        return view('admin/salle_6/activiteMessage/create', $data);
    }

    public function store(): RedirectResponse
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

        $data = [
            'activite_numero' => $this->request->getPost('activite_numero'),
            'type_message' => $this->request->getPost('type_message'),
            'message' => $this->request->getPost('message')
        ];

        if ($this->messageModel->createMessage($data)) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('success', 'Message créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $message = $this->messageModel->getMessageById($id);
        if (!$message) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('error', 'Message introuvable');
        }

        $data = [
            'message' => $message,
            'activites' => $this->activiteModel->findAll(),
            'type_messages' => $this->messageModel->getTypeMessageOptions()
        ];

        return view('admin/salle_6/activiteMessage/edit', $data);
    }

    public function update($id): RedirectResponse
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

        $data = [
            'activite_numero' => $this->request->getPost('activite_numero'),
            'type_message' => $this->request->getPost('type_message'),
            'message' => $this->request->getPost('message')
        ];

        if ($this->messageModel->updateMessage($id, $data)) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('success', 'Message modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->messageModel->deleteMessage($id)) {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('success', 'Message supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/activite-message')->with('error', 'Erreur lors de la suppression');
        }
    }
}