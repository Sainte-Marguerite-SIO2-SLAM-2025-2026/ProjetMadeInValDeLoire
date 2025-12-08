<?php
namespace App\Controllers\salle_3;

use App\Controllers\BaseController;
use App\Models\salle_3\MailModel;

class MailController extends BaseController
{
    protected $mailModel;

    public function __construct()
    {
        $this->mailModel = new MailModel();
    }


// Page listant les mails pour édition
    public function listEdit()
    {
        $data['mails'] = $this->mailModel->findAll();
        return view('salle_3/ListEditMailsSalle3', $data);
    }

// Page listant les mails pour suppression
    public function listDelete()
    {
        $data['mails'] = $this->mailModel->findAll();
        return view('salle_3/ListDeleteMailsSalle3', $data);
    }

    // Afficher le formulaire
    public function create()
    {
        return view('admin/salle_3/AjoutAdminSalle3');
    }

    // Enregistrer un nouveau mail
    public function store()
    {
        $data = [
            'expediteur' => $this->request->getPost('expediteur'),
            'objet'      => $this->request->getPost('objet'),
            'contenu'    => $this->request->getPost('contenu'),
            'difficulte' => $this->request->getPost('difficulte') ?: null,
            'phishing'   => $this->request->getPost('phishing'),
        ];

        if ($this->mailModel->insert($data)) {
            return redirect()->to('/salle_3')->with('success', 'Mail enregistré avec succès');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->mailModel->errors());
        }
    }

    // Lister tous les mails
    public function index()
    {
        $data['mails'] = $this->mailModel->findAll();
        return view('admin/salle_3/ListeMailsAdminSalle3', $data);
    }

    // Afficher un mail spécifique
    public function show($id)
    {
        $data['mail'] = $this->mailModel->find($id);

        if (!$data['mail']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mail non trouvé');
        }

        return view('salle_3/ShowMailSalle3', $data);
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $data['mail'] = $this->mailModel->find($id);

        if (!$data['mail']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mail non trouvé');
        }

        return view('salle_3/EditMailSalle3', $data);
    }

    // Mettre à jour un mail
    public function update($id)
    {
        $data = [
            'expediteur' => $this->request->getPost('expediteur'),
            'objet'      => $this->request->getPost('objet'),
            'contenu'    => $this->request->getPost('contenu'),
            'difficulte' => $this->request->getPost('difficulte') ?: null,
            'phishing'   => $this->request->getPost('phishing'),
        ];

        if ($this->mailModel->update($id, $data)) {
            return redirect()->to('/salle_3/mails')->with('success', 'Mail mis à jour avec succès');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->mailModel->errors());
        }
    }

    // Supprimer un mail
    public function delete($id)
    {
        if ($this->mailModel->delete($id)) {
            return redirect()->to('/salle_3/mails')->with('success', 'Mail supprimé avec succès');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la suppression');
        }
    }
}