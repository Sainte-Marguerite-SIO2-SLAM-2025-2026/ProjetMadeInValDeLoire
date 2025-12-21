<?php

namespace App\Controllers\admin\salle_6;

use App\Controllers\BaseController;
use App\Models\admin\commun\AvoirIndiceAdminModel;
use App\Models\admin\commun\ActiviteAdminModel;
use App\Models\admin\commun\IndiceAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class AvoirIndiceAdminController extends BaseController
{
    protected AvoirIndiceAdminModel $avoirIndiceModel;
    protected ActiviteAdminModel $activiteModel;
    protected IndiceAdminModel $indiceModel;
    protected int $perPage = 10;

    public function __construct()
    {
        $this->avoirIndiceModel = new AvoirIndiceAdminModel();
        $this->activiteModel = new ActiviteAdminModel();
        $this->indiceModel = new IndiceAdminModel();
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
        $sort = $this->request->getGet('sort') ?? 'activite_numero';
        $order = $this->request->getGet('order') ?? 'ASC';
        $page = (int)($this->request->getGet('page') ?? 1);

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            $order = 'ASC';
        }

        if ($page < 1) {
            $page = 1;
        }

        $total = $this->avoirIndiceModel->countAvoirIndices($salleNumero, $search);
        $offset = max(0, ($page - 1) * $this->perPage);

        $builder = $this->avoirIndiceModel->getAvoirIndiceListBuilder($salleNumero, $search, $sort, $order);
        $results = $builder->limit($this->perPage, $offset)->get()->getResultArray();

        $pager = service('pager');

        $queryParams = [];
        if ($search) $queryParams['search'] = $search;
        if ($sort !== 'activite_numero') $queryParams['sort'] = $sort;
        if ($order !== 'ASC') $queryParams['order'] = $order;
        if ($salleNumero) $queryParams['salle'] = $salleNumero;

        $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';

        return [
            'associations' => $results,
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