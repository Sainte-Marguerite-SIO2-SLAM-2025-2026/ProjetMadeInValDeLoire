<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class AvoirIndiceAdminModel extends Model
{
    protected $table = 'avoir_indice';
    protected $primaryKey = ['activite_ numero', 'indice_numero'];
    protected $allowedFields = ['activite_numero', 'indice_numero'];
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
     * Obtenir un Query Builder avec filtre par salle et recherche
     * @param int|null $salleNumero Numéro de la salle (null = toutes)
     * @param string|null $search Terme de recherche
     * @param string $sort Colonne de tri
     * @param string $order Ordre (ASC/DESC)
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getAvoirIndiceListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'activite_numero', string $order = 'ASC')
    {
        $builder = $this->builder();
        $builder->select('avoir_indice.*, activite.libelle as activite_libelle, indice.libelle as indice_libelle')
                ->join('activite', 'activite.numero = avoir_indice.activite_numero', 'left')
                ->join('indice', 'indice.numero = avoir_indice.indice_numero', 'left');

        // Filtre par salle
        if ($salleNumero !== null) {
            $range = $this->getSalleRange($salleNumero);
            $builder->where('avoir_indice.activite_numero >=', $range['min'])
                    ->where('avoir_indice.activite_numero <=', $range['max']);
        }

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('avoir_indice.activite_numero', $search)
                ->like('avoir_indice.indice_numero', $search)
                ->orLike('activite.libelle', $search)
                ->orLike('indice.libelle', $search)
                ->groupEnd();
        }

        // Tri
        $builder->orderBy($sort, $order);

        return $builder;
    }

    /**
     * Récupérer toutes les associations activité-indice d'une salle
     * @param int $salleNumero
     * @return array
     */
    public function getAvoirIndicesBySalle(int $salleNumero): array
    {
        $range = $this->getSalleRange($salleNumero);
        
        return $this->select('avoir_indice.*, activite.libelle as activite_libelle, indice.libelle as indice_libelle')
                    ->join('activite', 'activite.numero = avoir_indice.activite_numero', 'left')
                    ->join('indice', 'indice.numero = avoir_indice.indice_numero', 'left')
                    ->where('avoir_indice.activite_numero >=', $range['min'])
                    ->where('avoir_indice.activite_numero <=', $range['max'])
                    ->orderBy('avoir_indice.activite_numero', 'ASC')
                    ->findAll();
    }

    /**
     * Récupérer les indices d'une activité
     * @param int $activiteNumero
     * @return array
     */
    public function getIndicesByActivite(int $activiteNumero): array
    {
        return $this->select('avoir_indice.*, indice.libelle')
                    ->join('indice', 'indice.numero = avoir_indice.indice_numero', 'left')
                    ->where('activite_numero', $activiteNumero)
                    ->findAll();
    }

    /**
     * Récupérer les activités utilisant un indice
     * @param int $indiceNumero
     * @return array
     */
    public function getActivitesByIndice(int $indiceNumero): array
    {
        return $this->select('avoir_indice.*, activite.libelle')
                    ->join('activite', 'activite.numero = avoir_indice.activite_numero', 'left')
                    ->where('indice_numero', $indiceNumero)
                    ->findAll();
    }

    /**
     * Créer une nouvelle association activité-indice
     * @param array $data ['activite_numero' => int, 'indice_numero' => int]
     * @return bool
     */
    public function createavoir_indice(array $data): bool
    {
        // Validation basique
        if (empty($data['activite_numero']) || empty($data['indice_numero'])) {
            return false;
        }

        // Vérifier que l'activité existe
        if (!$this->activiteExists($data['activite_numero'])) {
            log_message('error', "L'activité #{$data['activite_numero']} n'existe pas");
            return false;
        }

        // Vérifier que l'indice existe
        if (!$this->indiceExists($data['indice_numero'])) {
            log_message('error', "L'indice #{$data['indice_numero']} n'existe pas");
            return false;
        }

        // Vérifier que l'association n'existe pas déjà
        if ($this->associationExists($data['activite_numero'], $data['indice_numero'])) {
            log_message('warning', "L'association activité {$data['activite_numero']} - indice {$data['indice_numero']} existe déjà");
            return false;
        }

        return $this->insert($data) !== false;
    }

    /**
     * Supprimer une association activité-indice
     * @param int $activiteNumero
     * @param int $indiceNumero
     * @return bool
     */
    public function deleteAvoirIndice(int $activiteNumero, int $indiceNumero): bool
    {
        if (!$this->associationExists($activiteNumero, $indiceNumero)) {
            return false;
        }

        return $this->where('activite_numero', $activiteNumero)
                    ->where('indice_numero', $indiceNumero)
                    ->delete();
    }

    /**
     * Supprimer toutes les associations d'une activité
     * @param int $activiteNumero
     * @return bool
     */
    public function deleteByActivite(int $activiteNumero): bool
    {
        return $this->where('activite_numero', $activiteNumero)->delete();
    }

    /**
     * Supprimer toutes les associations d'un indice
     * @param int $indiceNumero
     * @return bool
     */
    public function deleteByIndice(int $indiceNumero): bool
    {
        return $this->where('indice_numero', $indiceNumero)->delete();
    }

    /**
     * Vérifier si une association existe
     * @param int $activiteNumero
     * @param int $indiceNumero
     * @return bool
     */
    public function associationExists(int $activiteNumero, int $indiceNumero): bool
    {
        $count = $this->where('activite_numero', $activiteNumero)
                     ->where('indice_numero', $indiceNumero)
                     ->countAllResults();
        return $count > 0;
    }

    /**
     * Vérifier si une activité existe
     * @param int $activiteNumero
     * @return bool
     */
    protected function activiteExists(int $activiteNumero): bool
    {
        $db = \Config\Database::connect('default');
        $count = $db->table('activite')->where('numero', $activiteNumero)->countAllResults();
        return $count > 0;
    }

    /**
     * Vérifier si un indice existe
     * @param int $indiceNumero
     * @return bool
     */
    protected function indiceExists(int $indiceNumero): bool
    {
        $db = \Config\Database::connect('default');
        $count = $db->table('indice')->where('numero', $indiceNumero)->countAllResults();
        return $count > 0;
    }

    /**
     * Compter les associations avec filtre optionnel par salle et recherche
     * @param int|null $salleNumero
     * @param string|null $search
     * @return int
     */
    public function countAvoirIndices(?int $salleNumero = null, ?string $search = null): int
    {
        $builder = $this->builder();
        $builder->join('activite', 'activite.numero = avoir_indice.activite_numero', 'left')
                ->join('indice', 'indice.numero = avoir_indice.indice_numero', 'left');

        if ($salleNumero !== null) {
            $range = $this->getSalleRange($salleNumero);
            $builder->where('avoir_indice.activite_numero >=', $range['min'])
                    ->where('avoir_indice.activite_numero <=', $range['max']);
        }

        if ($search) {
            $builder->groupStart()
                ->like('avoir_indice.activite_numero', $search)
                ->orLike('avoir_indice.indice_numero', $search)
                ->orLike('activite.libelle', $search)
                ->orLike('indice.libelle', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}