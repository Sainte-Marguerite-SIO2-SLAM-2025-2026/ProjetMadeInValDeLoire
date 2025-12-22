<?php

namespace App\Models\admin\salle_6;

use CodeIgniter\Model;

class WifiAdminModel extends Model
{
    protected $table = 'wifi';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['nom', 'public', 'chiffrement'];
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
    public function getWifiListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'numero', string $order = 'ASC')
    {
        $builder = $this->builder();

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('numero', $search)
                ->orLike('nom', $search)
                ->orLike('chiffrement', $search)
                ->groupEnd();
        }

        // Tri
        $builder->orderBy($sort, $order);

        return $builder;
    }

    /**
     * Créer un nouveau WiFi
     * @param array $data ['nom' => string, 'public' => int, 'chiffrement' => string]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createWifi(array $data)
    {
        // Validation basique
        if (empty($data['nom']) || !isset($data['public']) || empty($data['chiffrement'])) {
            return false;
        }

        // Valider le type de chiffrement
        if (!$this->isValidChiffrement($data['chiffrement'])) {
            log_message('error', "Type de chiffrement invalide : {$data['chiffrement']}");
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour un WiFi existant
     * @param int $numero
     * @param array $data ['nom' => string, 'public' => int, 'chiffrement' => string]
     * @return bool
     */
    public function updateWifi(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Valider le type de chiffrement si présent
        if (isset($data['chiffrement']) && !$this->isValidChiffrement($data['chiffrement'])) {
            log_message('error', "Type de chiffrement invalide : {$data['chiffrement']}");
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer un WiFi (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteWifi(int $numero): bool
    {
        // Vérifier si le WiFi existe
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier si le WiFi est utilisé dans proposer_wifi
        if ($this->isWifiUsed($numero)) {
            log_message('warning', "Impossible de supprimer le WiFi #{$numero} : utilisé dans des propositions");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si un WiFi est utilisé dans des propositions
     * @param int $numero
     * @return bool
     */
    public function isWifiUsed(int $numero): bool
    {
        $db = \Config\Database::connect('default');
        $builder = $db->table('proposer_wifi');
        $count = $builder->where('wifi_numero', $numero)->countAllResults();

        return $count > 0;
    }

    /**
     * Récupérer un WiFi par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getWifiByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupérer tous les WiFi (pour les listes déroulantes)
     * @return array
     */
    public function getAllWifis(): array
    {
        return $this->orderBy('nom', 'ASC')->findAll();
    }

    /**
     * Récupérer les types de chiffrement valides
     * @return array
     */
    public function getChiffrementTypes(): array
    {
        return ['OPEN', 'WEP', 'WPA', 'WPA2', 'WPA3'];
    }

    /**
     * Valider un type de chiffrement
     * @param string $chiffrement
     * @return bool
     */
    public function isValidChiffrement(string $chiffrement): bool
    {
        return in_array($chiffrement, $this->getChiffrementTypes());
    }

    /**
     * Compter les WiFi avec recherche
     * @param int|null $salleNumero Numéro de salle (non utilisé pour cette table)
     * @param string|null $search Terme de recherche
     * @return int
     */
    public function countWifis(?int $salleNumero = null, ?string $search = null): int
    {
        $builder = $this->builder();

        if ($search) {
            $builder->groupStart()
                ->like('numero', $search)
                ->orLike('nom', $search)
                ->orLike('chiffrement', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}