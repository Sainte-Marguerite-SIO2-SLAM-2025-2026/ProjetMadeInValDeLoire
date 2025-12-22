<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\AvoirIndiceAdminModel;
use App\Models\admin\commun\ActiviteAdminModel;
use App\Models\admin\commun\IndiceAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class AvoirIndiceController extends AdminSalle6Controller
{
    protected AvoirIndiceAdminModel $avoirIndiceModel;
    protected ActiviteAdminModel $activiteModel;
    protected IndiceAdminModel $indiceModel;

    public function __construct()
    {
        $this->avoirIndiceModel = new AvoirIndiceAdminModel();
        $this->activiteModel = new ActiviteAdminModel();
        $this->indiceModel = new IndiceAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $salleNumero = $this->request->getGet('salle') ? (int)$this->request->getGet('salle') : null;

        $data = $this->getPaginatedData(
            $this->avoirIndiceModel,
            'getAvoirIndiceListBuilder',
            'countAvoirIndices',
            'activite_numero',
            $salleNumero
        );

        $data['associations'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/avoirIndice/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'activites' => $this->activiteModel->findAll(),
            'indices' => $this->indiceModel->findAll()
        ];

        return view('admin/salle_6/avoirIndice/create', $data);
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'activite_numero' => 'required|integer',
            'indice_numero' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'activite_numero' => $this->request->getPost('activite_numero'),
            'indice_numero' => $this->request->getPost('indice_numero')
        ];

        if ($this->avoirIndiceModel->createAvoirIndice($data)) {
            return redirect()->to('/gingembre/salle_6/avoir-indice')->with('success', 'Association créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création (l\'association existe peut-être déjà)');
        }
    }

    public function delete($activiteNumero, $indiceNumero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->avoirIndiceModel->deleteAvoirIndice($activiteNumero, $indiceNumero)) {
            return redirect()->to('/gingembre/salle_6/avoir-indice')->with('success', 'Association supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/avoir-indice')->with('error', 'Erreur lors de la suppression');
        }
    }
}