<?php
namespace App\Controllers\admin\salle_5;

use App\Controllers\BaseController;
use App\Models\salle_5\ActiviteModel;
use App\Models\salle_5\ObjetDeclencheurModel;
use App\Models\salle_5\ObjetsModel;

class Salle5Controller extends BaseController
{

    public function supprimerObjetDeclencheur($id)
    {
        $id = $this->request->getPost('id');
        $section = $this->request->getPost('section') ?? 'objets_declencheurs';

        if (!is_numeric($id)) {
            return redirect()->back()->with('message', 'ID invalide');
        }

        $objetDeclencheurModel = new ObjetDeclencheurModel();

        if (!$objetDeclencheurModel->find($id)) {
            return redirect()->back()->with('message', 'Objet introuvable');
        }

        $objetDeclencheurModel->delete($id);

        return redirect()->back()->with('message', 'Suppression réussie')->with('section', $section);
    }

    public function supprimerObjet($id)
    {
        $id = $this->request->getPost('id');
        $section = $this->request->getPost('section') ?? 'objets';

        if (!is_numeric($id)) {
            return redirect()->back()->with('message', 'ID invalide');
        }

        $objetModel = new ObjetsModel();

        if (!$objetModel->find($id)) {
            return redirect()->back()->with('message', 'Objet introuvable');
        }

        $objetModel->delete($id);

        return redirect()->back()->with('message', 'Suppression réussie')->with('section', $section);
    }

    public function supprimerEnigme($id)
    {
        $id = $this->request->getPost('id');
        $section = $this->request->getPost('section') ?? 'enigmes';

        if (!is_numeric($id)) {
            return redirect()->back()->with('message', 'ID invalide');
        }

        $activiteModel = new ActiviteModel();

        if (!$activiteModel->find($id)) {
            return redirect()->back()->with('message', 'Objet introuvable');
        }

        $activiteModel->delete($id);

        return redirect()->back()->with('message', 'Suppression réussie')->with('section', $section);
    }

    public function viewModifier($id)
    {

        $id = $this->request->getPost('id');
        $section = $this->request->getPost('section') ?? 'enigmes';

        if (!is_numeric($id)) {
            return redirect()->back()->with('message', 'ID invalide');
        }

        if ($section == 'enigmes') {
            $activiteModel = new ActiviteModel();
            $result = $activiteModel->getActivite($id);

        }elseif ($section == 'objets') {
            $objetModel = new ObjetsModel();
            $result = $objetModel->getObjetById($id);

        }elseif ($section == 'objets_declencheurs') {
            $objetDeclencheurModel = new ObjetDeclencheurModel();
            $result = $objetDeclencheurModel->getObjetsDeclencheursById($id);

        }
        $data = [
            'modifier' => $result,
            'section' => $section
        ];
        return view('admin/salle_5/Modifier', $data);
    }

    public function viewAjouter($section = 'enigmes')
    {
        $data = ['section' => $section];
        return view('admin/salle_5/Ajouter', $data);
    }

    public function validerModifObjet()
    {
        $model = new ObjetsModel();

        $id = $this->request->getPost('id');
        if (!$id) {
            return redirect()->back()->with('error', 'ID manquant');
        }

        $hover = $this->request->getPost('hover') ? 1 : 0;

        $data = [
            'nom'        => $this->request->getPost('nom'),
            'x'          => (int)$this->request->getPost('x'),
            'y'          => (int)$this->request->getPost('y'),
            'width'      => (int)$this->request->getPost('width'),
            'height'     => (int)$this->request->getPost('height'),
            'image'      => $this->request->getPost('image'),
            'zone_path'  => $this->request->getPost('zone_path'),
            'reponse'    => $this->request->getPost('nom'),
            'drag'       => $this->request->getPost('drag') ? 'oui' : null,
            'hover'      => $hover,
            'cliquable'  => $this->request->getPost('cliquable') ? 'non' : null,
            'ratio'      => $this->request->getPost('ratio') ? null : 'none',
        ];

        // TEXTE : uniquement si hover actif
        if ($hover) {
            $texteHover = trim($this->request->getPost('texteHover'));
            $data['texte'] = $texteHover !== '' ? $texteHover : null;
        } else {
            $data['texte'] = null;
        }

        if (!$model->update($id, $data)) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
        }

        return redirect()
            ->to('gingembre/salle_5#objets')
            ->with('success', 'Objet modifié avec succès');
    }

    public function validerModifObjetDeclencheur()
    {
        $model = new ObjetDeclencheurModel();

        $id = $this->request->getPost('id');
        if (!$id) {
            return redirect()->back()->with('error', 'ID manquant');
        }

        $data = [
            'nom'              => $this->request->getPost('nom'),
            'image_path'       => $this->request->getPost('image_path'),
            'x'                => (int)$this->request->getPost('x'),
            'y'                => (int)$this->request->getPost('y'),
            'width'            => (int)$this->request->getPost('width'),
            'height'           => (int)$this->request->getPost('height'),
            'zone_path'        => $this->request->getPost('zone_path'),
            'numero_activite'  => (int)$this->request->getPost('numero_activite'),
        ];

        if (!$model->update($id, $data)) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
        }

        return redirect()
            ->to('gingembre/salle_5#objets_declencheurs')
            ->with('success', 'Objet déclencheur modifié avec succès');
    }

    public function validerModifEnigme()
    {
        $model = new ActiviteModel();

        $numero = $this->request->getPost('numero');
        if (!$numero) {
            return redirect()->back()->with('error', 'Numéro manquant');
        }

        $data = [
            'libelle'             => $this->request->getPost('libelle'),
            'image'               => $this->request->getPost('image'),
            'type_numero'         => (int)$this->request->getPost('type_numero') ? 1 : null,
            'explication_numero'  => (int)$this->request->getPost('explication_numero'),
        ];

        if (!$model->update($numero, $data)) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
        }

        return redirect()
            ->to('gingembre/salle_5#enigmes')
            ->with('success', 'Énigme modifiée avec succès');
    }

    public function validerAjoutObjet()
    {
        $model = new ObjetsModel();

        $data = [
            'nom'       => $this->request->getPost('nom'),
            'x'         => $this->request->getPost('x'),
            'y'         => $this->request->getPost('y'),
            'width'     => $this->request->getPost('width'),
            'height'    => $this->request->getPost('height'),
            'image'     => $this->request->getPost('image'),
            'zone_path' => $this->request->getPost('zone_path'),
            'reponse'    => $this->request->getPost('nom'),
            'drag'       => $this->request->getPost('drag') ? 'oui' : null,
            'hover'      => $this->request->getPost('hover') ? 1 : 0,
            'cliquable'  => $this->request->getPost('cliquable') ? 'non' : null,
            'ratio'      => $this->request->getPost('ratio') ? null : 'none',
            'texteHover'=> $this->request->getPost('texteHover'),
        ];

        $model->insert($data);

        return redirect()->to('gingembre/salle_5#objets')->with('success', 'Objet ajouté avec succès !');
    }

    // Valide l'ajout d'une énigme
    public function validerAjoutEnigme()
    {
        $model = new ActiviteModel();

        $data = [
            'libelle'           => $this->request->getPost('libelle'),
            'image'             => $this->request->getPost('image'),
            'salle_numero'      => 5,
            'type_numero'       => $this->request->getPost('type_numero'),
            'explication_numero'=> $this->request->getPost('explication_numero'),
        ];

        $model->insert($data);

        return redirect()->to('gingembre/salle_5#enigmes')->with('success', 'Énigme ajoutée avec succès !');
    }

    // Valide l'ajout d'un objet déclencheur
    public function validerAjoutObjetDeclencheur()
    {
        $model = new ObjetDeclencheurModel();

        $data = [
            'nom'             => $this->request->getPost('nom'),
            'image_path'      => $this->request->getPost('image_path'),
            'x'               => $this->request->getPost('x'),
            'y'               => $this->request->getPost('y'),
            'width'           => $this->request->getPost('width'),
            'height'          => $this->request->getPost('height'),
            'zone_path'       => $this->request->getPost('zone_path'),
            'numero_activite' => $this->request->getPost('numero_activite'),
        ];

        $model->insert($data);

        return redirect()->to('gingembre/salle_5#objets_declencheurs')->with('success', 'Objet déclencheur ajouté avec succès !');
    }

}