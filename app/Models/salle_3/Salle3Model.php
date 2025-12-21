<?php

namespace App\Models\salle_3;

use CodeIgniter\Model;

class Salle3Model extends Model
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
        $builder->join('avoirIndice', 'indice.numero = avoirIndice.indice_numero');
        $builder->where('avoirIndice.activite_numero', $numeroActivite);
        $builder->distinct();

        $indices = $builder->get()->getResultArray();
        return $indices;
    }
}

class ExplicationsModel extends Model
{
    protected $table = 'explication';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle'];

    public function getExplication($numeroActivite)
    {
        $builder = $this->db->table('explication');
        $builder->select('explication.libelle');
        $builder->join('activite', 'activite.explication_numero = explication.numero');
        $builder->where('activite.numero', $numeroActivite);
        $builder->distinct();

        $explication = $builder->get()->getResultArray();
        return $explication;
    }
}