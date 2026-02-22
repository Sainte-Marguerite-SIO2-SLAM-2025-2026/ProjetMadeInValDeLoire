<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class ActiviteAdminModel extends Model
{
    protected $table = 'activite';
    protected $primaryKey = 'numero';
    protected $allowedFields = [
        'numero',
        'libelle', 'verrouillage', 'image', 'malveillant',
        'difficulte_numero', 'salle_numero', 'auteur_numero',
        'type_numero', 'explication_numero', 'width_img', 'height_img'
    ];
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
    public function getActiviteListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'numero', string $order = 'ASC')
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
                ->orLike('image', $search)
                ->groupEnd();
        }

        // Tri
        $builder->orderBy($sort, $order);

        return $builder;
    }

    /**
     * Récupérer toutes les activités d'une salle
     * @param int $salleNumero
     * @return array
     */
    public function getActivitesBySalle(int $salleNumero): array
    {
        $range = $this->getSalleRange($salleNumero);
        
        return $this->where('numero >=', $range['min'])
                    ->where('numero <=', $range['max'])
                    ->orderBy('numero', 'ASC')
                    ->findAll();
    }

    /**
     * Créer une nouvelle activité
     * @param array $data
     * @return int|false L'ID inséré ou false en cas d'échec
     * @throws \ReflectionException
     */
    public function createActivite(array $data)
    {
        // Validation basique
        if (empty($data['libelle'])) {
            return false;
        }

        // Vérifier que le numéro correspond bien à la salle si fourni
        if (isset($data['numero']) && isset($data['salle_numero'])) {
            if (!$this->isNumeroValidForSalle($data['numero'], $data['salle_numero'])) {
                log_message('error', "Le numéro {$data['numero']} ne correspond pas à la salle {$data['salle_numero']}");
                return false;
            }
        }
        return $this->insert($data);
    }

    /**
     * Mettre à jour une activité existante
     * @param int $numero
     * @param array $data
     * @return bool
     */
    public function updateActivite(int $numero, array $data): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier la cohérence salle/numéro si modifiés
        $activite = $this->find($numero);
        $salleNumero = $data['salle_numero'] ?? $activite['salle_numero'];
        
        if ($salleNumero && !$this->isNumeroValidForSalle($numero, $salleNumero)) {
            log_message('error', "Le numéro {$numero} ne correspond pas à la salle {$salleNumero}");
            return false;
        }

        return $this->update($numero, $data);
    }

    /**
     * Supprimer une activité (vérifie les contraintes)
     * @param int $numero
     * @return bool
     */
    public function deleteActivite(int $numero): bool
    {
        if (!$this->find($numero)) {
            return false;
        }

        // Vérifier les dépendances
        if ($this->hasRelatedRecords($numero)) {
            log_message('warning', "Impossible de supprimer l'activité #{$numero} : utilisée dans d'autres tables");
            return false;
        }

        return $this->delete($numero);
    }

    /**
     * Vérifier si une activité a des enregistrements liés
     * @param int $numero
     * @return bool
     */
    public function hasRelatedRecords(int $numero): bool
    {
        $db = \Config\Database::connect('default');
        
        $tables = [
            'activiteMessage' => 'activite_numero',
            'avoirIndice' => 'activite_numero',
            'avoir_rep' => 'activite_numero',
            'avoir_zone' => 'activite_numero',
            'carte' => 'activite_numero',
            'erreur' => 'activite_numero',
            'mode_emploi' => 'activite_numero',
            'proposer_vpn' => 'activite_numero',
            'proposer_wifi' => 'activite_numero',
            'question' => 'activite_numero',
            'objets_activite' => 'numero_activite'
        ];

        foreach ($tables as $table => $column) {
            $count = $db->table($table)->where($column, $numero)->countAllResults();
            if ($count > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Vérifier si un numéro d'activité correspond à une salle
     * @param int $numero
     * @param int $salleNumero
     * @return bool
     */
    protected function isNumeroValidForSalle(int $numero, int $salleNumero): bool
    {
        $range = $this->getSalleRange($salleNumero);
        return $numero >= $range['min'] && $numero <= $range['max'];
    }

    /**
     * Récupérer une activité par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getActiviteByNumero(int $numero): ?array
    {
        return $this->find($numero);
    }

    /**
     * Compter les activités avec filtre optionnel par salle et recherche
     * @param int|null $salleNumero
     * @param string|null $search
     * @return int
     */
    public function countActivites(?int $salleNumero = null, ?string $search = null): int
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
                ->orLike('image', $search)
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
}