<?php

namespace App\Models\salle_2;

use CodeIgniter\Model;

class Salle2Model extends Model
{
    protected $table = 'mail';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['expediteur', 'objet', 'contenu', 'phishing', 'difficulte'];
}

class IndicesModel extends Model
{
    protected $table = 'indice';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle'];

    public function getIndices($numeroActivite)
    {
        $builder = $this->db->table('indice');
        $builder->select('indice.libelle');
        $builder->join('avoir_indice', 'indice.numero = avoir_indice.indice_numero');
        $builder->where('avoir_indice.activite_numero', $numeroActivite);
        $builder->distinct();

        $indices = $builder->get()->getResultArray();
        return $indices;
    }
}