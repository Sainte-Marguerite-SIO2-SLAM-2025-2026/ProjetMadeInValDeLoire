<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\salle_6\WifiAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class WifiController extends AdminSalle6Controller
{
    protected WifiAdminModel $wifiModel;

    public function __construct()
    {
        $this->wifiModel = new WifiAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->wifiModel,
            'getWifiListBuilder',
            'countWifis',
            'numero'
        );

        $data['wifis'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/wifi/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'chiffrement_types' => $this->wifiModel->getChiffrementTypes()
        ];

        return view('admin/salle_6/wifi/create', $data);
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[1]|max_length[255]',
            'public' => 'required|in_list[0,1]',
            'chiffrement' => 'required|in_list[OPEN,WEP,WPA,WPA2,WPA3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'public' => $this->request->getPost('public'),
            'chiffrement' => $this->request->getPost('chiffrement')
        ];

        if ($this->wifiModel->createWifi($data)) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('success', 'WiFi créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du WiFi');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $wifi = $this->wifiModel->getWifiByNumero($id);
        if (!$wifi) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('error', 'WiFi introuvable');
        }

        $data = [
            'wifi' => $wifi,
            'chiffrement_types' => $this->wifiModel->getChiffrementTypes()
        ];

        return view('admin/salle_6/wifi/edit', $data);
    }

    public function update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[1]|max_length[255]',
            'public' => 'required|in_list[0,1]',
            'chiffrement' => 'required|in_list[OPEN,WEP,WPA,WPA2,WPA3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'public' => $this->request->getPost('public'),
            'chiffrement' => $this->request->getPost('chiffrement')
        ];

        if ($this->wifiModel->updateWifi($id, $data)) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('success', 'WiFi modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->wifiModel->deleteWifi($id)) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('success', 'WiFi supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/wifi')->with('error', 'Impossible de supprimer ce WiFi (utilisé dans des propositions)');
        }
    }
}
