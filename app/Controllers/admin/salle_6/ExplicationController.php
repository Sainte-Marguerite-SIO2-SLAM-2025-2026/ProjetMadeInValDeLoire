<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\ExplicationAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ExplicationController extends AdminSalle6Controller
{
    protected ExplicationAdminModel $explicationModel;

    public function __construct()
    {
        $this->explicationModel = new ExplicationAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $salleNumero = $this->request->getGet('salle') ? (int)$this->request->getGet('salle') : null;

        $data = $this->getPaginatedData(
            $this->explicationModel,
            'getExplicationListBuilder',
            'countExplications',
            'numero',
            $salleNumero
        );

        $data['explications'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/explication/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        return view('admin/salle_6/explication/create');
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]',
            'numero' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->request->getPost('numero')) {
            $data['numero'] = $this->request->getPost('numero');
        }

        if ($this->explicationModel->createExplication($data)) {
            return redirect()->to('/gingembre/salle_6/explication')->with('success', 'Explication créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $explication = $this->explicationModel->getExplicationByNumero($id);
        if (!$explication) {
            return redirect()->to('/gingembre/salle_6/explication')->with('error', 'Explication introuvable');
        }

        return view('admin/salle_6/explication/edit', ['explication' => $explication]);
    }

    public function update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->explicationModel->updateExplication($id, $data)) {
            return redirect()->to('/gingembre/salle_6/explication')->with('success', 'Explication modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->explicationModel->deleteExplication($id)) {
            return redirect()->to('/gingembre/salle_6/explication')->with('success', 'Explication supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/explication')->with('error', 'Impossible de supprimer (utilisée dans des activités)');
        }
    }
}