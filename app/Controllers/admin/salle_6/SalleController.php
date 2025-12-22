<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\SalleAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class SalleController extends AdminSalle6Controller
{
    protected SalleAdminModel $salleModel;

    public function __construct()
    {
        $this->salleModel = new SalleAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // SalleModel n'a pas de paramètre salleNumero car c'est la table principale
        $data = $this->getPaginatedData(
            $this->salleModel,
            'getSalleListBuilder',
            'countSalles',
            'numero',
            null
        );

        $data['salles'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/salle/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        return view('admin/salle_6/salle/create');
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]',
            'bouton' => 'required|max_length[50]',
            'intro_salle' => 'permit_empty',
            'numero' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'bouton' => $this->request->getPost('bouton'),
            'intro_salle' => $this->request->getPost('intro_salle') ?? ''
        ];

        if ($this->request->getPost('numero')) {
            $data['numero'] = $this->request->getPost('numero');
        }

        if ($this->salleModel->createSalle($data)) {
            return redirect()->to('/gingembre/salle_6/salle')->with('success', 'Salle créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $salle = $this->salleModel->getSalleByNumero($id);
        if (!$salle) {
            return redirect()->to('/gingembre/salle_6/salle')->with('error', 'Salle introuvable');
        }

        return view('admin/salle_6/salle/edit', ['salle' => $salle]);
    }

    public function update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]',
            'bouton' => 'required|max_length[50]',
            'intro_salle' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'bouton' => $this->request->getPost('bouton'),
            'intro_salle' => $this->request->getPost('intro_salle') ?? ''
        ];

        if ($this->salleModel->updateSalle($id, $data)) {
            return redirect()->to('/gingembre/salle_6/salle')->with('success', 'Salle modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->salleModel->deleteSalle($id)) {
            return redirect()->to('/gingembre/salle_6/salle')->with('success', 'Salle supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/salle')->with('error', 'Impossible de supprimer (utilisée dans d\'autres tables)');
        }
    }
}