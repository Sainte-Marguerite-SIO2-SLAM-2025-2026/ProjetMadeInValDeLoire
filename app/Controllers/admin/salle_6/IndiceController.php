<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\IndiceAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class IndiceController extends AdminSalle6Controller
{
    protected IndiceAdminModel $indiceModel;

    public function __construct()
    {
        $this->indiceModel = new IndiceAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $salleNumero = $this->request->getGet('salle') ? (int)$this->request->getGet('salle') : null;

        $data = $this->getPaginatedData(
            $this->indiceModel,
            'getIndiceListBuilder',
            'countIndices',
            'numero',
            $salleNumero
        );

        $data['indices'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/indice/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        return view('admin/salle_6/indice/create');
    }

    public function Store(): RedirectResponse
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

        if ($this->indiceModel->createIndice($data)) {
            return redirect()->to('/gingembre/salle_6/indice')->with('success', 'Indice créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function Edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $indice = $this->indiceModel->getIndiceByNumero($id);
        if (!$indice) {
            return redirect()->to('/gingembre/salle_6/indice')->with('error', 'Indice introuvable');
        }

        return view('admin/salle_6/indice/edit', ['indice' => $indice]);
    }

    public function Update($id): RedirectResponse
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

        if ($this->indiceModel->updateIndice($id, $data)) {
            return redirect()->to('/gingembre/salle_6/indice')->with('success', 'Indice modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function Delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->indiceModel->deleteIndice($id)) {
            return redirect()->to('/gingembre/salle_6/indice')->with('success', 'Indice supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/indice')->with('error', 'Impossible de supprimer (utilisé dans des activités)');
        }
    }
}