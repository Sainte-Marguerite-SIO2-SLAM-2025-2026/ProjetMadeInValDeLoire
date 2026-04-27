<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class ExplicationAdminModel extends Model
{
    protected $table = 'explication';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['numero', 'libelle'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $DBGroup = 'default';

    /**
     * Déterminer la plage d'indices pour une salle donnée
     * @param int $salleNumero
     * @return array ['min' => int, 'max' => int]
     */
    protected function getSalleRange(int $salleNumero): array
    {
        if ($salleNumero === 3) {
            return ['min' => 1, 'max' => 99];
        }
        
        return [
            'min' => $salleNumero * 100,
            'max' => ($salleNumero * 100) + 99
        ];
    }

    /**
     * Obtenir un Query Builder avec recherche, tri et filtre par salle
     * @param int|null $salleNumero Numéro de la salle (null = toutes)
     * @param string|null $search Terme de recherche
     * @param string $sort Colonne de tri
     * @param string $order Ordre (ASC/DESC)
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getExplicationListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'numero', string $order = 'ASC')
    {
        $builder = $this->builder();

        // Filtre par salle
        if ($salleNumero !== null) {
            $range = $this->getSalleRange($salleNumero);
            $builder->where('numero >=', $range['min'])
                    ->where('numero <=', $range['max']);
        }

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
     * Récupérer toutes les explications d'une salle
     * @param int $salleNumero
     * @return array
     */
    public function getExplicationsBySalle(int $salleNumero): array
    {
        $range = $this->getSalleRange($salleNumero);
        
        return $this->where('numero >=', $range['min'])
                    ->where('numero <=', $range['max'])
                    ->orderBy('numero', 'ASC')
                    ->findAll();
    }

    /**
     * Créer une nouvelle explication
     * @param array $data ['libelle' => string, 'numero' => int (optionnel)]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createExplication(array $data)
    {
        // Validation basique
        if (empty($data['libelle'])) {
            return false;
        }

        // Si un numéro spécifique est fourni, vérifier qu'il n'existe pas déjà
        if (isset($data['numero']) && $this->find($data['numero'])) {
            log_message('error', "L'explication #{$data['numero']} existe déjà");
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour une explication existante
     * @param int $numero
     * @param array $data ['libelle' => string]
     * @return bool
     */
    public function updateExplication(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer une explication (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteExplication(int $numero): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier si l'explication est utilisée dans des activités
        if ($this->isExplicationUsed($numero)) {
            log_message('warning', "Impossible de supprimer l'explication #{$numero} : utilisée dans des activités");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si une explication est utilisée dans des activités
     * @param int $numero
     * @return bool
     */
    public function isExplicationUsed(int $numero): bool
    {
        $db = \Config\Database::connect('default');
        $count = $db->table('activite')->where('explication_numero', $numero)->countAllResults();
        return $count > 0;
    }

    /**
     * Récupérer une explication par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getExplicationByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupérer toutes les explications (pour les listes déroulantes)
     * @param int|null $salleNumero Filtrer par salle (optionnel)
     * @return array
     */
    public function getAllExplications(?int $salleNumero = null): array
    {
        if ($salleNumero !== null) {
            return $this->getExplicationsBySalle($salleNumero);
        }
        
        return $this->orderBy('numero', 'ASC')->findAll();
    }

    /**
     * Compter les explications avec filtre optionnel par salle et recherche
     * @param int|null $salleNumero
     * @param string|null $search
     * @return int
     */
    public function countExplications(?int $salleNumero = null, ?string $search = null): int
    {
        $builder = $this->builder();

        if ($salleNumero !== null) {
            $range = $this->getSalleRange($salleNumero);
            $builder->where('numero >=', $range['min'])
                    ->where('numero <=', $range['max']);
        }

        if ($search) {
            $builder->groupStart()
                ->like('numero', $search)
                ->orLike('libelle', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    /**
     * Récupérer le prochain numéro disponible pour une salle
     * @param int $salleNumero
     * @return int
     */
    public function getNextNumeroForSalle(int $salleNumero): int
    {
        $range = $this->getSalleRange($salleNumero);
        
        $lastNumero = $this->where('numero >=', $range['min'])
                          ->where('numero <=', $range['max'])
                          ->orderBy('numero', 'DESC')
                          ->first();

        if ($lastNumero) {
            return $lastNumero['numero'] + 1;
        }

        return $range['min'];
    }

    /**
     * Vérifier si un numéro d'explication correspond à une salle
     * @param int $numero
     * @param int $salleNumero
     * @return bool
     */
    public function isNumeroValidForSalle(int $numero, int $salleNumero): bool
    {
        $range = $this->getSalleRange($salleNumero);
        return $numero >= $range['min'] && $numero <= $range['max'];
    }

    /**
     * Récupérer le nombre d'activités utilisant une explication
     * @param int $numero
     * @return int
     */
    public function getActiviteCountByExplication(int $numero): int
    {
        $db = \Config\Database::connect('default');
        return $db->table('activite')->where('explication_numero', $numero)->countAllResults();
    }
}