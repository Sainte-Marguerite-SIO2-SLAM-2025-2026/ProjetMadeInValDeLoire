<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\salle_6\ProposerWifiAdminModel;
use App\Models\admin\salle_6\WifiAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ProposerWifiController extends AdminSalle6Controller
{
    protected ProposerWifiAdminModel $proposerWifiModel;
    protected WifiAdminModel $wifiModel;

    public function __construct()
    {
        $this->proposerWifiModel = new ProposerWifiAdminModel();
        $this->wifiModel = new WifiAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->proposerWifiModel,
            'getPropositionsListBuilder',
            'countPropositions',
            'wifi_numero'
        );

        $data['propositions'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/proposerWifi/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'wifis' => $this->wifiModel->getAllWifis()
        ];
        return view('admin/salle_6/proposerWifi/create', $data);
    }

    public function Store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'wifi_numero' => 'required|integer',
            'activite_numero' => 'required|integer',
            'bonne_reponse' => 'required|in_list[0,1]',
            'zone_clique' => 'required|min_length[1]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'wifi_numero' => $this->request->getPost('wifi_numero'),
            'activite_numero' => $this->request->getPost('activite_numero'),
            'bonne_reponse' => $this->request->getPost('bonne_reponse'),
            'zone_clique' => $this->request->getPost('zone_clique')
        ];

        if ($this->proposerWifiModel->createProposition($data)) {
            return redirect()->to('/gingembre/salle_6/proposer-wifi')->with('success', 'Proposition WiFi créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création (la proposition existe peut-être déjà)');
        }
    }

    public function Edit($wifi_numero, $activite_numero): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $proposition = $this->proposerWifiModel->getProposition($wifi_numero, $activite_numero);

        if (!$proposition) {
            return redirect()->to('/gingembre/salle_6/proposer-wifi')->with('error', 'Proposition introuvable');
        }

        $data = [
            'proposition' => $proposition,
            'wifis' => $this->wifiModel->getAllWifis()
        ];
        return view('admin/salle_6/proposerWifi/edit', $data);
    }

    public function Update($wifi_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'bonne_reponse' => 'required|in_list[0,1]',
            'zone_clique' => 'required|min_length[1]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'bonne_reponse' => $this->request->getPost('bonne_reponse'),
            'zone_clique' => $this->request->getPost('zone_clique')
        ];

        if ($this->proposerWifiModel->updateProposition($wifi_numero, $activite_numero, $data)) {
            return redirect()->to('/gingembre/salle_6/proposer-wifi')->with('success', 'Proposition modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function Delete($wifi_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->proposerWifiModel->deleteProposition($wifi_numero, $activite_numero)) {
            return redirect()->to('/gingembre/salle_6/proposer-wifi')->with('success', 'Proposition supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/proposer-wifi')->with('error', 'Erreur lors de la suppression');
        }
    }
}