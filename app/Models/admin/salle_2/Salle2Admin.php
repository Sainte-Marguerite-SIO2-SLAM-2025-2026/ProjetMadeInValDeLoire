<?php

namespace App\Models;

use CodeIgniter\Model;

class Salle2Admin extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Récupère toutes les données pour l'affichage des tableaux
    public function getAllElements()
    {
        return [
            'explications' => $this->db->table('explication')->orderBy('numero', 'ASC')->get()->getResultArray(),
            'indices'      => $this->db->table('indice')->orderBy('numero', 'ASC')->get()->getResultArray(),
            'mdps'         => $this->db->table('mot_de_passe')->orderBy('numero', 'ASC')->get()->getResultArray()
        ];
    }

    // Récupère les compteurs pour les stats
    public function getStats()
    {
        return [
            'nb_exps'    => $this->db->table('explication')->countAll(),
            'nb_indices' => $this->db->table('indice')->countAll(),
            'nb_mdps'    => $this->db->table('mot_de_passe')->countAll(),
        ];
    }

    // Gère l'Ajout ET la Modification
    public function saveElement($type, $postData)
    {
        $id = $postData['id'] ?? null;

        // Configuration dynamique selon la table
        $table = '';
        $data  = ['numero' => $postData['numero']];

        switch ($type) {
            case 'explication':
            case 'indice':
                $table = $type; // La table porte le même nom que le type
                $data['libelle'] = $postData['description'];
                break;

            case 'mdp':
                $table = 'mot_de_passe';
                $data['motPasse'] = $postData['description'];
                $data['Valeur']   = $postData['valeur'] ?? ''; // Champ spécifique aux MDP
                break;
        }

        if (empty($table)) return false;

        $builder = $this->db->table($table);

        if (!empty($id)) {
            // UPDATE
            $builder->where('id', $id);
            return $builder->update($data);
        } else {
            // INSERT
            return $builder->insert($data);
        }
    }

    // Gère la Suppression
    public function deleteElement($type, $id)
    {
        // Petite sécurité pour mapper le type vers la table
        $tables = [
            'explication' => 'explication',
            'indice'      => 'indice',
            'mdp'         => 'mot_de_passe'
        ];

        if (isset($tables[$type])) {
            $this->db->table($tables[$type])->where('id', $id)->delete();
        }
    }
}