<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\TypeAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class TypeController extends AdminSalle6Controller
{
    protected TypeAdminModel $typeModel;
    protected const SALLE_NUMERO = 6;

    public function __construct()
    {
        $this->typeModel = new TypeAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Force la salle 6
        $data = $this->getPaginatedData(
            $this->typeModel,
            'getTypeListBuilder',
            'countTypes',
            'numero',
            self::SALLE_NUMERO
        );

        $data['types'] = $data['results'];
        unset($data['results']);
        $data['current_salle'] = self::SALLE_NUMERO;

        return view('admin/salle_6/type/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = ['current_salle' => self::SALLE_NUMERO];
        return view('admin/salle_6/type/create', $data);
    }

    public function Store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'numero' => 'required|integer|greater_than_equal_to[600]|less_than_equal_to[699]',
            'libelle' => 'required|min_length[3]|max_length[30]',
            'explication' => 'required'
        ];

        $messages = [
            'numero' => [
                'required' => 'Le numéro est obligatoire',
                'integer' => 'Le numéro doit être un nombre entier',
                'greater_than_equal_to' => 'Le numéro doit être supérieur ou égal à 600',
                'less_than_equal_to' => 'Le numéro doit être inférieur ou égal à 699'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $numero = (int)$this->request->getPost('numero');

        // Vérifier que le numéro est dans la plage 600-699
        if ($numero < 600 || $numero > 699) {
            return redirect()->back()->withInput()->with('error', 'Le numéro doit être entre 600 et 699 pour la salle 6');
        }

        // Vérifier que le numéro n'existe pas déjà
        if ($this->typeModel->find($numero)) {
            return redirect()->back()->withInput()->with('error', "Le type n°{$numero} existe déjà");
        }

        $data = [
            'numero' => $numero,
            'libelle' => $this->request->getPost('libelle'),
            'explication' => $this->request->getPost('explication')
        ];

        if ($this->typeModel->createType($data)) {
            return redirect()->to('/gingembre/salle_6/type')->with('success', 'Type créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function Edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que le type appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/type')->with('error', 'Type non accessible');
        }

        $type = $this->typeModel->getTypeByNumero($id);
        if (!$type) {
            return redirect()->to('/gingembre/salle_6/type')->with('error', 'Type introuvable');
        }

        $data = [
            'type' => $type,
            'current_salle' => self::SALLE_NUMERO
        ];

        return view('admin/salle_6/type/edit', $data);
    }

    public function Update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que le type appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/type')->with('error', 'Type non accessible');
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[30]',
            'explication' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'explication' => $this->request->getPost('explication')
        ];

        if ($this->typeModel->updateType($id, $data)) {
            return redirect()->to('/gingembre/salle_6/type')->with('success', 'Type modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function Delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que le type appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/type')->with('error', 'Type non accessible');
        }

        if ($this->typeModel->deleteType($id)) {
            return redirect()->to('/gingembre/salle_6/type')->with('success', 'Type supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/type')->with('error', 'Impossible de supprimer (utilisé dans des activités)');
        }
    }
}