<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class IndiceAdminModel extends Model
{
    protected $table = 'indice';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle'];
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
    public function getIndiceListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'numero', string $order = 'ASC')
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
     * Récupérer tous les indices d'une salle
     * @param int $salleNumero
     * @return array
     */
    public function getIndicesBySalle(int $salleNumero): array
    {
        $range = $this->getSalleRange($salleNumero);
        
        return $this->where('numero >=', $range['min'])
                    ->where('numero <=', $range['max'])
                    ->orderBy('numero', 'ASC')
                    ->findAll();
    }

    /**
     * Créer un nouvel indice
     * @param array $data ['libelle' => string, 'numero' => int (optionnel)]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createIndice(array $data)
    {
        // Validation basique
        if (empty($data['libelle'])) {
            return false;
        }

        // Si un numéro spécifique est fourni, vérifier qu'il n'existe pas déjà
        if (isset($data['numero']) && $this->find($data['numero'])) {
            log_message('error', "L'indice #{$data['numero']} existe déjà");
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour un indice existant
     * @param int $numero
     * @param array $data ['libelle' => string]
     * @return bool
     */
    public function updateIndice(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer un indice (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteIndice(int $numero): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier si l'indice est utilisé dans avoir_indice
        if ($this->isIndiceUsed($numero)) {
            log_message('warning', "Impossible de supprimer l'indice #{$numero} : utilisé dans des activités");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si un indice est utilisé dans avoir_indice
     * @param int $numero
     * @return bool
     */
    public function isIndiceUsed(int $numero): bool
    {
        $db = \Config\Database::connect('default');
        $count = $db->table('avoir_indice')->where('indice_numero', $numero)->countAllResults();
        return $count > 0;
    }

    /**
     * Récupérer un indice par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getIndiceByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Récupérer tous les indices (pour les listes déroulantes)
     * @param int|null $salleNumero Filtrer par salle (optionnel)
     * @return array
     */
    public function getAllIndices(?int $salleNumero = null): array
    {
        if ($salleNumero !== null) {
            return $this->getIndicesBySalle($salleNumero);
        }
        
        return $this->orderBy('numero', 'ASC')->findAll();
    }

    /**
     * Compter les indices avec filtre optionnel par salle et recherche
     * @param int|null $salleNumero
     * @param string|null $search
     * @return int
     */
    public function countIndices(?int $salleNumero = null, ?string $search = null): int
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
     * Vérifier si un numéro d'indice correspond à une salle
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
     * Récupérer le nombre d'activités utilisant un indice
     * @param int $numero
     * @return int
     */
    public function getActiviteCountByIndice(int $numero): int
    {
        $db = \Config\Database::connect('default');
        return $db->table('avoir_indice')->where('indice_numero', $numero)->countAllResults();
    }

    /**
     * Récupérer les activités associées à un indice
     * @param int $numero
     * @return array
     */
    public function getActivitesByIndice(int $numero): array
    {
        $db = \Config\Database::connect('default');
        
        return $db->table('avoir_indice')
                  ->select('activite.numero, activite.libelle')
                  ->join('activite', 'activite.numero = avoir_indice.activite_numero', 'left')
                  ->where('avoir_indice.indice_numero', $numero)
                  ->orderBy('activite.numero', 'ASC')
                  ->get()
                  ->getResultArray();
    }
}