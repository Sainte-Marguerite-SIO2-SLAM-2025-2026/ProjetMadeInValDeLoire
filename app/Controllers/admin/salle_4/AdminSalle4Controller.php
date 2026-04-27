<?php

namespace App\Controllers\admin\salle_4;

use App\Controllers\BaseController;
use App\Models\admin\salle_4\CarteAdminModel;
use App\Models\admin\salle_4\QuestionAdminModel;
use App\Models\admin\commun\ActiviteAdminModel;
use App\Models\admin\commun\ExplicationAdminModel;
use App\Models\admin\commun\IndiceAdminModel;
use App\Models\admin\commun\SalleAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class AdminSalle4Controller extends BaseController
{
    protected $carteModel;
    protected $questionModel;
    protected $activiteModel;
    protected $explicationModel;
    protected $indiceModel;
    protected $salleModel;
    protected $salleNumero = 4;

    public function __construct()
    {
        $this->carteModel = new CarteAdminModel();
        $this->questionModel = new QuestionAdminModel();
        $this->activiteModel = new ActiviteAdminModel();
        $this->explicationModel = new ExplicationAdminModel();
        $this->indiceModel = new IndiceAdminModel();
        $this->salleModel = new SalleAdminModel();
    }

    /**
     * Page d'accueil de l'administration Salle 4
     */
    public function index(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data = [
            'total_cartes' => $this->carteModel->countCartesSalle4(),
            'total_questions' => $this->questionModel->countQuestionsSalle4(),
            'cartes_bonnes_pratiques' => $this->carteModel->where('type_carte', 'bonne_pratique')->countAllResults(),
            'cartes_pieges' => $this->carteModel->where('type_carte', 'piege')->countAllResults(),
            'stats_reponses' => $this->questionModel->countByReponse(),
            'total_activites' => $this->activiteModel->countActivites($this->salleNumero),
            'total_explications' => $this->explicationModel->countExplications($this->salleNumero),
            'total_indices' => $this->indiceModel->countIndices($this->salleNumero)
        ];

        return view('admin/salle_4/dashboard', $data);
    }

    // ==================== GESTION CARTES ====================

    /**
     * Liste des cartes
     */
    public function carteList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['cartes'] = $this->carteModel->getAllCartesWithActivite();
        return view('admin/salle_4/carte/carte_list', $data);
    }

    /**
     * Formulaire de création d'une carte
     */
    public function carteCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['activites'] = $this->carteModel->getActivites();
        return view('admin/salle_4/carte/carte_form', $data);
    }

    /**
     * Enregistrement d'une nouvelle carte
     */
    public function carteStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'image' => 'required|max_length[50]',
            'explication' => 'required',
            'type_carte' => 'required|in_list[bonne_pratique,piege]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'image' => $this->request->getPost('image'),
            'explication' => $this->request->getPost('explication'),
            'activite_numero' => $this->request->getPost('activite_numero') ?: null,
            'explication_piege' => $this->request->getPost('explication_piege') ?: null,
            'type_carte' => $this->request->getPost('type_carte')
        ];

        $this->carteModel->insert($data);
        return redirect()->to('/gingembre/salle_4/carte')->with('success', 'Carte créée avec succès');
    }

    /**
     * Formulaire d'édition d'une carte
     */
    public function carteEdit($id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['carte'] = $this->carteModel->find($id);
        if (!$data['carte']) {
            return redirect()->to('/gingembre/salle_4/carte')->with('error', 'Carte introuvable');
        }

        $data['activites'] = $this->carteModel->getActivites();
        return view('admin/salle_4/carte/carte_form', $data);
    }

    /**
     * Mise à jour d'une carte
     */
    public function carteUpdate($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'image' => 'required|max_length[50]',
            'explication' => 'required',
            'type_carte' => 'required|in_list[bonne_pratique,piege]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'image' => $this->request->getPost('image'),
            'explication' => $this->request->getPost('explication'),
            'activite_numero' => $this->request->getPost('activite_numero') ?: null,
            'explication_piege' => $this->request->getPost('explication_piege') ?: null,
            'type_carte' => $this->request->getPost('type_carte')
        ];

        $this->carteModel->update($id, $data);
        return redirect()->to('/gingembre/salle_4/carte')->with('success', 'Carte modifiée avec succès');
    }

    /**
     * Suppression d'une carte
     */
    public function carteDelete($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $this->carteModel->delete($id);
        return redirect()->to('/gingembre/salle_4/carte')->with('success', 'Carte supprimée avec succès');
    }

    // ==================== GESTION QUESTIONS ====================

    /**
     * Liste des questions
     */
    public function questionList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['questions'] = $this->questionModel->getAllQuestionsWithActivite();
        return view('admin/salle_4/question/question_list', $data);
    }

    /**
     * Formulaire de création d'une question
     */
    public function questionCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['activites'] = $this->questionModel->getActivites();
        return view('admin/salle_4/question/question_form', $data);
    }

    /**
     * Enregistrement d'une nouvelle question
     */
    public function questionStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'libelle' => 'required',
            'reponse' => 'required|in_list[0,1]',
            'activite_numero' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'reponse' => $this->request->getPost('reponse'),
            'activite_numero' => $this->request->getPost('activite_numero')
        ];

        $this->questionModel->insert($data);
        return redirect()->to('/gingembre/salle_4/question')->with('success', 'Question créée avec succès');
    }

    /**
     * Formulaire d'édition d'une question
     */
    public function questionEdit($id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['question'] = $this->questionModel->find($id);
        if (!$data['question']) {
            return redirect()->to('/gingembre/salle_4/question')->with('error', 'Question introuvable');
        }

        $data['activites'] = $this->questionModel->getActivites();
        return view('admin/salle_4/question/question_form', $data);
    }

    /**
     * Mise à jour d'une question
     */
    public function questionUpdate($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'libelle' => 'required',
            'reponse' => 'required|in_list[0,1]',
            'activite_numero' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'reponse' => $this->request->getPost('reponse'),
            'activite_numero' => $this->request->getPost('activite_numero')
        ];

        $this->questionModel->update($id, $data);
        return redirect()->to('/gingembre/salle_4/question')->with('success', 'Question modifiée avec succès');
    }

    /**
     * Suppression d'une question
     */
    public function questionDelete($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $this->questionModel->delete($id);
        return redirect()->to('/gingembre/salle_4/question')->with('success', 'Question supprimée avec succès');
    }

    // ==================== GESTION ACTIVITÉS ====================

    /**
     * Liste des activités de la salle 4
     */
    public function activiteList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['activites'] = $this->activiteModel->getActivitesBySalle($this->salleNumero);
        return view('admin/salle_4/activite/activite_list', $data);
    }

    /**
     * Formulaire de création d'une activité
     */
    public function activiteCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data = [
            'explications' => $this->explicationModel->getExplicationsBySalle($this->salleNumero),
            'next_numero' => $this->activiteModel->getNextNumeroForSalle($this->salleNumero)
        ];
        return view('admin/salle_4/activite/activite_form', $data);
    }

    /**
     * Enregistrement d'une nouvelle activité
     */
    public function activiteStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'numero' => 'required|numeric|is_unique[activite.numero]',
            'libelle' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'numero' => $this->request->getPost('numero'),
            'libelle' => $this->request->getPost('libelle'),
            'verrouillage' => $this->request->getPost('verrouillage') ?: 0,
            'image' => $this->request->getPost('image') ?: null,
            'explication_numero' => $this->request->getPost('explication_numero') ?: null,
            'salle_numero' => $this->salleNumero
        ];

        if ($this->activiteModel->createActivite($data)) {
            return redirect()->to('/gingembre/salle_4/activite')->with('success', 'Activité créée avec succès');
        }

        return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'activité');
    }

    /**
     * Formulaire d'édition d'une activité
     */
    public function activiteEdit($id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['activite'] = $this->activiteModel->find($id);
        if (!$data['activite']) {
            return redirect()->to('/gingembre/salle_4/activite')->with('error', 'Activité introuvable');
        }

        $data['explications'] = $this->explicationModel->getExplicationsBySalle($this->salleNumero);
        return view('admin/salle_4/activite/activite_form', $data);
    }

    /**
     * Mise à jour d'une activité
     */
    public function activiteUpdate($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'libelle' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'verrouillage' => $this->request->getPost('verrouillage') ?: 0,
            'image' => $this->request->getPost('image') ?: null,
            'explication_numero' => $this->request->getPost('explication_numero') ?: null,
            'salle_numero' => $this->salleNumero
        ];

        if ($this->activiteModel->updateActivite($id, $data)) {
            return redirect()->to('/gingembre/salle_4/activite')->with('success', 'Activité modifiée avec succès');
        }

        return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'activité');
    }

    /**
     * Suppression d'une activité
     */
    public function activiteDelete($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        if ($this->activiteModel->deleteActivite($id)) {
            return redirect()->to('/gingembre/salle_4/activite')->with('success', 'Activité supprimée avec succès');
        }

        return redirect()->to('/gingembre/salle_4/activite')->with('error', 'Impossible de supprimer cette activité (utilisée ailleurs)');
    }

    // ==================== GESTION EXPLICATIONS ====================

    /**
     * Liste des explications de la salle 4
     */
    public function explicationList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['explications'] = $this->explicationModel->getExplicationsBySalle($this->salleNumero);
        return view('admin/salle_4/explication/explication_list', $data);
    }

    /**
     * Formulaire de création d'une explication
     */
    public function explicationCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['next_numero'] = $this->explicationModel->getNextNumeroForSalle($this->salleNumero);
        return view('admin/salle_4/explication/explication_form', $data);
    }

    /**
     * Enregistrement d'une nouvelle explication
     */
    public function explicationStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'numero' => 'required|numeric|is_unique[explication.numero]',
            'libelle' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'numero' => $this->request->getPost('numero'),
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->explicationModel->createExplication($data)) {
            return redirect()->to('/gingembre/salle_4/explication')->with('success', 'Explication créée avec succès');
        }

        return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'explication');
    }

    /**
     * Formulaire d'édition d'une explication
     */
    public function explicationEdit($id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['explication'] = $this->explicationModel->find($id);
        if (!$data['explication']) {
            return redirect()->to('/gingembre/salle_4/explication')->with('error', 'Explication introuvable');
        }

        return view('admin/salle_4/explication/explication_form', $data);
    }

    /**
     * Mise à jour d'une explication
     */
    public function explicationUpdate($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'libelle' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->explicationModel->updateExplication($id, $data)) {
            return redirect()->to('/gingembre/salle_4/explication')->with('success', 'Explication modifiée avec succès');
        }

        return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'explication');
    }

    /**
     * Suppression d'une explication
     */
    public function explicationDelete($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        if ($this->explicationModel->deleteExplication($id)) {
            return redirect()->to('/gingembre/salle_4/explication')->with('success', 'Explication supprimée avec succès');
        }

        return redirect()->to('/gingembre/salle_4/explication')->with('error', 'Impossible de supprimer cette explication (utilisée ailleurs)');
    }

    // ==================== GESTION INDICES ====================

    /**
     * Liste des indices de la salle 4
     */
    public function indiceList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['indices'] = $this->indiceModel->getIndicesBySalle($this->salleNumero);
        return view('admin/salle_4/indice/indice_list', $data);
    }

    /**
     * Formulaire de création d'un indice
     */
    public function indiceCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['next_numero'] = $this->indiceModel->getNextNumeroForSalle($this->salleNumero);
        return view('admin/salle_4/indice/indice_form', $data);
    }

    /**
     * Enregistrement d'un nouvel indice
     */
    public function indiceStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'numero' => 'required|numeric|is_unique[indice.numero]',
            'libelle' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'numero' => $this->request->getPost('numero'),
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->indiceModel->createIndice($data)) {
            return redirect()->to('/gingembre/salle_4/indice')->with('success', 'Indice créé avec succès');
        }

        return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de l\'indice');
    }

    /**
     * Formulaire d'édition d'un indice
     */
    public function indiceEdit($id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['indice'] = $this->indiceModel->find($id);
        if (!$data['indice']) {
            return redirect()->to('/gingembre/salle_4/indice')->with('error', 'Indice introuvable');
        }

        return view('admin/salle_4/indice/indice_form', $data);
    }

    /**
     * Mise à jour d'un indice
     */
    public function indiceUpdate($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'libelle' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle')
        ];

        if ($this->indiceModel->updateIndice($id, $data)) {
            return redirect()->to('/gingembre/salle_4/indice')->with('success', 'Indice modifié avec succès');
        }

        return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification de l\'indice');
    }

    /**
     * Suppression d'un indice
     */
    public function indiceDelete($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        if ($this->indiceModel->deleteIndice($id)) {
            return redirect()->to('/gingembre/salle_4/indice')->with('success', 'Indice supprimé avec succès');
        }

        return redirect()->to('/gingembre/salle_4/indice')->with('error', 'Impossible de supprimer cet indice (utilisé ailleurs)');
    }
}