<?php
namespace App\Controllers\salle_3;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\salle_3\MailModel;

class MailController extends BaseController
{
    protected $mailModel;
    protected $mascotte;

    public function __construct()
    {
        $this->mascotte = new MascotteModel();
        $this->mailModel = new MailModel();
    }

    // Afficher le formulaire
    public function create()
    {
        return view('salle_3/BackendListeMailsSalle3');
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
            return redirect()->to('/salle_3/mails')->with('success', 'Mail enregistré avec succès');
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
        $data['mascotte'] = $this->mascotte->getMascottes();
        return view('salle_3/BackendMailsSalle3', $data);
    }

    // Afficher un mail spécifique
    public function show($id)
    {
        $data['mail'] = $this->mailModel->find($id);
        $data['mascotte'] = $this->mascotte->getMascottes();

        if (!$data['mail']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mail non trouvé');
        }

        return view('salle_3/ShowMailSalle3', $data);
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $data['mail'] = $this->mailModel->find($id);
        $data['mascotte'] = $this->mascotte->getMascottes();

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