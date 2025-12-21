<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class DifficulteAdminModel extends Model
{
    protected $table = 'difficulte';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $DBGroup = 'default';

    /**
     * Note: La table difficulté est commune à toutes les salles,
     * donc pas de filtrage par plage de numéros
     */

    /**
     * Obtenir un Query Builder avec recherche et tri
     * @param string|null $search Terme de recherche
     * @param string $sort Colonne de tri
     * @param string $order Ordre (ASC/DESC)
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getDifficulteListBuilder(?string $search = null, string $sort = 'numero', string $order = 'ASC')
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
     * Créer une nouvelle difficulté
     * @param array $data ['libelle' => string]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createDifficulte(array $data)
    {
        // Validation basique
        if (empty($data['libelle'])) {
            return false;
        }

        // Vérifier que le libellé n'existe pas déjà
        if ($this->libelleExists($data['libelle'])) {
            log_message('warning', "Le libellé de difficulté '{$data['libelle']}' existe déjà");
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour une difficulté existante
     * @param int $numero
     * @param array $data ['libelle' => string]
     * @return bool
     */
    public function updateDifficulte(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier que le nouveau libellé n'existe pas déjà (sauf pour l'enregistrement actuel)
        if (isset($data['libelle']) && $this->libelleExists($data['libelle'], $numero)) {
            log_message('warning', "Le libellé de difficulté '{$data['libelle']}' existe déjà");
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer une difficulté (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteDifficulte(int $numero): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier si la difficulté est utilisée dans des activités
        if ($this->isDifficulteUsed($numero)) {
            log_message('warning', "Impossible de supprimer la difficulté #{$numero} : utilisée dans des activités");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si une difficulté est utilisée dans des activités
     * @param int $numero
     * @return bool
     */
    public function isDifficulteUsed(int $numero): bool
    {
        $db = \Config\Database::connect('default');
        $count = $db->table('activite')->where('difficulte_numero', $numero)->countAllResults();
        return $count > 0;
    }

    /**
     * Vérifier si un libellé existe déjà
     * @param string $libelle
     * @param int|null $excludeNumero Numéro à exclure de la vérification (pour les mises à jour)
     * @return bool
     */
    protected function libelleExists(string $libelle, ?int $excludeNumero = null): bool
    {
        $builder = $this->builder();
        $builder->where('libelle', $libelle);
        
        if ($excludeNumero !== null) {
            $builder->where('numero !=', $excludeNumero);
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Récupérer une difficulté par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getDifficulteByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupérer toutes les difficultés (pour les listes déroulantes)
     * @return array
     */
    public function getAllDifficulties(): array
    {
        return $this->orderBy('numero', 'ASC')->findAll();
    }

    /**
     * Récupérer le nombre d'activités par difficulté
     * @param int $numero
     * @return int
     */
    public function getActiviteCountByDifficulte(int $numero): int
    {
        $db = \Config\Database::connect('default');
        return $db->table('activite')->where('difficulte_numero', $numero)->countAllResults();
    }

    /**
     * Compter les difficultés avec recherche
     * @param string|null $search
     * @return int
     */
    public function countDifficulties(?string $search = null): int
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

    /**
     * Récupérer les statistiques d'utilisation
     * @return array
     */
    public function getUsageStats(): array
    {
        $db = \Config\Database::connect('default');
        
        return $db->table('difficulte')
                  ->select('difficulte.numero, difficulte.libelle, COUNT(activite.numero) as count')
                  ->join('activite', 'activite.difficulte_numero = difficulte.numero', 'left')
                  ->groupBy('difficulte.numero, difficulte.libelle')
                  ->orderBy('difficulte.numero', 'ASC')
                  ->get()
                  ->getResultArray();
    }
}