<?php

namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\ExplicationAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class ExplicationController extends AdminSalle6Controller
{
    protected ExplicationAdminModel $explicationModel;
    protected const SALLE_NUMERO = 6;

    public function __construct()
    {
        $this->explicationModel = new ExplicationAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Force la salle 6
        $data = $this->getPaginatedData(
            $this->explicationModel,
            'getExplicationListBuilder',
            'countExplications',
            'numero',
            self::SALLE_NUMERO
        );

        $data['explications'] = $data['results'];
        unset($data['results']);
        $data['current_salle'] = self::SALLE_NUMERO;

        return view('admin/salle_6/explication/index', $data);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = ['current_salle' => self::SALLE_NUMERO];
        return view('admin/salle_6/explication/create', $data);
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
        if ($this->explicationModel->find($numero)) {
            return redirect()->back()->withInput()->with('error', "L'explication n°{$numero} existe déjà");
        }

        $data = [
            'numero' => $numero,
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->explicationModel->createExplication($data)) {
            return redirect()->to('/gingembre/salle_6/explication')->with('success', 'Explication créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création');
        }
    }

    public function Edit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que l'explication appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/explication')->with('error', 'Explication non accessible');
        }

        $explication = $this->explicationModel->getExplicationByNumero($id);
        if (!$explication) {
            return redirect()->to('/gingembre/salle_6/explication')->with('error', 'Explication introuvable');
        }

        $data = [
            'explication' => $explication,
            'current_salle' => self::SALLE_NUMERO
        ];

        return view('admin/salle_6/explication/edit', $data);
    }

    public function Update($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que l'explication appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/explication')->with('error', 'Explication non accessible');
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

    public function Delete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que l'explication appartient à la salle 6
        if ($id < 600 || $id > 699) {
            return redirect()->to('/gingembre/salle_6/explication')->with('error', 'Explication non accessible');
        }

        if ($this->explicationModel->deleteExplication($id)) {
            return redirect()->to('/gingembre/salle_6/explication')->with('success', 'Explication supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/explication')->with('error', 'Impossible de supprimer (utilisée dans des activités)');
        }
    }
}