<?php
namespace App\Controllers\admin\salle_6;

use App\Models\admin\commun\AvoirIndiceAdminModel;
use App\Models\admin\commun\ActiviteAdminModel;
use App\Models\admin\commun\IndiceAdminModel;
use CodeIgniter\HTTP\RedirectResponse;

class AvoirIndiceController extends AdminSalle6Controller
{
    protected AvoirIndiceAdminModel $avoirIndiceModel;
    protected ActiviteAdminModel $activiteModel;
    protected IndiceAdminModel $indiceModel;
    protected const SALLE_NUMERO = 6;

    public function __construct()
    {
        $this->avoirIndiceModel = new AvoirIndiceAdminModel();
        $this->activiteModel = new ActiviteAdminModel();
        $this->indiceModel = new IndiceAdminModel();
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Force la salle 6
        $data = $this->getPaginatedData(
            $this->avoirIndiceModel,
            'getAvoirIndiceListBuilder',
            'countAvoirIndices',
            'activite_numero',
            self::SALLE_NUMERO
        );

        $data['associations'] = $data['results'];
        unset($data['results']);
        $data['current_salle'] = self::SALLE_NUMERO;

        return view('admin/salle_6/avoirIndice/index', $data);
    }

    public function Create(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Récupérer uniquement les activités et indices de la salle 6
        $activites = $this->activiteModel->getActivitesBySalle(self::SALLE_NUMERO);
        $indices = $this->indiceModel->getIndicesBySalle(self::SALLE_NUMERO);

        $data = [
            'activites' => $activites,
            'indices' => $indices,
            'current_salle' => self::SALLE_NUMERO
        ];

        return view('admin/salle_6/avoirIndice/create', $data);
    }

    public function Store(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'activite_numero' => 'required|integer',
            'indice_numero' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $activiteNumero = $this->request->getPost('activite_numero');
        $indiceNumero = $this->request->getPost('indice_numero');

        // Vérifier que l'activité et l'indice appartiennent à la salle 6 (600-699)
        if ($activiteNumero < 600 || $activiteNumero > 699 || $indiceNumero < 600 || $indiceNumero > 699) {
            return redirect()->back()->withInput()->with('error', 'Activité ou indice non accessible pour la salle 6');
        }

        $data = [
            'activite_numero' => $activiteNumero,
            'indice_numero' => $indiceNumero
        ];

        if ($this->avoirIndiceModel->createAvoirIndice($data)) {
            return redirect()->to('/gingembre/salle_6/avoir-indice')->with('success', 'Association créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création (l\'association existe peut-être déjà)');
        }
    }

    public function Delete($activiteNumero, $indiceNumero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Vérifier que l'activité et l'indice appartiennent à la salle 6
        if ($activiteNumero < 600 || $activiteNumero > 699 || $indiceNumero < 600 || $indiceNumero > 699) {
            return redirect()->to('/gingembre/salle_6/avoir-indice')->with('error', 'Association non accessible');
        }

        if ($this->avoirIndiceModel->deleteAvoirIndice($activiteNumero, $indiceNumero)) {
            return redirect()->to('/gingembre/salle_6/avoir-indice')->with('success', 'Association supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/avoir-indice')->with('error', 'Erreur lors de la suppression');
        }
    }
}
