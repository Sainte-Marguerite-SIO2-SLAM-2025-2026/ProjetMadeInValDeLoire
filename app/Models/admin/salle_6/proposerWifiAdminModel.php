<?php

namespace App\Models\admin\salle_6;

use CodeIgniter\Model;

class ProposerWifiAdminModel extends Model
{
    protected $table = 'proposer_wifi';
    protected $primaryKey = ['wifi_numero', 'activite_numero'];
    protected $allowedFields = ['wifi_numero', 'activite_numero', 'bonne_reponse', 'zone_clique'];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    // Utiliser la connexion par défaut (adminProjetMIVDL)
    protected $DBGroup = 'default';

    /**
     * Obtenir un Query Builder avec recherche, tri et jointure
     * @param string|null $search Terme de recherche
     * @param string $sort Colonne de tri
     * @param string $order Ordre (ASC/DESC)
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getPropositionsListBuilder(?string $search = null, string $sort = 'wifi_numero', string $order = 'ASC')
    {
        $builder = $this->builder();

        // Jointure pour afficher les infos du WiFi
        $builder->select('proposer_wifi.*, wifi.nom as wifi_nom')
            ->join('wifi', 'wifi.numero = proposer_wifi.wifi_numero', 'left');

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('proposer_wifi.wifi_numero', $search)
                ->orLike('proposer_wifi.activite_numero', $search)
                ->orLike('proposer_wifi.zone_clique', $search)
                ->orLike('wifi.nom', $search)
                ->groupEnd();
        }

        // Tri
        if ($sort === 'wifi_nom') {
            $builder->orderBy('wifi.nom', $order);
        } else {
            $builder->orderBy('proposer_wifi.' . $sort, $order);
        }

        return $builder;
    }

    /**
     * Créer une nouvelle proposition WiFi
     * @param array $data ['wifi_numero' => int, 'activite_numero' => int, 'bonne_reponse' => int, 'zone_clique' => string]
     * @return bool
     */
    public function createProposition(array $data): bool
    {
        // Validation
        if (!isset($data['wifi_numero']) || !isset($data['activite_numero']) ||
            !isset($data['bonne_reponse']) || empty($data['zone_clique'])) {
            return false;
        }

        // Vérifier que la relation n'existe pas déjà
        if ($this->propositionExists($data['wifi_numero'], $data['activite_numero'])) {
            log_message('warning', "La relation WiFi #{$data['wifi_numero']} - Activité #{$data['activite_numero']} existe déjà");
            return false;
        }

        return $this->insert($data) !== false;
    }

    /**
     * Mettre à jour une proposition WiFi existante
     * @param int $wifi_numero
     * @param int $activite_numero
     * @param array $data ['bonne_reponse' => int, 'zone_clique' => string]
     * @return bool
     */
    public function updateProposition(int $wifi_numero, int $activite_numero, array $data): bool
    {
        if (!$this->propositionExists($wifi_numero, $activite_numero)) {
            return false;
        }

        return $this->where('wifi_numero', $wifi_numero)
            ->where('activite_numero', $activite_numero)
            ->set($data)
            ->update();
    }

    /**
     * Supprimer une proposition WiFi
     * @param int $wifi_numero
     * @param int $activite_numero
     * @return bool
     */
    public function deleteProposition(int $wifi_numero, int $activite_numero): bool
    {
        return $this->where('wifi_numero', $wifi_numero)
            ->where('activite_numero', $activite_numero)
            ->delete();
    }

    /**
     * Récupérer une proposition spécifique
     * @param int $wifi_numero
     * @param int $activite_numero
     * @return array|null
     */
    public function getProposition(int $wifi_numero, int $activite_numero): ?array
    {
        return $this->where('wifi_numero', $wifi_numero)
            ->where('activite_numero', $activite_numero)
            ->first();
    }

    /**
     * Vérifier si une proposition existe
     * @param int $wifi_numero
     * @param int $activite_numero
     * @return bool
     */
    public function propositionExists(int $wifi_numero, int $activite_numero): bool
    {
        return $this->where('wifi_numero', $wifi_numero)
                ->where('activite_numero', $activite_numero)
                ->first() !== null;
    }

    /**
     * Supprimer toutes les propositions pour une activité donnée
     * @param int $activite_numero
     * @return bool
     */
    public function deleteByActivite(int $activite_numero): bool
    {
        return $this->where('activite_numero', $activite_numero)->delete();
    }

    /**
     * Supprimer toutes les propositions pour un WiFi donné
     * @param int $wifi_numero
     * @return bool
     */
    public function deleteByWifi(int $wifi_numero): bool
    {
        return $this->where('wifi_numero', $wifi_numero)->delete();
    }

    /**
     * Compter le nombre de bonnes/mauvaises réponses pour une activité
     * @param int $activite_numero
     * @return array ['bonnes' => int, 'mauvaises' => int]
     */
    public function countReponsesByActivite(int $activite_numero): array
    {
        $bonnes = $this->where('activite_numero', $activite_numero)
            ->where('bonne_reponse', 1)
            ->countAllResults();

        $mauvaises = $this->where('activite_numero', $activite_numero)
            ->where('bonne_reponse', 0)
            ->countAllResults();

        return [
            'bonnes' => $bonnes,
            'mauvaises' => $mauvaises
        ];
    }

    /**
     * Récupérer toutes les zones cliquées pour une activité
     * @param int $activite_numero
     * @return array
     */
    public function getZonesByActivite(int $activite_numero): array
    {
        $result = $this->select('zone_clique')
            ->where('activite_numero', $activite_numero)
            ->findAll();

        return array_unique(array_column($result, 'zone_clique'));
    }

    /**
     * Vérifier la cohérence des zones cliquées pour une activité
     * @param int $activite_numero
     * @return array
     */
    public function verifierCoherenceZones(int $activite_numero): array
    {
        $wifis = $this->where('activite_numero', $activite_numero)->findAll();
        $zones = $this->getZonesByActivite($activite_numero);

        return [
            'activite' => $activite_numero,
            'total_wifis' => count($wifis),
            'zones_differentes' => $zones,
            'coherent' => count($zones) === 1,
            'wifis' => $wifis
        ];
    }

    /**
     * Compter les propositions avec recherche (SANS jointure pour éviter les doublons)
     * @param string|null $search
     * @return int
     */
    public function countPropositions(?string $search = null): int
    {
        $builder = $this->db->table('proposer_wifi');

        if ($search) {
            // Sous-requête pour récupérer les IDs des WiFi correspondants
            $subQuery = $this->db->table('wifi')
                ->select('numero')
                ->like('nom', $search)
                ->getCompiledSelect();

            $builder->groupStart()
                ->like('wifi_numero', $search)
                ->orLike('activite_numero', $search)
                ->orLike('zone_clique', $search)
                ->orWhere("wifi_numero IN ($subQuery)", null, false)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}