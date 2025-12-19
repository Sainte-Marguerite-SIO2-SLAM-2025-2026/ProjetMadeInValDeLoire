<?php

namespace App\Models\admin\salle_2;

use CodeIgniter\Model;

class Salle2Admin extends Model
{
    public function getExplications()
    {
        return $this->db->table('explication')
            ->select('numero as id, numero, libelle')
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getIndices()
    {
        return $this->db->table('indice')
            ->select('numero as id, numero, libelle')
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getMdps()
    {
        return $this->db->table('mot_de_passe')
            ->select('numero as id, numero, motPasse, Valeur')
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function saveElement($type, $data, $ancienNumero = null)
    {
        $table = '';
        $dbData = [];

        if ($type === 'explication') {
            $table = 'explication';
            $dbData = [
                'numero'  => $data['numero'],
                'libelle' => $data['description']
            ];
        }
        elseif ($type === 'indice') {
            $table = 'indice';
            $dbData = [
                'numero'  => $data['numero'],
                'libelle' => $data['description']
            ];
        }
        elseif ($type === 'mdp') {
            $table = 'mot_de_passe';
            $dbData = [
                'numero'   => $data['numero'],
                'motPasse' => $data['description'],
                'Valeur'   => $data['valeur']
            ];
        }

        if (!empty($ancienNumero)) {
            return $this->db->table($table)->where('numero', $ancienNumero)->update($dbData);
        } else {
            // INSERT
            return $this->db->table($table)->insert($dbData);
        }
    }

    public function deleteElement($type, $numero)
    {
        $table = '';
        if ($type === 'explication') $table = 'explication';
        elseif ($type === 'indice') $table = 'indice';
        elseif ($type === 'mdp') $table = 'mot_de_passe';

        if ($table && $numero) {
            return $this->db->table($table)->where('numero', $numero)->delete();
        }
        return false;
    }
}