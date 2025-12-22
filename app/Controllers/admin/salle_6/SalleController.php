<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\SalleAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class SalleController extends AdminSalle6Controller
{
    protected SalleAdminModel $salleModel;
    protected const SALLE_NUMERO = 6;

    public function __construct()
    {
        $this->salleModel = new SalleAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Récupérer uniquement la salle 6
        $salle = $this->salleModel->getSalleByNumero(self::SALLE_NUMERO);

        if (!$salle) {
            return redirect()->to('/gingembre/admin')->with('error', 'Salle 6 introuvable');
        }

        // Récupérer les paramètres de recherche et tri (même si non utilisés ici)
        $search = $this->request->getGet('search') ?? '';
        $sort = $this->request->getGet('sort') ?? 'numero';
        $order = $this->request->getGet('order') ?? 'ASC';

        $data = [
            'salles' => [$salle],
            'current_salle' => self::SALLE_NUMERO,
            'total' => 1,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'currentPage' => 1,
            'perPage' => 1,
            'pager' => null
        ];

        return view('admin/salle_6/salle/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        // Empêcher la création d'une nouvelle salle depuis l'interface salle_6
        return redirect()->to('/gingembre/salle_6/salle')->with('error', 'La création de salle n\'est pas autorisée depuis cette interface');
    }

    public function Store(): RedirectResponse
    {
        // Empêcher la création d'une nouvelle salle
        return redirect()->to('/gingembre/salle_6/salle')->with('error', 'La création de salle n\'est pas autorisée depuis cette interface');
    }

    public function Edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que c'est bien la salle 6
        if ($id != self::SALLE_NUMERO) {
            return redirect()->to('/gingembre/salle_6/salle')->with('error', 'Seule la salle 6 peut être modifiée depuis cette interface');
        }

        $salle = $this->salleModel->getSalleByNumero($id);
        if (!$salle) {
            return redirect()->to('/gingembre/salle_6/salle')->with('error', 'Salle introuvable');
        }

        $data = [
            'salle' => $salle,
            'current_salle' => self::SALLE_NUMERO
        ];

        return view('admin/salle_6/salle/edit', $data);
    }

    public function Update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que c'est bien la salle 6
        if ($id != self::SALLE_NUMERO) {
            return redirect()->to('/gingembre/salle_6/salle')->with('error', 'Seule la salle 6 peut être modifiée depuis cette interface');
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

    public function Delete($id): RedirectResponse
    {
        // Empêcher la suppression de la salle 6
        return redirect()->to('/gingembre/salle_6/salle')->with('error', 'La suppression de salle n\'est pas autorisée depuis cette interface');
    }
}