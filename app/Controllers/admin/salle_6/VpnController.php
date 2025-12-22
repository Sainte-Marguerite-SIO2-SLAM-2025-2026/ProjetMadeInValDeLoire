<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\salle_6\VpnAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class VpnController extends AdminSalle6Controller
{
    protected VpnAdminModel $vpnModel;

    public function __construct()
    {
        $this->vpnModel = new VpnAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->vpnModel,
            'getVpnListBuilder',
            'countVpns',
            'numero'
        );

        $data['vpns'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/vpn/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        return view('admin/salle_6/vpn/create');
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = ['libelle' => $this->request->getPost('libelle')];

        if ($this->vpnModel->createVpn($data)) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('success', 'VPN créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du VPN');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $vpn = $this->vpnModel->getVpnByNumero($id);
        if (!$vpn) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('error', 'VPN introuvable');
        }

        return view('admin/salle_6/vpn/edit', ['vpn' => $vpn]);
    }

    public function update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = ['libelle' => $this->request->getPost('libelle')];

        if ($this->vpnModel->updateVpn($id, $data)) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('success', 'VPN modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->vpnModel->deleteVpn($id)) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('success', 'VPN supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/vpn')->with('error', 'Impossible de supprimer ce VPN (utilisé dans des propositions)');
        }
    }
}