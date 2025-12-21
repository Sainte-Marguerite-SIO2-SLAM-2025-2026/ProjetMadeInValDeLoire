<?php

namespace App\Controllers\commun;

use App\Controllers\BaseController;
use App\Models\salle_6\ProposerVpnAdminModel;
use App\Models\salle_6\VpnAdminModel;

class ProposerVpnAdminController extends BaseController
{
    protected $proposerModel;
    protected $vpnModel;
    protected $perPage = 10;

    public function __construct()
    {
        $this->proposerModel = new ProposerVpnAdminModel();
        $this->vpnModel = new VpnAdminModel();
    }

    /**
     * Liste des propositions VPN avec pagination et recherche
     */
    public function index()
    {
        $search = $this->request->getGet('search');
        $sort = $this->request->getGet('sort') ?? 'vpn_numero';
        $order = $this->request->getGet('order') ?? 'ASC';

        $builder = $this->proposerModel->builder();
        
        // Jointure pour afficher le libellé du VPN
        $builder->select('proposer_vpn.*, vpn.libelle as vpn_libelle')
            ->join('vpn', 'vpn.numero = proposer_vpn.vpn_numero', 'left');

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('proposer_vpn.vpn_numero', $search)
                ->orLike('proposer_vpn.activite_numero', $search)
                ->orLike('vpn.libelle', $search)
                ->groupEnd();
        }

        // Tri
        if ($sort === 'vpn_libelle') {
            $builder->orderBy('vpn.libelle', $order);
        } else {
            $builder->orderBy('proposer_vpn.' . $sort, $order);
        }

        // Pagination
        $data = [
            'propositions' => $builder->paginate($this->perPage),
            'pager' => $this->proposerModel->pager,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'total' => $builder->countAllResults(false)
        ];

        return view('admin/proposer_vpn/index', $data);
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $data = [
            'vpns' => $this->vpnModel->findAll()
        ];
        return view('admin/proposer_vpn/create', $data);
    }

    /**
     * Enregistrer une nouvelle proposition
     */
    public function store()
    {
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

        if ($this->proposerModel->insert($data)) {
            return redirect()->to('/admin/proposer-vpn')->with('success', 'Proposition VPN créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création (la proposition existe peut-être déjà)');
        }
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($vpn_numero, $activite_numero)
    {
        $proposition = $this->proposerModel
            ->where('vpn_numero', $vpn_numero)
            ->where('activite_numero', $activite_numero)
            ->first();

        if (!$proposition) {
            return redirect()->to('/admin/proposer-vpn')->with('error', 'Proposition introuvable');
        }

        $data = [
            'proposition' => $proposition,
            'vpns' => $this->vpnModel->findAll()
        ];
        return view('admin/proposer_vpn/edit', $data);
    }

    /**
     * Mettre à jour une proposition
     */
    public function update($vpn_numero, $activite_numero)
    {
        $rules = [
            'bonne_reponse' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'bonne_reponse' => $this->request->getPost('bonne_reponse')
        ];

        if ($this->proposerModel->where('vpn_numero', $vpn_numero)
            ->where('activite_numero', $activite_numero)
            ->set($data)
            ->update()) {
            return redirect()->to('/admin/proposer-vpn')->with('success', 'Proposition modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    /**
     * Supprimer une proposition
     */
    public function delete($vpn_numero, $activite_numero)
    {
        if ($this->proposerModel->where('vpn_numero', $vpn_numero)
            ->where('activite_numero', $activite_numero)
            ->delete()) {
            return redirect()->to('/admin/proposer-vpn')->with('success', 'Proposition supprimée avec succès');
        } else {
            return redirect()->to('/admin/proposer-vpn')->with('error', 'Erreur lors de la suppression');
        }
    }
}
