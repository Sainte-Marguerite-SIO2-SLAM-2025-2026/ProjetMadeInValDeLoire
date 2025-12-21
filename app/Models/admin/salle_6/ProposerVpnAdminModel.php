<?php

namespace App\Models\admin\salle_6;

use CodeIgniter\Model;

class ProposerVpnAdminModel extends Model
{
    protected $table = 'proposer_vpn';
    protected $primaryKey = ['vpn_numero', 'activite_numero'];
    protected $allowedFields = ['vpn_numero', 'activite_numero', 'bonne_reponse'];
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
    public function getPropositionsListBuilder(?string $search = null, string $sort = 'vpn_numero', string $order = 'ASC')
    {
        $builder = $this->builder();

        // Jointure pour afficher le libellé du VPN
        $builder->select('proposer_vpn.*, vpn.libelle as vpn_libelle')
            ->join('vpn', 'vpn.numero = proposer_vpn.vpn_numero', 'left');

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('proposer_vpn.vpn_numero', $search)
                ->orLike('proposer_vpn.activite_numero', $search)
                ->orLike('vpn.libelle', $search)
                ->groupEnd();
        }

        // Tri
        if ($sort === 'vpn_libelle') {
            $builder->orderBy('vpn.libelle', $order);
        } else {
            $builder->orderBy('proposer_vpn.' . $sort, $order);
        }

        return $builder;
    }

    /**
     * Créer une nouvelle proposition VPN
     * @param array $data ['vpn_numero' => int, 'activite_numero' => int, 'bonne_reponse' => int]
     * @return bool
     */
    public function createProposition(array $data): bool
    {
        // Validation
        if (!isset($data['vpn_numero']) || !isset($data['activite_numero']) || !isset($data['bonne_reponse'])) {
            return false;
        }

        // Vérifier que la relation n'existe pas déjà
        if ($this->propositionExists($data['vpn_numero'], $data['activite_numero'])) {
            log_message('warning', "La relation VPN #{$data['vpn_numero']} - Activité #{$data['activite_numero']} existe déjà");
            return false;
        }

        return $this->insert($data) !== false;
    }

    /**
     * Mettre à jour une proposition VPN existante
     * @param int $vpn_numero
     * @param int $activite_numero
     * @param array $data ['bonne_reponse' => int]
     * @return bool
     */
    public function updateProposition(int $vpn_numero, int $activite_numero, array $data): bool
    {
        if (!$this->propositionExists($vpn_numero, $activite_numero)) {
            return false;
        }

        return $this->where('vpn_numero', $vpn_numero)
            ->where('activite_numero', $activite_numero)
            ->set($data)
            ->update();
    }

    /**
     * Supprimer une proposition VPN
     * @param int $vpn_numero
     * @param int $activite_numero
     * @return bool
     */
    public function deleteProposition(int $vpn_numero, int $activite_numero): bool
    {
        return $this->where('vpn_numero', $vpn_numero)
            ->where('activite_numero', $activite_numero)
            ->delete();
    }

    /**
     * Récupérer une proposition spécifique
     * @param int $vpn_numero
     * @param int $activite_numero
     * @return array|null
     */
    public function getProposition(int $vpn_numero, int $activite_numero): ?array
    {
        return $this->where('vpn_numero', $vpn_numero)
            ->where('activite_numero', $activite_numero)
            ->first();
    }

    /**
     * Vérifier si une proposition existe
     * @param int $vpn_numero
     * @param int $activite_numero
     * @return bool
     */
    public function propositionExists(int $vpn_numero, int $activite_numero): bool
    {
        return $this->where('vpn_numero', $vpn_numero)
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
     * Supprimer toutes les propositions pour un VPN donné
     * @param int $vpn_numero
     * @return bool
     */
    public function deleteByVpn(int $vpn_numero): bool
    {
        return $this->where('vpn_numero', $vpn_numero)->delete();
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
     * Compter les propositions avec recherche (SANS jointure pour éviter les doublons)
     * @param string|null $search
     * @return int
     */
    public function countPropositions(?string $search = null): int
    {
        $builder = $this->db->table('proposer_vpn');

        if ($search) {
            // Sous-requête pour récupérer les IDs des VPN correspondants
            $subQuery = $this->db->table('vpn')
                ->select('numero')
                ->like('libelle', $search)
                ->getCompiledSelect();

            $builder->groupStart()
                ->like('vpn_numero', $search)
                ->orLike('activite_numero', $search)
                ->orWhere("vpn_numero IN ($subQuery)", null, false)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}