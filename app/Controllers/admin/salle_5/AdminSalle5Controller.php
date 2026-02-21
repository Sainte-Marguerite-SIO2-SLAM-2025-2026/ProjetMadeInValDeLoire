<?php
namespace App\Controllers\admin\salle_5;

use App\Controllers\BaseController;
use App\Models\admin\commun\ActiviteAdminModel;
use App\Models\admin\commun\ExplicationAdminModel;
use App\Models\admin\commun\IndiceAdminModel;
use App\Models\admin\commun\SalleAdminModel;
use App\Models\admin\salle_5\ActiviteMessageAdminModel;
use App\Models\admin\salle_5\AvoirRepAdminModel;
use App\Models\admin\salle_5\ModeEmploiAdminModel;
use App\Models\admin\salle_5\objetAdminModel;
use App\Models\admin\salle_5\ObjetsActiviteAdminModel;
use App\Models\admin\salle_5\ObjetsDeclencheursAdminModel;
use App\Models\salle_5\ActiviteModel;
use CodeIgniter\HTTP\RedirectResponse;

class AdminSalle5Controller extends BaseController
{

    protected $objetsModel;
    protected $objetsDeclencheursModel;
    protected $activiteModel;
    protected $modeEmploiModel;
    protected $activiteMessageModel;
    protected $avoirRepModel;
    protected $explicationModel;
    protected $indiceModel;
    protected $salleModel;
    protected $objetsActiviteModel;
    protected $salleNumero = 5;

    public function __construct()
    {
        $this->objetsModel = new ObjetAdminModel();
        $this->objetsDeclencheursModel = new ObjetsDeclencheursAdminModel();
        $this->activiteModel = new ActiviteAdminModel();
        $this->explicationModel = new ExplicationAdminModel();
        $this->indiceModel = new IndiceAdminModel();
        $this->salleModel = new SalleAdminModel();
        $this->modeEmploiModel = new ModeEmploiAdminModel();
        $this->activiteMessageModel = new ActiviteMessageAdminModel();
        $this->objetsActiviteModel = new objetsActiviteAdminModel();
        $this->avoirRepModel = new AvoirRepAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data = [
            "totalObjets" => $this->objetsModel->getNbObjets(),
            "totalObjetsDeclencheurs" => $this->objetsDeclencheursModel->getNbObjetsDeclencheurs(),
            "totalActivites" => $this->activiteModel->countActivites($this->salleNumero),
            'totalExplications' => $this->explicationModel->countExplications($this->salleNumero),
            'totalIndices' => $this->indiceModel->countIndices($this->salleNumero),
            'totalModeEmploi' => $this->modeEmploiModel->getNbModeEmploi(),
            'messageFaux' => $this->activiteMessageModel->getNbMessageEchec(),
            'messageVrai' => $this->activiteMessageModel->getNbMessageSucces(),
            'totalObjetsActivites' => $this->objetsActiviteModel->getNbObjetActivite(),
            'avoirRep' => $this->avoirRepModel->getNbRep()
        ];


        return view('admin/salle_5/dashboard', $data);
    }

    // ==================== GESTION OBJETS ====================

    /**
     * Liste des objet
     */
    public function objetList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['objets'] = $this->objetsModel->getAllObjets();
        return view('admin/salle_5/objet/ObjetsList', $data);
    }

    /**
     * Formulaire de création d'un objet
     */
    public function objetCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        return view('admin/salle_5/objet/objetsForm');
    }

    /**
     * Enregistrement d'un nouvel objet
     */
    public function objetStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'nom' => 'required|max_length[50]',
            'x' => 'permit_empty|numeric|max_length[50]',
            'y' => 'permit_empty|numeric|max_length[50]',
            'width' => 'permit_empty|numeric|max_length[50]',
            'height' => 'permit_empty|numeric|max_length[50]',
            'image' => 'required|max_length[50]',
            'texte_image' => 'max_length[80]',
            'hover' => 'max_length[80]',

        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $x = (float)$this->request->getPost('x');
        $y = (float)$this->request->getPost('y');
        $width = (float)$this->request->getPost('width');
        $height = (float)$this->request->getPost('height');

        $drag = (empty($x) && empty($y) && empty($width) && empty($height)) ? 'oui' : 'non';

        $data = [
            'nom' => $this->request->getPost('nom'),
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'image' => $this->request->getPost('image'),
            'reponse' => $this->request->getPost('nom'),
            'zone_path' => null,
            'texte' => $this->request->getPost('texte_image'),
            'texte_x' => null,
            'texte_y' => null,
            'rotate' => '0',
            'drag' => $drag,
            'hover' => $this->request->getPost('hover'),
            'cliquable' => $this->request->getPost('cliquable'),
            'ratio' => null
        ];

        $this->objetsModel->insert($data);
        return redirect()->to('/gingembre/salle_5/objet')->with('success', 'Objet créé avec succès');
    }

    /**
     * Formulaire d'édition d'un objet
     */
    public function objetEdit($id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['objet'] = $this->objetsModel->getObjetById($id);
        if (!$data['objet']) {
            return redirect()->to('/gingembre/salle_5/objet')->with('error', 'Objet introuvable');
        }

        return view('admin/salle_5/objet/objetsForm', $data);
    }

    /**
     * Mise à jour d'un objet
     */
    public function objetUpdate($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'nom' => 'required|max_length[50]',
            'x' => 'permit_empty|numeric|max_length[50]',
            'y' => 'permit_empty|numeric|max_length[50]',
            'width' => 'permit_empty|numeric|max_length[50]',
            'height' => 'permit_empty|numeric|max_length[50]',
            'image' => 'required|max_length[50]',
            'texte_image' => 'max_length[80]',
            'hover' => 'max_length[80]',

        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $x = (float)$this->request->getPost('x');
        $y = (float)$this->request->getPost('y');
        $width = (float)$this->request->getPost('width');
        $height = (float)$this->request->getPost('height');

        $drag = (empty($x) && empty($y) && empty($width) && empty($height)) ? 'oui' : 'non';

        $data = [
            'nom' => $this->request->getPost('nom'),
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'image' => $this->request->getPost('image'),
            'reponse' => $this->request->getPost('nom'),
            'zone_path' => null,
            'texte' => $this->request->getPost('texte_image'),
            'texte_x' => null,
            'texte_y' => null,
            'rotate' => '0',
            'drag' => $drag,
            'hover' => $this->request->getPost('hover'),
            'cliquable' => $this->request->getPost('cliquable'),
            'ratio' => null
        ];

        $this->objetsModel->update($id, $data);
        return redirect()->to('/gingembre/salle_5/objet')->with('success', 'Objet modifié avec succès');
    }

    /**
     * Suppression d'un objet
     */
    public function objetDelete($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $this->objetsModel->delete($id);
        return redirect()->to('/gingembre/salle_5/objet')->with('success', 'Objet supprimé avec succès');
    }



//

    public function objetDeclencheurList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['objetsDeclencheurs'] = $this->objetsDeclencheursModel->getObjetsDeclencheurs();
        return view('admin/salle_5/objet_declencheur/ObjetsDeclencheurList', $data);
    }

    /**
     * Formulaire de création d'un objet declencheur
     */
    public function objetDeclencheurCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data =[
            'activites' => $this->activiteModel->getActivitesBySalle($this->salleNumero),
            ];

        return view('admin/salle_5/objet_declencheur/objetsDeclencheurForm', $data);
    }

    /**
     * Enregistrement d'un nouvel objet declencheur
     */
    public function objetDeclencheurStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'nom' => 'required|max_length[50]',
            'image' => 'required|max_length[50]',
            'x' => 'permit_empty|numeric|max_length[50]',
            'y' => 'permit_empty|numeric|max_length[50]',
            'width' => 'permit_empty|numeric|max_length[50]',
            'height' => 'permit_empty|numeric|max_length[50]',
            'zone_path' => 'max_length[80]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'image_path' => $this->request->getPost('image'),
            'x' => $this->request->getPost('x'),
            'y' => $this->request->getPost('y'),
            'width' => $this->request->getPost('width'),
            'height' => $this->request->getPost('height'),
            'zone_path' => $this->request->getPost('zone_path')? $this->request->getPost('zone_path') : null,
            'numero_activite' => $this->request->getPost('numero_activite'),

        ];

        $this->objetsDeclencheursModel->insert($data);
        return redirect()->to('/gingembre/salle_5/objet_declencheur')->with('success', 'Objet créé avec succès');
    }

    /**
     * Formulaire d'édition d'un objet declencheur
     */
    public function objetDeclencheurEdit($id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['objetDeclencheur'] = $this->objetsDeclencheursModel->getObjetsDeclencheursById($id);
        $data ['activites'] = $this->activiteModel->getActivitesBySalle($this->salleNumero);

        if (!$data['objetDeclencheur']) {
            return redirect()->to('/gingembre/salle_5/objet_declencheur')->with('error', 'Objet introuvable');
        }

        return view('admin/salle_5/objet_declencheur/objetsDeclencheurForm', $data);
    }

    /**
     * Mise à jour d'un objet declencheur
     */
    public function objetDeclencheurUpdate($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'nom' => 'required|max_length[50]',
            'image' => 'required|max_length[50]',
            'x' => 'permit_empty|numeric|max_length[50]',
            'y' => 'permit_empty|numeric|max_length[50]',
            'width' => 'permit_empty|numeric|max_length[50]',
            'height' => 'permit_empty|numeric|max_length[50]',
            'zone_path' => 'max_length[80]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'image_path' => $this->request->getPost('image'),
            'x' => $this->request->getPost('x'),
            'y' => $this->request->getPost('y'),
            'width' => $this->request->getPost('width'),
            'height' => $this->request->getPost('height'),
            'zone_path' => $this->request->getPost('zone_path')? $this->request->getPost('zone_path') : null,
            'numero_activite' => $this->request->getPost('numero_activite'),

        ];

        $this->objetsDeclencheursModel->update($id, $data);
        return redirect()->to('/gingembre/salle_5/objet_declencheur')->with('success', 'Objet modifié avec succès');
    }

    /**
     * Suppression d'un objet declencheur
     */
    public function objetDeclencheurDelete($id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $this->objetsDeclencheursModel->delete($id);
        return redirect()->to('/gingembre/salle_5/objet_declencheur')->with('success', 'Objet supprimé avec succès');
    }

    //

    public function objetActiviteList(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data['objetsActivites'] = $this->objetsActiviteModel->getAllObjetsActivite();
        return view('admin/salle_5/objet_activite/ObjetsActiviteList', $data);
    }

    /**
     * Formulaire de création d'un objet Activite
     */
    public function objetActiviteCreate(): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data =[
            'objets' => $this->objetsModel->getAllObjets(),
            'activites' => $this->activiteModel->getActivitesBySalle($this->salleNumero),
        ];

        return view('admin/salle_5/objet_activite/objetsActiviteForm', $data);
    }

    /**
     * Enregistrement d'un nouvel objet Activite
     */
    public function objetActiviteStore(): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'numero_activite' => 'required|max_length[50]',
            'objet_id' => 'required|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'numero_activite' => $this->request->getPost('numero_activite'),
            'objet_id' => $this->request->getPost('objet_id'),
        ];

        $this->objetsActiviteModel->insert($data);
        return redirect()->to('/gingembre/salle_5/objet_activite')->with('success', 'Objet créé avec succès');
    }

    /**
     * Formulaire d'édition d'un objet Activite
     */
    public function objetActiviteEdit($numero, $id): string|RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $data =[
            'objets' => $this->objetsModel->getAllObjets(),
            'objetActivite' => $this->objetsActiviteModel->getObjetsActivite($numero, $id),
            'activites' => $this->activiteModel->getActivitesBySalle($this->salleNumero),
        ];

        if (!$data['objetActivite']) {
            return redirect()->to('/gingembre/salle_5/objet_activite')->with('error', 'Objet introuvable');
        }

        return view('admin/salle_5/objet_activite/objetsActiviteForm', $data);
    }

    /**
     * Mise à jour d'un objet Activite
     */
    public function objetActiviteUpdate($numero, $id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $rules = [
            'numero_activite' => 'required|max_length[50]',
            'objet_id' => 'required|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'numero_activite' => $this->request->getPost('numero_activite'),
            'objet_id' => $this->request->getPost('objet_id'),
        ];

        // Mise à jour avec clé composite
        $this->objetsActiviteModel
            ->where('numero_activite', $numero)
            ->where('objet_id', $id)
            ->set($data)
            ->update();

        return redirect()->to('/gingembre/salle_5/objet_activite')->with('success', 'Objet modifié avec succès');
    }

    /**
     * Suppression d'un objet Activite
     */
    public function objetActiviteDelete($numero, $id): RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        // Suppression avec clé composite
        $this->objetsActiviteModel
            ->where('numero_activite', $numero)
            ->where('objet_id', $id)
            ->delete();

        return redirect()
            ->to('/gingembre/salle_5/objet_activite')
            ->with('success', 'Objet supprimé avec succès');
    }




}
//
//    public function supprimerObjetDeclencheur($id)
//    {
//        $id = $this->request->getPost('id');
//        $section = $this->request->getPost('section') ?? 'objets_declencheurs';
//
//        if (!is_numeric($id)) {
//            return redirect()->back()->with('message', 'ID invalide');
//        }
//
//        $objetDeclencheurModel = new ObjetDeclencheurModel();
//
//        if (!$objetDeclencheurModel->find($id)) {
//            return redirect()->back()->with('message', 'Objet introuvable');
//        }
//
//        $objetDeclencheurModel->delete($id);
//
//        return redirect()->back()->with('message', 'Suppression réussie')->with('section', $section);
//    }
//
//    public function supprimerObjet($id)
//    {
//        $id = $this->request->getPost('id');
//        $section = $this->request->getPost('section') ?? 'objet';
//
//        if (!is_numeric($id)) {
//            return redirect()->back()->with('message', 'ID invalide');
//        }
//
//        $objetModel = new ObjetsModel();
//
//        if (!$objetModel->find($id)) {
//            return redirect()->back()->with('message', 'Objet introuvable');
//        }
//
//        $objetModel->delete($id);
//
//        return redirect()->back()->with('message', 'Suppression réussie')->with('section', $section);
//    }
//
//    public function supprimerEnigme($id)
//    {
//        $id = $this->request->getPost('id');
//        $section = $this->request->getPost('section') ?? 'enigmes';
//
//        if (!is_numeric($id)) {
//            return redirect()->back()->with('message', 'ID invalide');
//        }
//
//        $activiteModel = new ActiviteModel();
//
//        if (!$activiteModel->find($id)) {
//            return redirect()->back()->with('message', 'Objet introuvable');
//        }
//
//        $activiteModel->delete($id);
//
//        return redirect()->back()->with('message', 'Suppression réussie')->with('section', $section);
//    }
//
//    public function viewModifier($id)
//    {
//
//        $id = $this->request->getPost('id');
//        $section = $this->request->getPost('section') ?? 'enigmes';
//
//        if (!is_numeric($id)) {
//            return redirect()->back()->with('message', 'ID invalide');
//        }
//
//        if ($section == 'enigmes') {
//            $activiteModel = new ActiviteModel();
//            $result = $activiteModel->getActivite($id);
//
//        }elseif ($section == 'objet') {
//            $objetModel = new ObjetsModel();
//            $result = $objetModel->getObjetById($id);
//
//        }elseif ($section == 'objets_declencheurs') {
//            $objetDeclencheurModel = new ObjetDeclencheurModel();
//            $result = $objetDeclencheurModel->getObjetsDeclencheursById($id);
//
//        }
//        $data = [
//            'modifier' => $result,
//            'section' => $section
//        ];
//        return view('admin/salle_5/Modifier', $data);
//    }
//
//    public function viewAjouter($section = 'enigmes')
//    {
//        $data = ['section' => $section];
//        return view('admin/salle_5/Ajouter', $data);
//    }
//
//    public function validerModifObjet()
//    {
//        $model = new ObjetsModel();
//
//        $id = $this->request->getPost('id');
//        if (!$id) {
//            return redirect()->back()->with('error', 'ID manquant');
//        }
//
//        $hover = $this->request->getPost('hover') ? 1 : 0;
//
//        $data = [
//            'nom'        => $this->request->getPost('nom'),
//            'x'          => (int)$this->request->getPost('x'),
//            'y'          => (int)$this->request->getPost('y'),
//            'width'      => (int)$this->request->getPost('width'),
//            'height'     => (int)$this->request->getPost('height'),
//            'image'      => $this->request->getPost('image'),
//            'zone_path'  => $this->request->getPost('zone_path'),
//            'reponse'    => $this->request->getPost('nom'),
//            'drag'       => $this->request->getPost('drag') ? 'oui' : null,
//            'hover'      => $hover,
//            'cliquable'  => $this->request->getPost('cliquable') ? 'non' : null,
//            'ratio'      => $this->request->getPost('ratio') ? null : 'none',
//        ];
//
//        // TEXTE : uniquement si hover actif
//        if ($hover) {
//            $texteHover = trim($this->request->getPost('texteHover'));
//            $data['texte'] = $texteHover !== '' ? $texteHover : null;
//        } else {
//            $data['texte'] = null;
//        }
//
//        if (!$model->update($id, $data)) {
//            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
//        }
//
//        return redirect()
//            ->to('gingembre/salle_5#objet')
//            ->with('success', 'Objet modifié avec succès');
//    }
//
//    public function validerModifObjetDeclencheur()
//    {
//        $model = new ObjetDeclencheurModel();
//
//        $id = $this->request->getPost('id');
//        if (!$id) {
//            return redirect()->back()->with('error', 'ID manquant');
//        }
//
//        $data = [
//            'nom'              => $this->request->getPost('nom'),
//            'image_path'       => $this->request->getPost('image_path'),
//            'x'                => (int)$this->request->getPost('x'),
//            'y'                => (int)$this->request->getPost('y'),
//            'width'            => (int)$this->request->getPost('width'),
//            'height'           => (int)$this->request->getPost('height'),
//            'zone_path'        => $this->request->getPost('zone_path'),
//            'numero_activite'  => (int)$this->request->getPost('numero_activite'),
//        ];
//
//        if (!$model->update($id, $data)) {
//            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
//        }
//
//        return redirect()
//            ->to('gingembre/salle_5#objets_declencheurs')
//            ->with('success', 'Objet déclencheur modifié avec succès');
//    }
//
//    public function validerModifEnigme()
//    {
//        $model = new ActiviteModel();
//
//        $numero = $this->request->getPost('numero');
//        if (!$numero) {
//            return redirect()->back()->with('error', 'Numéro manquant');
//        }
//
//        $data = [
//            'libelle'             => $this->request->getPost('libelle'),
//            'image'               => $this->request->getPost('image'),
//            'type_numero'         => (int)$this->request->getPost('type_numero') ? 1 : null,
//            'explication_numero'  => (int)$this->request->getPost('explication_numero'),
//        ];
//
//        if (!$model->update($numero, $data)) {
//            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
//        }
//
//        return redirect()
//            ->to('gingembre/salle_5#enigmes')
//            ->with('success', 'Énigme modifiée avec succès');
//    }
//
//    public function validerAjoutObjet()
//    {
//        $model = new ObjetsModel();
//
//        $data = [
//            'nom'       => $this->request->getPost('nom'),
//            'x'         => $this->request->getPost('x'),
//            'y'         => $this->request->getPost('y'),
//            'width'     => $this->request->getPost('width'),
//            'height'    => $this->request->getPost('height'),
//            'image'     => $this->request->getPost('image'),
//            'zone_path' => $this->request->getPost('zone_path'),
//            'reponse'    => $this->request->getPost('nom'),
//            'drag'       => $this->request->getPost('drag') ? 'oui' : null,
//            'hover'      => $this->request->getPost('hover') ? 1 : 0,
//            'cliquable'  => $this->request->getPost('cliquable') ? 'non' : null,
//            'ratio'      => $this->request->getPost('ratio') ? null : 'none',
//            'texteHover'=> $this->request->getPost('texteHover'),
//        ];
//
//        $model->insert($data);
//
//        return redirect()->to('gingembre/salle_5#objet')->with('success', 'Objet ajouté avec succès !');
//    }
//
//    // Valide l'ajout d'une énigme
//    public function validerAjoutEnigme()
//    {
//        $model = new ActiviteModel();
//
//        $data = [
//            'libelle'           => $this->request->getPost('libelle'),
//            'image'             => $this->request->getPost('image'),
//            'salle_numero'      => 5,
//            'type_numero'       => $this->request->getPost('type_numero'),
//            'explication_numero'=> $this->request->getPost('explication_numero'),
//        ];
//
//        $model->insert($data);
//
//        return redirect()->to('gingembre/salle_5#enigmes')->with('success', 'Énigme ajoutée avec succès !');
//    }
//
//    // Valide l'ajout d'un objet déclencheur
//    public function validerAjoutObjetDeclencheur()
//    {
//        $model = new ObjetDeclencheurModel();
//
//        $data = [
//            'nom'             => $this->request->getPost('nom'),
//            'image_path'      => $this->request->getPost('image_path'),
//            'x'               => $this->request->getPost('x'),
//            'y'               => $this->request->getPost('y'),
//            'width'           => $this->request->getPost('width'),
//            'height'          => $this->request->getPost('height'),
//            'zone_path'       => $this->request->getPost('zone_path'),
//            'numero_activite' => $this->request->getPost('numero_activite'),
//        ];
//
//        $model->insert($data);
//
//        return redirect()->to('gingembre/salle_5#objets_declencheurs')->with('success', 'Objet déclencheur ajouté avec succès !');
//    }
//
//}