<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\IndiceAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class IndiceController extends AdminSalle6Controller
{
    protected IndiceAdminModel $indiceModel;
    protected const SALLE_NUMERO = 6;

    public function __construct()
    {
        $this->indiceModel = new IndiceAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Force la salle 6
        $data = $this->getPaginatedData(
            $this->indiceModel,
            'getIndiceListBuilder',
            'countIndices',
            'numero',
            self::SALLE_NUMERO
        );

        $data['indices'] = $data['results'];
        unset($data['results']);
        $data['current_salle'] = self::SALLE_NUMERO;

        return view('admin/salle_6/indice/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = ['current_salle' => self::SALLE_NUMERO];
        return view('admin/salle_6/indice/create', $data);
    }

    public function Store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'numero' => 'required|integer|greater_than_equal_to[600]|less_than_equal_to[699]',
            'libelle' => 'required|min_length[3]'
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
        if ($this->indiceModel->find($numero)) {
            return redirect()->back()->withInput()->with('error', "L'indice n°{$numero} existe déjà");
        }

        $data = [
            'numero' => $numero,
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->indiceModel->createIndice($data)) {
            return redirect()->to('/gingembre/salle_6/indice')->with('success', 'Indice créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function Edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que l'indice appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/indice')->with('error', 'Indice non accessible');
        }

        $indice = $this->indiceModel->getIndiceByNumero($id);
        if (!$indice) {
            return redirect()->to('/gingembre/salle_6/indice')->with('error', 'Indice introuvable');
        }

        $data = [
            'indice' => $indice,
            'current_salle' => self::SALLE_NUMERO
        ];

        return view('admin/salle_6/indice/edit', $data);
    }

    public function Update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que l'indice appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/indice')->with('error', 'Indice non accessible');
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

        if ($this->indiceModel->updateIndice($id, $data)) {
            return redirect()->to('/gingembre/salle_6/indice')->with('success', 'Indice modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function Delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que l'indice appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/indice')->with('error', 'Indice non accessible');
        }

        if ($this->indiceModel->deleteIndice($id)) {
            return redirect()->to('/gingembre/salle_6/indice')->with('success', 'Indice supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/indice')->with('error', 'Impossible de supprimer (utilisé dans des activités)');
        }
    }
}