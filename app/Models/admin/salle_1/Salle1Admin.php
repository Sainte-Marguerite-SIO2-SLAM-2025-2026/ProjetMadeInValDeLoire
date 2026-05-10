<?php

namespace App\Models\admin\salle_1;

use CodeIgniter\Model;

class Salle1Admin extends Model
{
    protected $DBGroup = 'default';

    /*
    |--------------------------------------------------------------------------
    | Récupération des données
    |--------------------------------------------------------------------------
    */

    public function getAuteurs()
    {
        return $this->db->table('auteur')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getMessages()
    {
        return $this->db->table('message')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getReponses()
    {
        return $this->db->table('bonne_reponse')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Sauvegarde générique
    |--------------------------------------------------------------------------
    */

    public function saveElement(string $type, array $data, ?int $id = null): bool
    {
        $table = $this->resolveTable($type);

        if (!$table) {
            return false;
        }

        // UPDATE
        if ($id !== null) {
            return $this->db->table($table)
                ->where('id', $id)
                ->update($data);
        }

        // INSERT
        return $this->db->table($table)
            ->insert($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Suppression
    |--------------------------------------------------------------------------
    */

    public function deleteElement(string $type, int $id): bool
    {
        $table = $this->resolveTable($type);

        if (!$table) {
            return false;
        }

        return $this->db->table($table)
            ->where('id', $id)
            ->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Résolution des tables SQL
    |--------------------------------------------------------------------------
    */

    private function resolveTable(string $type): ?string
    {
        switch ($type) {

            case 'auteur':
                return 'auteur';

            case 'message':
                return 'message';

            case 'reponse':
                return 'bonne_reponse';

            default:
                return null;
        }
    }
}