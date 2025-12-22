<?php

namespace App\Models\admin\salle_6;

use CodeIgniter\Model;

class VpnAdminModel extends Model
{
    protected $table = 'vpn';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle'];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    // Utiliser la connexion par défaut (adminProjetMIVDL)
    protected $DBGroup = 'default';

    /**
     * Obtenir un Query Builder avec recherche et tri
     * @param int|null $salleNumero Numéro de salle (non utilisé pour cette table)
     * @param string|null $search Terme de recherche
     * @param string $sort Colonne de tri
     * @param string $order Ordre (ASC/DESC)
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getVpnListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'numero', string $order = 'ASC')
    {
        $builder = $this->builder();

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('numero', $search)
                ->orLike('libelle', $search)
                ->groupEnd();
        }

        // Tri
        $builder->orderBy($sort, $order);

        return $builder;
    }

    /**
     * Créer un nouveau VPN
     * @param array $data ['libelle' => string]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createVpn(array $data)
    {
        if (empty($data['libelle'])) {
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour un VPN existant
     * @param int $numero
     * @param array $data ['libelle' => string]
     * @return bool
     */
    public function updateVpn(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer un VPN (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteVpn(int $numero): bool
    {
        // Vérifier si le VPN existe
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier si le VPN est utilisé dans proposer_vpn
        if ($this->isVpnUsed($numero)) {
            log_message('warning', "Impossible de supprimer le VPN #{$numero} : utilisé dans des propositions");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si un VPN est utilisé dans des propositions
     * @param int $numero
     * @return bool
     */
    public function isVpnUsed(int $numero): bool
    {
        $db = \Config\Database::connect('default');
        $builder = $db->table('proposer_vpn');
        $count = $builder->where('vpn_numero', $numero)->countAllResults();

        return $count > 0;
    }

    /**
     * Récupérer un VPN par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getVpnByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupérer tous les VPN (pour les listes déroulantes)
     * @return array
     */
    public function getAllVpns(): array
    {
        return $this->orderBy('libelle', 'ASC')->findAll();
    }

    /**
     * Compter les VPN avec recherche
     * @param int|null $salleNumero Numéro de salle (non utilisé pour cette table)
     * @param string|null $search Terme de recherche
     * @return int
     */
    public function countVpns(?int $salleNumero = null, ?string $search = null): int
    {
        $builder = $this->builder();

        if ($search) {
            $builder->groupStart()
                ->like('numero', $search)
                ->orLike('libelle', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}