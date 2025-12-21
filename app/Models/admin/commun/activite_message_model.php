<?php

namespace App\Models\admin\commun;

use CodeIgniter\Model;

class ActiviteMessageAdminModel extends Model
{
    protected $table = 'activite_message';
    protected $primaryKey = 'id';
    protected $allowedFields = ['activite_numero', 'type_message', 'message'];
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
            return ['min' => 1, 'max' => 399];
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
    public function getMessageListBuilder(?int $salleNumero = null, ?string $search = null, string $sort = 'id', string $order = 'ASC')
    {
        $builder = $this->builder();
        $builder->select('activite_message.*, activite.libelle as activite_libelle')
                ->join('activite', 'activite.numero = activite_message.activite_numero', 'left');

        // Filtre par salle via le numéro d'activité
        if ($salleNumero !== null) {
            $range = $this->getSalleRange($salleNumero);
            $builder->where('activite_message.activite_numero >=', $range['min'])
                    ->where('activite_message.activite_numero <=', $range['max']);
        }

        // Recherche
        if ($search) {
            $builder->groupStart()
                ->like('activite_message.activite_numero', $search)
                ->orLike('activite_message.type_message', $search)
                ->orLike('activite_message.message', $search)
                ->orLike('activite.libelle', $search)
                ->groupEnd();
        }

        // Tri
        $builder->orderBy($sort, $order);

        return $builder;
    }

    /**
     * Récupérer tous les messages d'une salle
     * @param int $salleNumero
     * @return array
     */
    public function getMessagesBySalle(int $salleNumero): array
    {
        $range = $this->getSalleRange($salleNumero);
        
        return $this->select('activite_message.*, activite.libelle as activite_libelle')
                    ->join('activite', 'activite.numero = activite_message.activite_numero', 'left')
                    ->where('activite_message.activite_numero >=', $range['min'])
                    ->where('activite_message.activite_numero <=', $range['max'])
                    ->orderBy('activite_message.activite_numero', 'ASC')
                    ->findAll();
    }

    /**
     * Récupérer les messages d'une activité spécifique
     * @param int $activiteNumero
     * @return array
     */
    public function getMessagesByActivite(int $activiteNumero): array
    {
        return $this->where('activite_numero', $activiteNumero)
                    ->orderBy('type_message', 'ASC')
                    ->findAll();
    }

    /**
     * Créer un nouveau message
     * @param array $data ['activite_numero' => int, 'type_message' => string, 'message' => string]
     * @return int|false L'ID inséré ou false en cas d'échec
     */
    public function createMessage(array $data)
    {
        // Validation basique
        if (empty($data['activite_numero']) || empty($data['type_message']) || empty($data['message'])) {
            return false;
        }

        // Valider le type de message
        if (!$this->isValidTypeMessage($data['type_message'])) {
            log_message('error', "Type de message invalide : {$data['type_message']}");
            return false;
        }

        // Vérifier que l'activité existe
        if (!$this->activiteExists($data['activite_numero'])) {
            log_message('error', "L'activité #{$data['activite_numero']} n'existe pas");
            return false;
        }

        return $this->insert($data);
    }

    /**
     * Mettre à jour un message existant
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateMessage(int $id, array $data): bool
    {
        if (!$this->find($id)) {
            return false;
        }

        // Valider le type de message si présent
        if (isset($data['type_message']) && !$this->isValidTypeMessage($data['type_message'])) {
            log_message('error', "Type de message invalide : {$data['type_message']}");
            return false;
        }

        // Vérifier que l'activité existe si modifiée
        if (isset($data['activite_numero']) && !$this->activiteExists($data['activite_numero'])) {
            log_message('error', "L'activité #{$data['activite_numero']} n'existe pas");
            return false;
        }

        return $this->update($id, $data);
    }

    /**
     * Supprimer un message
     * @param int $id
     * @return bool
     */
    public function deleteMessage(int $id): bool
    {
        if (!$this->find($id)) {
            return false;
        }

        return $this->delete($id);
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
     * Valider un type de message
     * @param string $typeMessage
     * @return bool
     */
    protected function isValidTypeMessage(string $typeMessage): bool
    {
        return in_array($typeMessage, ['succes', 'echec']);
    }

    /**
     * Récupérer les types de message valides
     * @return array
     */
    public function getTypeMessageOptions(): array
    {
        return ['succes', 'echec'];
    }

    /**
     * Récupérer un message par son ID
     * @param int $id
     * @return array|null
     */
    public function getMessageById(int $id): ?array
    {
        return $this->select('activite_message.*, activite.libelle as activite_libelle')
                    ->join('activite', 'activite.numero = activite_message.activite_numero', 'left')
                    ->find($id);
    }

    /**
     * Compter les messages avec filtre optionnel par salle et recherche
     * @param int|null $salleNumero
     * @param string|null $search
     * @return int
     */
    public function countMessages(?int $salleNumero = null, ?string $search = null): int
    {
        $builder = $this->builder();
        $builder->join('activite', 'activite.numero = activite_message.activite_numero', 'left');

        if ($salleNumero !== null) {
            $range = $this->getSalleRange($salleNumero);
            $builder->where('activite_message.activite_numero >=', $range['min'])
                    ->where('activite_message.activite_numero <=', $range['max']);
        }

        if ($search) {
            $builder->groupStart()
                ->like('activite_message.activite_numero', $search)
                ->orLike('activite_message.type_message', $search)
                ->orLike('activite_message.message', $search)
                ->orLike('activite.libelle', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}