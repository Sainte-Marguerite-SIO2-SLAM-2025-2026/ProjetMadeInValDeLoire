<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\TypeAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class TypeController extends AdminSalle6Controller
{
    protected TypeAdminModel $typeModel;

    public function __construct()
    {
        $this->typeModel = new TypeAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $salleNumero = $this->request->getGet('salle') ? (int)$this->request->getGet('salle') : null;

        $data = $this->getPaginatedData(
            $this->typeModel,
            'getTypeListBuilder',
            'countTypes',
            'numero',
            $salleNumero
        );

        $data['types'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/type/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        return view('admin/salle_6/type/create');
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[30]',
            'explication' => 'required',
            'numero' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'explication' => $this->request->getPost('explication')
        ];

        if ($this->request->getPost('numero')) {
            $data['numero'] = $this->request->getPost('numero');
        }

        if ($this->typeModel->createType($data)) {
            return redirect()->to('/gingembre/salle_6/type')->with('success', 'Type créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $type = $this->typeModel->getTypeByNumero($id);
        if (!$type) {
            return redirect()->to('/gingembre/salle_6/type')->with('error', 'Type introuvable');
        }

        return view('admin/salle_6/type/edit', ['type' => $type]);
    }

    public function update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[30]',
            'explication' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'explication' => $this->request->getPost('explication')
        ];

        if ($this->typeModel->updateType($id, $data)) {
            return redirect()->to('/gingembre/salle_6/type')->with('success', 'Type modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->typeModel->deleteType($id)) {
            return redirect()->to('/gingembre/salle_6/type')->with('success', 'Type supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/type')->with('error', 'Impossible de supprimer (utilisé dans des activités)');
        }
    }
}