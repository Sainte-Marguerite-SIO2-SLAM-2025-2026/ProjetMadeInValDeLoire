<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class SalleAdminModel extends Model
{
    protected $table = 'salle';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle', 'bouton', 'intro_salle'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $DBGroup = 'default';

    /**
     * Obtenir un Query Builder avec recherche et tri
     * @param int|null $salleNumero Numéro de salle (non utilisé pour cette table)
     * @param string|null $search Terme de recherche
     * @param string $sort Colonne de tri
     * @param string $order Ordre (ASC/DESC)
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getSalleListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'numero', string $order = 'ASC')
    {
        $builder = $this->builder();

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('numero', $search)
                ->orLike('libelle', $search)
                ->orLike('bouton', $search)
                ->orLike('intro_salle', $search)
                ->groupEnd();
        }

        // Tri - Validation des colonnes autorisées
        $allowedSorts = ['numero', 'libelle', 'bouton', 'intro_salle'];
        if (in_array($sort, $allowedSorts)) {
            $builder->orderBy($sort, $order);
        } else {
            $builder->orderBy('numero', 'ASC');
        }

        return $builder;
    }

    /**
     * Créer une nouvelle salle
     * @param array $data ['libelle' => string, 'bouton' => string, 'intro_salle' => string]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createSalle(array $data)
    {
        // Validation basique
        if (empty($data['libelle']) || empty($data['bouton'])) {
            return false;
        }

        // Si un numéro spécifique est fourni, vérifier qu'il n'existe pas déjà
        if (isset($data['numero']) && $this->find($data['numero'])) {
            log_message('error', "La salle #{$data['numero']} existe déjà");
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour une salle existante
     * @param int $numero
     * @param array $data ['libelle' => string, 'bouton' => string, 'intro_salle' => string]
     * @return bool
     */
    public function updateSalle(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer une salle (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteSalle(int $numero): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier si la salle est utilisée dans d'autres tables
        if ($this->isSalleUsed($numero)) {
            log_message('warning', "Impossible de supprimer la salle #{$numero} : utilisée dans d'autres tables");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si une salle est utilisée
     * @param int $numero
     * @return bool
     */
    public function isSalleUsed(int $numero): bool
    {
        $db = \Config\Database::connect('default');

        // Vérifier dans activite
        $activiteCount = $db->table('activite')->where('salle_numero', $numero)->countAllResults();
        if ($activiteCount > 0) {
            return true;
        }

        // Vérifier dans mascotte
        $mascotteCount = $db->table('mascotte')->where('salle_numero', $numero)->countAllResults();
        if ($mascotteCount > 0) {
            return true;
        }

        return false;
    }

    /**
     * Récupérer une salle par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getSalleByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupérer toutes les salles (pour les listes déroulantes)
     * @return array
     */
    public function getAllSalles(): array
    {
        return $this->orderBy('numero', 'ASC')->findAll();
    }

    /**
     * Compter les salles avec recherche
     * @param int|null $salleNumero Numéro de salle (non utilisé pour cette table)
     * @param string|null $search Terme de recherche
     * @return int
     */
    public function countSalles(?int $salleNumero = null, ?string $search = null): int
    {
        $builder = $this->builder();

        if ($search) {
            $builder->groupStart()
                ->like('numero', $search)
                ->orLike('libelle', $search)
                ->orLike('bouton', $search)
                ->orLike('intro_salle', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    /**
     * Récupérer le nombre d'activités par salle
     * @param int $numero
     * @return int
     */
    public function getActiviteCountBySalle(int $numero): int
    {
        $db = \Config\Database::connect('default');

        // Déterminer la plage pour la salle
        if ($numero === 3) {
            $min = 1;
            $max = 399;
        } else {
            $min = $numero * 100;
            $max = ($numero * 100) + 99;
        }

        return $db->table('activite')
            ->where('numero >=', $min)
            ->where('numero <=', $max)
            ->countAllResults();
    }

    /**
     * Récupérer les statistiques d'utilisation par salle
     * @return array
     */
    public function getUsageStats(): array
    {
        $salles = $this->findAll();
        $stats = [];

        foreach ($salles as $salle) {
            $stats[] = [
                'numero' => $salle['numero'],
                'libelle' => $salle['libelle'],
                'activite_count' => $this->getActiviteCountBySalle($salle['numero']),
                'mascotte_count' => $this->getMascotteCountBySalle($salle['numero'])
            ];
        }

        return $stats;
    }

    /**
     * Récupérer le nombre de mascottes par salle
     * @param int $numero
     * @return int
     */
    protected function getMascotteCountBySalle(int $numero): int
    {
        $db = \Config\Database::connect('default');
        return $db->table('mascotte')->where('salle_numero', $numero)->countAllResults();
    }

    /**
     * Vérifier si un numéro de salle existe
     * @param int $numero
     * @return bool
     */
    public function salleExists(int $numero): bool
    {
        return $this->find($numero) !== null;
    }

    /**
     * Récupérer la salle avec ses statistiques
     * @param int $numero
     * @return array|null
     */
    public function getSalleWithStats(int $numero): ?array
    {
        $salle = $this->find($numero);

        if (!$salle) {
            return null;
        }

        $salle['activite_count'] = $this->getActiviteCountBySalle($numero);
        $salle['mascotte_count'] = $this->getMascotteCountBySalle($numero);

        return $salle;
    }

    /**
     * Récupérer le prochain numéro de salle disponible
     * @return int
     */
    public function getNextNumero(): int
    {
        $lastSalle = $this->orderBy('numero', 'DESC')->first();

        if ($lastSalle) {
            return $lastSalle['numero'] + 1;
        }

        return 1;
    }
}