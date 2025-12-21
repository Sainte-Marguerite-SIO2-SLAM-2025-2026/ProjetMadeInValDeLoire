<?php

namespace App\Controllers\admin\salle_6;

use App\Controllers\BaseController;
use App\Models\admin\salle_6\VpnAdminModel;
use App\Models\admin\salle_6\WifiAdminModel;
use App\Models\admin\salle_6\ProposerVpnAdminModel;
use App\Models\admin\salle_6\ProposerWifiAdminModel;
use App\Models\admin\commun\ActiviteAdminModel;
use App\Models\admin\commun\ExplicationAdminModel;
use App\Models\admin\commun\IndiceAdminModel;
use App\Models\admin\commun\AvoirIndiceAdminModel;
use App\Models\admin\commun\TypeAdminModel;
use App\Models\admin\commun\ActiviteMessageAdminModel;
use App\Models\admin\commun\SalleAdminModel;


use CodeIgniter\HTTP\RedirectResponse;

class AdminSalle6Controller extends BaseController
{
    protected VpnAdminModel $vpnModel;
    protected WifiAdminModel $wifiModel;
    protected ProposerVpnAdminModel $proposerVpnModel;
    protected ProposerWifiAdminModel $proposerWifiModel;
    protected ActiviteAdminModel $activiteModel;
    protected ExplicationAdminModel $explicationModel;
    protected IndiceAdminModel $indiceModel;
    protected AvoirIndiceAdminModel $avoirIndiceModel;
    protected TypeAdminModel $typeModel;
    protected ActiviteMessageAdminModel $activiteMessageModel;
    protected SalleAdminModel $salleModel;
    protected int $perPage = 10;

    public function __construct()
    {
        $this->vpnModel = new VpnAdminModel();
        $this->wifiModel = new WifiAdminModel();
        $this->proposerVpnModel = new ProposerVpnAdminModel();
        $this->proposerWifiModel = new ProposerWifiAdminModel();
        $this->activiteModel = new ActiviteAdminModel();
        $this->explicationModel = new ExplicationAdminModel();
        $this->indiceModel = new IndiceAdminModel();
        $this->avoirIndiceModel = new AvoirIndiceAdminModel();
        $this->typeModel = new TypeAdminModel();
        $this->activiteMessageModel = new ActiviteMessageAdminModel();
        $this->salleModel = new SalleAdminModel();
    }

    /**
     * Vérifier si l'administrateur est connecté
     */
    private function isAdminLoggedIn(): bool
    {
        return session()->get('admin_id') !== null;
    }

    /**
     * Rediriger vers la page de connexion si non authentifié
     */
    private function checkAuth(): ?RedirectResponse
    {
        if (!$this->isAdminLoggedIn()) {
            return redirect()->to('/gingembre');
        }
        return null;
    }

    /**
     * Méthode générique pour gérer la pagination, recherche et tri
     *
     * @param object $model Le modèle à utiliser
     * @param string $builderMethod Nom de la méthode qui retourne le builder
     * @param string $countMethod Nom de la méthode de comptage
     * @param string $defaultSort Colonne de tri par défaut
     * @return array Données paginées avec paramètres
     */
    private function getPaginatedData(object $model, string $builderMethod, string $countMethod, string $defaultSort = 'numero'): array
    {
        // Récupérer les paramètres de requête
        $search = $this->request->getGet('search') ?? '';
        $sort = $this->request->getGet('sort') ?? $defaultSort;
        $order = $this->request->getGet('order') ?? 'ASC';
        $page = (int)($this->request->getGet('page') ?? 1);

        // Validation de l'ordre
        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            $order = 'ASC';
        }

        // S'assurer que la page est au minimum 1
        if ($page < 1) {
            $page = 1;
        }

        // Compter le total avec recherche
        $total = $model->$countMethod($search);

        // Calculer l'offset
        $offset = max(0, ($page - 1) * $this->perPage);

        // Récupérer le builder avec recherche et tri
        $builder = $model->$builderMethod($search, $sort, $order);

        // Récupérer les données avec pagination
        $results = $builder->limit($this->perPage, $offset)->get()->getResultArray();

        // Créer le pager
        $pager = service('pager');

        // Construire la query string pour la pagination
        $queryParams = [];
        if ($search) {
            $queryParams['search'] = $search;
        }
        if ($sort !== $defaultSort) {
            $queryParams['sort'] = $sort;
        }
        if ($order !== 'ASC') {
            $queryParams['order'] = $order;
        }

        $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';

        return [
            'results' => $results,
            'pager' => $pager,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'total' => $total,
            'currentPage' => $page,
            'perPage' => $this->perPage,
            'queryString' => $queryString // Ajouter cette ligne
        ];
    }

    /**
     * Page d'accueil de l'administration Salle 6 (Dashboard)
     */
    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'total_vpn' => $this->vpnModel->countAll(),
            'total_wifi' => $this->wifiModel->countAll(),
            'total_proposer_vpn' => $this->proposerVpnModel->countAll(),
            'total_proposer_wifi' => $this->proposerWifiModel->countAll(),
            'total_activite' => $this->activiteModel->countActivites(6),
            'total_type' => $this->typeModel->countTypes(6),
            'total_salle' => $this->salleModel->countSalles(6),
            'total_indice' => $this->indiceModel->countIndices(6),
            'total_explication' => $this->explicationModel->countExplications(6),
            'total_avoirIndice' => $this->avoirIndiceModel->countavoirIndices(6),
            'total_activiteMessage' => $this->activiteMessageModel->countMessages(6),
        ];

        return view('admin/salle_6/dashboard', $data);
    }

    // ==================== VPN ====================

    public function vpnList(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->vpnModel,
            'getVpnListBuilder',
            'countVpns',
            'numero'
        );

        // Renommer 'results' en 'vpns' pour la vue
        $data['vpns'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/vpn/index', $data);
    }

    public function vpnCreate(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        return view('admin/salle_6/vpn/create');
    }

    public function vpnStore(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = ['libelle' => $this->request->getPost('libelle')];

        if ($this->vpnModel->createVpn($data)) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('success', 'VPN créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du VPN');
        }
    }

    public function vpnEdit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $vpn = $this->vpnModel->getVpnByNumero($id);
        if (!$vpn) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('error', 'VPN introuvable');
        }

        return view('admin/salle_6/vpn/edit', ['vpn' => $vpn]);
    }

    public function vpnUpdate($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = ['libelle' => $this->request->getPost('libelle')];

        if ($this->vpnModel->updateVpn($id, $data)) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('success', 'VPN modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function vpnDelete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->vpnModel->deleteVpn($id)) {
            return redirect()->to('/gingembre/salle_6/vpn')->with('success', 'VPN supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/vpn')->with('error', 'Impossible de supprimer ce VPN (utilisé dans des propositions)');
        }
    }

    // ==================== WIFI ====================

    public function wifiList(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->wifiModel,
            'getWifiListBuilder',
            'countWifis',
            'numero'
        );

        // Renommer 'results' en 'wifis' pour la vue
        $data['wifis'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/wifi/index', $data);
    }

    public function wifiCreate(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'chiffrement_types' => $this->wifiModel->getChiffrementTypes()
        ];

        return view('admin/salle_6/wifi/create', $data);
    }

    public function wifiStore(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[1]|max_length[255]',
            'public' => 'required|in_list[0,1]',
            'chiffrement' => 'required|in_list[OPEN,WEP,WPA,WPA2,WPA3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'public' => $this->request->getPost('public'),
            'chiffrement' => $this->request->getPost('chiffrement')
        ];

        if ($this->wifiModel->createWifi($data)) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('success', 'WiFi créé avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du WiFi');
        }
    }

    public function wifiEdit($id): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $wifi = $this->wifiModel->getWifiByNumero($id);
        if (!$wifi) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('error', 'WiFi introuvable');
        }

        $data = [
            'wifi' => $wifi,
            'chiffrement_types' => $this->wifiModel->getChiffrementTypes()
        ];

        return view('admin/salle_6/wifi/edit', $data);
    }

    public function wifiUpdate($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[1]|max_length[255]',
            'public' => 'required|in_list[0,1]',
            'chiffrement' => 'required|in_list[OPEN,WEP,WPA,WPA2,WPA3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'public' => $this->request->getPost('public'),
            'chiffrement' => $this->request->getPost('chiffrement')
        ];

        if ($this->wifiModel->updateWifi($id, $data)) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('success', 'WiFi modifié avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function wifiDelete($id): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->wifiModel->deleteWifi($id)) {
            return redirect()->to('/gingembre/salle_6/wifi')->with('success', 'WiFi supprimé avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/wifi')->with('error', 'Impossible de supprimer ce WiFi (utilisé dans des propositions)');
        }
    }

    // ==================== PROPOSITIONS VPN ====================

    public function proposerVpnList(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->proposerVpnModel,
            'getPropositionsListBuilder',
            'countPropositions',
            'vpn_numero'
        );

        // Renommer 'results' en 'propositions' pour la vue
        $data['propositions'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/proposerVpn/index', $data);
    }

    public function proposerVpnCreate(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'vpns' => $this->vpnModel->getAllVpns()
        ];
        return view('admin/salle_6/proposerVpn/create', $data);
    }

    public function proposerVpnStore(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'vpn_numero' => 'required|integer',
            'activite_numero' => 'required|integer',
            'bonne_reponse' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'vpn_numero' => $this->request->getPost('vpn_numero'),
            'activite_numero' => $this->request->getPost('activite_numero'),
            'bonne_reponse' => $this->request->getPost('bonne_reponse')
        ];

        if ($this->proposerVpnModel->createProposition($data)) {
            return redirect()->to('/gingembre/salle_6/proposerVpn')->with('success', 'Proposition VPN créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création (la proposition existe peut-être déjà)');
        }
    }

    public function proposerVpnEdit($vpn_numero, $activite_numero): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $proposition = $this->proposerVpnModel->getProposition($vpn_numero, $activite_numero);

        if (!$proposition) {
            return redirect()->to('/gingembre/salle_6/proposerVpn')->with('error', 'Proposition introuvable');
        }

        $data = [
            'proposition' => $proposition,
            'vpns' => $this->vpnModel->getAllVpns()
        ];
        return view('admin/salle_6/proposerVpn/edit', $data);
    }

    public function proposerVpnUpdate($vpn_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'bonne_reponse' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'bonne_reponse' => $this->request->getPost('bonne_reponse')
        ];

        if ($this->proposerVpnModel->updateProposition($vpn_numero, $activite_numero, $data)) {
            return redirect()->to('/gingembre/salle_6/proposerVpn')->with('success', 'Proposition modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function proposerVpnDelete($vpn_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->proposerVpnModel->deleteProposition($vpn_numero, $activite_numero)) {
            return redirect()->to('/gingembre/salle_6/proposerVpn')->with('success', 'Proposition supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/proposerVpn')->with('error', 'Erreur lors de la suppression');
        }
    }

    // ==================== PROPOSITIONS WIFI ====================

    public function proposerWifiList(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = $this->getPaginatedData(
            $this->proposerWifiModel,
            'getPropositionsListBuilder',
            'countPropositions',
            'wifi_numero'
        );

        // Renommer 'results' en 'propositions' pour la vue
        $data['propositions'] = $data['results'];
        unset($data['results']);

        return view('admin/salle_6/proposerWifi/index', $data);
    }

    public function proposerWifiCreate(): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $data = [
            'wifis' => $this->wifiModel->getAllWifis()
        ];
        return view('admin/salle_6/proposerWifi/create', $data);
    }

    public function proposerWifiStore(): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'wifi_numero' => 'required|integer',
            'activite_numero' => 'required|integer',
            'bonne_reponse' => 'required|in_list[0,1]',
            'zone_clique' => 'required|min_length[1]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'wifi_numero' => $this->request->getPost('wifi_numero'),
            'activite_numero' => $this->request->getPost('activite_numero'),
            'bonne_reponse' => $this->request->getPost('bonne_reponse'),
            'zone_clique' => $this->request->getPost('zone_clique')
        ];

        if ($this->proposerWifiModel->createProposition($data)) {
            return redirect()->to('/gingembre/salle_6/proposerWifi')->with('success', 'Proposition WiFi créée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création (la proposition existe peut-être déjà)');
        }
    }

    public function proposerWifiEdit($wifi_numero, $activite_numero): string|RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $proposition = $this->proposerWifiModel->getProposition($wifi_numero, $activite_numero);

        if (!$proposition) {
            return redirect()->to('/gingembre/salle_6/proposerWifi')->with('error', 'Proposition introuvable');
        }

        $data = [
            'proposition' => $proposition,
            'wifis' => $this->wifiModel->getAllWifis()
        ];
        return view('admin/salle_6/proposerWifi/edit', $data);
    }

    public function proposerWifiUpdate($wifi_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $rules = [
            'bonne_reponse' => 'required|in_list[0,1]',
            'zone_clique' => 'required|min_length[1]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'bonne_reponse' => $this->request->getPost('bonne_reponse'),
            'zone_clique' => $this->request->getPost('zone_clique')
        ];

        if ($this->proposerWifiModel->updateProposition($wifi_numero, $activite_numero, $data)) {
            return redirect()->to('/gingembre/salle_6/proposerWifi')->with('success', 'Proposition modifiée avec succès');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

    public function proposerWifiDelete($wifi_numero, $activite_numero): RedirectResponse
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($this->proposerWifiModel->deleteProposition($wifi_numero, $activite_numero)) {
            return redirect()->to('/gingembre/salle_6/proposerWifi')->with('success', 'Proposition supprimée avec succès');
        } else {
            return redirect()->to('/gingembre/salle_6/proposerWifi')->with('error', 'Erreur lors de la suppression');
        }
    }
}