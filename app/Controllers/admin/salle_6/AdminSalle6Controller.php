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
    protected int $perPage = 10;

    /**
     * Vérifier si l'administrateur est connecté
     */
    protected function isAdminLoggedIn(): bool
    {
        return session()->get('admin_id') !== null;
    }

    /**
     * Rediriger vers la page de connexion si non authentifié
     */
    protected function checkAuth(): ?RedirectResponse
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
     * @param int|null $salleNumero Filtrer par salle (optionnel)
     * @return array Données paginées avec paramètres
     */
    protected function getPaginatedData(
        object $model,
        string $builderMethod,
        string $countMethod,
        string $defaultSort = 'numero',
        ?int $salleNumero = null
    ): array {
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

        // Compter le total avec recherche et salle
        $total = $model->$countMethod($salleNumero, $search);

        // Calculer l'offset
        $offset = max(0, ($page - 1) * $this->perPage);

        // Récupérer le builder avec recherche et tri
        $builder = $model->$builderMethod($salleNumero, $search, $sort, $order);

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
        if ($salleNumero !== null) {
            $queryParams['salle'] = $salleNumero;
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
            'queryString' => $queryString,
            'salleNumero' => $salleNumero
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
            'total_vpn' => (new VpnAdminModel())->countAll(),
            'total_wifi' => (new WifiAdminModel())->countAll(),
            'total_proposer_vpn' => (new ProposerVpnAdminModel())->countAll(),
            'total_proposer_wifi' => (new ProposerWifiAdminModel())->countAll(),
            'total_activite' => (new ActiviteAdminModel())->countActivites(6),
            'total_type' => (new TypeAdminModel())->countTypes(6),
            'total_salle' => (new SalleAdminModel())->countSalles(6),
            'total_indice' => (new IndiceAdminModel())->countIndices(6),
            'total_explication' => (new ExplicationAdminModel())->countExplications(6),
            'total_avoir_indice' => (new AvoirIndiceAdminModel())->countavoirIndices(6),
            'total_activite_message' => (new ActiviteMessageAdminModel())->countMessages(6),
        ];

        return view('admin/salle_6/dashboard', $data);
    }
}