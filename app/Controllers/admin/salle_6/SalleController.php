<?php

namespace App\Controllers\admin\salle_6;

use App\Controllers\BaseController;
use App\Models\admin\commun\SalleAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class SalleAdminController extends BaseController
{
    protected SalleAdminModel $salleModel;
    protected int $perPage = 10;

    public function __construct()
    {
        $this->salleModel = new SalleAdminModel();
    }

    private function checkAuth(): ?RedirectResponse
    {
        if (session()->get('admin_id') === null) {
            return redirect()->to('/gingembre');
        }
        return null;
    }

    private function getPaginatedData(): array
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

        $total = $this->salleModel->countSalles($search);
        $offset = max(0, ($page - 1) * $this->perPage);
        
        $builder = $this->salleModel->getSalleListBuilder($search, $sort, $order);
        $results = $builder->limit($this->perPage, $offset)->get()->getResultArray();

        $pager = service('pager');

        $queryParams = [];
        if ($search) $queryParams['search'] = $search;
        if ($sort !== 'numero') $queryParams['sort'] = $sort;
        if ($order !== 'ASC') $queryParams['order'] = $order;

        $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';

        return [
            'salles' => $results,
            'pager' => $pager,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'total' => $total,
            'currentPage' => $page,
            'perPage' => $this->perPage,
            'queryString' => $queryString
        ];
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData();
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