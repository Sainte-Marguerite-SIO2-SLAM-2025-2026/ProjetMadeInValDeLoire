<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class TypeAdminModel extends Model
{
    protected $table = 'type';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle', 'explication'];
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
    public function getTypeListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'numero', string $order = 'ASC')
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
                ->orLike('explication', $search)
                ->groupEnd();
        }

        // Tri
        $builder->orderBy($sort, $order);

        return $builder;
    }

    /**
     * Récupérer tous les types d'une salle
     * @param int $salleNumero
     * @return array
     */
    public function getTypesBySalle(int $salleNumero): array
    {
        $range = $this->getSalleRange($salleNumero);
        
        return $this->where('numero >=', $range['min'])
                    ->where('numero <=', $range['max'])
                    ->orderBy('numero', 'ASC')
                    ->findAll();
    }

    /**
     * Créer un nouveau type
     * @param array $data ['libelle' => string, 'explication' => string, 'numero' => int (optionnel)]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createType(array $data)
    {
        // Validation basique
        if (empty($data['libelle']) || empty($data['explication'])) {
            return false;
        }

        // Si un numéro spécifique est fourni, vérifier qu'il n'existe pas déjà
        if (isset($data['numero']) && $this->find($data['numero'])) {
            log_message('error', "Le type #{$data['numero']} existe déjà");
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour un type existant
     * @param int $numero
     * @param array $data ['libelle' => string, 'explication' => string]
     * @return bool
     */
    public function updateType(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer un type (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteType(int $numero): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier si le type est utilisé dans des activités
        if ($this->isTypeUsed($numero)) {
            log_message('warning', "Impossible de supprimer le type #{$numero} : utilisé dans des activités");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si un type est utilisé dans des activités
     * @param int $numero
     * @return bool
     */
    public function isTypeUsed(int $numero): bool
    {
        $db = \Config\Database::connect('default');
        $count = $db->table('activite')->where('type_numero', $numero)->countAllResults();
        return $count > 0;
    }

    /**
     * Récupérer un type par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getTypeByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupérer tous les types (pour les listes déroulantes)
     * @param int|null $salleNumero Filtrer par salle (optionnel)
     * @return array
     */
    public function getAllTypes(?int $salleNumero = null): array
    {
        if ($salleNumero !== null) {
            return $this->getTypesBySalle($salleNumero);
        }
        
        return $this->orderBy('numero', 'ASC')->findAll();
    }

    /**
     * Compter les types avec filtre optionnel par salle et recherche
     * @param int|null $salleNumero
     * @param string|null $search
     * @return int
     */
    public function countTypes(?int $salleNumero = null, ?string $search = null): int
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
                ->orLike('explication', $search)
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
     * Vérifier si un numéro de type correspond à une salle
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
     * Récupérer le nombre d'activités utilisant un type
     * @param int $numero
     * @return int
     */
    public function getActiviteCountByType(int $numero): int
    {
        $db = \Config\Database::connect('default');
        return $db->table('activite')->where('type_numero', $numero)->countAllResults();
    }

    /**
     * Récupérer les activités associées à un type
     * @param int $numero
     * @return array
     */
    public function getActivitesByType(int $numero): array
    {
        $db = \Config\Database::connect('default');
        
        return $db->table('activite')
                  ->select('numero, libelle')
                  ->where('type_numero', $numero)
                  ->orderBy('numero', 'ASC')
                  ->get()
                  ->getResultArray();
    }

    /**
     * Récupérer les statistiques d'utilisation des types
     * @param int|null $salleNumero Filtrer par salle (optionnel)
     * @return array
     */
    public function getUsageStats(?int $salleNumero = null): array
    {
        $db = \Config\Database::connect('default');
        
        $builder = $db->table('type')
                     ->select('type.numero, type.libelle, COUNT(activite.numero) as count')
                     ->join('activite', 'activite.type_numero = type.numero', 'left');

        if ($salleNumero !== null) {
            $range = $this->getSalleRange($salleNumero);
            $builder->where('type.numero >=', $range['min'])
                    ->where('type.numero <=', $range['max']);
        }

        return $builder->groupBy('type.numero, type.libelle')
                      ->orderBy('type.numero', 'ASC')
                      ->get()
                      ->getResultArray();
    }
}