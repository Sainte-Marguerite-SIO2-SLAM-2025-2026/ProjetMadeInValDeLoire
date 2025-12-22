<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\ActiviteAdminModel;
use App\Models\admin\commun\SalleAdminModel;
use App\Models\admin\commun\DifficulteAdminModel;
use App\Models\admin\commun\TypeAdminModel;
use App\Models\admin\commun\ExplicationAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ActiviteController extends AdminSalle6Controller
{
    protected ActiviteAdminModel $activiteModel;
    protected SalleAdminModel $salleModel;
    protected DifficulteAdminModel $difficulteModel;
    protected TypeAdminModel $typeModel;
    protected ExplicationAdminModel $explicationModel;

    public function __construct()
    {
        $this->activiteModel = new ActiviteAdminModel();
        $this->salleModel = new SalleAdminModel();
        $this->difficulteModel = new DifficulteAdminModel();
        $this->typeModel = new TypeAdminModel();
        $this->explicationModel = new ExplicationAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $salleNumero = $this->request->getGet('salle') ? (int)$this->request->getGet('salle') : null;

        $data = $this->getPaginatedData(
            $this->activiteModel,
            'getActiviteListBuilder',
            'countActivites',
            'numero',
            $salleNumero
        );

        $data['activites'] = $data['results'];
        unset($data['results']);
        $data['salles'] = $this->salleModel->getAllSalles();

        return view('admin/salle_6/activite/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'salles' => $this->salleModel->getAllSalles(),
            'difficultes' => $this->difficulteModel->getAllDifficulties(),
            'types' => $this->typeModel->getAllTypes(),
            'explications' => $this->explicationModel->getAllExplications()
        ];

        return view('admin/salle_6/activite/create', $data);
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]',
            'salle_numero' => 'permit_empty|integer',
            'verrouillage' => 'permit_empty|in_list[0,1]',
            'malveillant' => 'permit_empty|in_list[0,1]',
            'image' => 'permit_empty|max_length[50]',
            'difficulte_numero' => 'permit_empty|integer',
            'type_numero' => 'permit_empty|integer',
            'explication_numero' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'verrouillage' => $this->request->getPost('verrouillage') ?: null,
            'image' => $this->request->getPost('image') ?: null,
            'malveillant' => $this->request->getPost('malveillant') ?: null,
            'difficulte_numero' => $this->request->getPost('difficulte_numero') ?: null,
            'salle_numero' => $this->request->getPost('salle_numero') ?: null,
            'type_numero' => $this->request->getPost('type_numero') ?: null,
            'explication_numero' => $this->request->getPost('explication_numero') ?: null,
            'width_img' => $this->request->getPost('width_img') ?: null,
            'height_img' => $this->request->getPost('height_img') ?: null
        ];

        if ($this->activiteModel->createActivite($data)) {
            return redirect()->to('/gingembre/salle_6/activite')->with('success', 'Activité créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'activité');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $activite = $this->activiteModel->getActiviteByNumero($id);
        if (!$activite) {
            return redirect()->to('/gingembre/salle_6/activite')->with('error', 'Activité introuvable');
        }

        $data = [
            'activite' => $activite,
            'salles' => $this->salleModel->getAllSalles(),
            'difficultes' => $this->difficulteModel->getAllDifficulties(),
            'types' => $this->typeModel->getAllTypes(),
            'explications' => $this->explicationModel->getAllExplications()
        ];

        return view('admin/salle_6/activite/edit', $data);
    }

    public function update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]',
            'salle_numero' => 'permit_empty|integer',
            'verrouillage' => 'permit_empty|in_list[0,1]',
            'malveillant' => 'permit_empty|in_list[0,1]',
            'image' => 'permit_empty|max_length[50]',
            'difficulte_numero' => 'permit_empty|integer',
            'type_numero' => 'permit_empty|integer',
            'explication_numero' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'verrouillage' => $this->request->getPost('verrouillage') ?: null,
            'image' => $this->request->getPost('image') ?: null,
            'malveillant' => $this->request->getPost('malveillant') ?: null,
            'difficulte_numero' => $this->request->getPost('difficulte_numero') ?: null,
            'salle_numero' => $this->request->getPost('salle_numero') ?: null,
            'type_numero' => $this->request->getPost('type_numero') ?: null,
            'explication_numero' => $this->request->getPost('explication_numero') ?: null,
            'width_img' => $this->request->getPost('width_img') ?: null,
            'height_img' => $this->request->getPost('height_img') ?: null
        ];

        if ($this->activiteModel->updateActivite($id, $data)) {
            return redirect()->to('/gingembre/salle_6/activite')->with('success', 'Activité modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->activiteModel->deleteActivite($id)) {
            return redirect()->to('/gingembre/salle_6/activite')->with('success', 'Activité supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/activite')->with('error', 'Impossible de supprimer cette activité (utilisée dans d\'autres tables)');
        }
    }
}