<?php

namespace App\Controllers\admin\salle_6;

use App\Controllers\BaseController;
use App\Models\admin\commun\ExplicationAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ExplicationAdminController extends BaseController
{
    protected ExplicationAdminModel $explicationModel;
    protected int $perPage = 10;

    public function __construct()
    {
        $this->explicationModel = new ExplicationAdminModel();
    }

    private function checkAuth(): ?RedirectResponse
    {
        if (session()->get('admin_id') === null) {
            return redirect()->to('/gingembre');
        }
        return null;
    }

    private function getPaginatedData(?int $salleNumero = null): array
    {
        $search = $this->request->getGet('search') ?? '';
        $sort = $this->request->getGet('sort') ?? 'numero';
        $order = $this->request->getGet('order') ?? 'ASC';
        $page = (int)($this->request->getGet('page') ?? 1);

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            $order = 'ASC';
        }

        if ($page < 1) {
            $page = 1;
        }

        $total = $this->explicationModel->countExplications($salleNumero, $search);
        $offset = max(0, ($page - 1) * $this->perPage);
        
        $builder = $this->explicationModel->getExplicationListBuilder($salleNumero, $search, $sort, $order);
        $results = $builder->limit($this->perPage, $offset)->get()->getResultArray();

        $pager = service('pager');

        $queryParams = [];
        if ($search) $queryParams['search'] = $search;
        if ($sort !== 'numero') $queryParams['sort'] = $sort;
        if ($order !== 'ASC') $queryParams['order'] = $order;
        if ($salleNumero) $queryParams['salle'] = $salleNumero;

        $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';

        return [
            'explications' => $results,
            'pager' => $pager,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'total' => $total,
            'currentPage' => $page,
            'perPage' => $this->perPage,
            'queryString' => $queryString,
            'salleNumero' => $salleNumero
        ];
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $salleNumero = $this->request->getGet('salle') ? (int)$this->request->getGet('salle') : null;
        $data = $this->getPaginatedData($salleNumero);

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