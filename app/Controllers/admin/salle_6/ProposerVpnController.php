<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\salle_6\ProposerVpnAdminModel;
use App\Models\admin\salle_6\VpnAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ProposerVpnController extends AdminSalle6Controller
{
    protected ProposerVpnAdminModel $proposerVpnModel;
    protected VpnAdminModel $vpnModel;

    public function __construct()
    {
        $this->proposerVpnModel = new ProposerVpnAdminModel();
        $this->vpnModel = new VpnAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->proposerVpnModel,
            'getPropositionsListBuilder',
            'countPropositions',
            'vpn_numero'
        );

        $data['propositions'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/proposerVpn/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'vpns' => $this->vpnModel->getAllVpns()
        ];
        return view('admin/salle_6/proposerVpn/create', $data);
    }

    public function Store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'vpn_numero' => 'required|integer',
            'activite_numero' => 'required|integer',
            'bonne_reponse' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'vpn_numero' => $this->request->getPost('vpn_numero'),
            'activite_numero' => $this->request->getPost('activite_numero'),
            'bonne_reponse' => $this->request->getPost('bonne_reponse')
        ];

        if ($this->proposerVpnModel->createProposition($data)) {
            return redirect()->to('/gingembre/salle_6/proposer-vpn')->with('success', 'Proposition VPN créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création (la proposition existe peut-être déjà)');
        }
    }

    public function Edit($vpn_numero, $activite_numero): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $proposition = $this->proposerVpnModel->getProposition($vpn_numero, $activite_numero);

        if (!$proposition) {
            return redirect()->to('/gingembre/salle_6/proposer-vpn')->with('error', 'Proposition introuvable');
        }

        $data = [
            'proposition' => $proposition,
            'vpns' => $this->vpnModel->getAllVpns()
        ];
        return view('admin/salle_6/proposerVpn/edit', $data);
    }

    public function Update($vpn_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'bonne_reponse' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'bonne_reponse' => $this->request->getPost('bonne_reponse')
        ];

        if ($this->proposerVpnModel->updateProposition($vpn_numero, $activite_numero, $data)) {
            return redirect()->to('/gingembre/salle_6/proposer-vpn')->with('success', 'Proposition modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function Delete($vpn_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->proposerVpnModel->deleteProposition($vpn_numero, $activite_numero)) {
            return redirect()->to('/gingembre/salle_6/proposer-vpn')->with('success', 'Proposition supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/proposer-vpn')->with('error', 'Erreur lors de la suppression');
        }
    }
}