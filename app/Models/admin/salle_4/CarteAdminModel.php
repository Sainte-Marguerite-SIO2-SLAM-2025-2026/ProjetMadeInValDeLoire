<?php

namespace App\Models\admin\salle_4;

use CodeIgniter\Model;

class CarteAdminModel extends Model
{
    protected $table = 'carte';
    protected $primaryKey = 'numero';
    protected $allowedFields = [
        'image',
        'explication',
        'activite_numero',
        'explication_piege',
        'type_carte'
    ];
    protected $useTimestamps = false;

    /**
     * Récupère toutes les cartes liées à la salle 4 (activités 400-499)
     */
    public function getAllCartesWithActivite()
    {
        return $this->select('carte.*, activite.libelle as activite_libelle')
            ->join('activite', 'activite.numero = carte.activite_numero', 'left')
            ->where('activite.numero >=', 400)
            ->where('activite.numero <=', 499)
            ->orderBy('carte.numero', 'ASC')
            ->findAll();
    }

    /**
     * Récupère une carte par son ID avec les infos de l'activité
     */
    public function getCarteById($id)
    {
        return $this->select('carte.*, activite.libelle as activite_libelle')
            ->join('activite', 'activite.numero = carte.activite_numero', 'left')
            ->where('carte.numero', $id)
            ->first();
    }

    /**
     * Récupère les cartes par type (filtrées pour la salle 4)
     */
    public function getCartesByType($type)
    {
        return $this->select('carte.*')
            ->join('activite', 'activite.numero = carte.activite_numero', 'left')
            ->where('carte.type_carte', $type)
            ->where('activite.numero >=', 400)
            ->where('activite.numero <=', 499)
            ->orderBy('carte.numero', 'ASC')
            ->findAll();
    }

    /**
     * Récupère les activités de la salle 4 pour les dropdown
     */
    public function getActivites()
    {
        $db = \Config\Database::connect();
        return $db->table('activite')
            ->select('numero, libelle')
            ->where('numero >=', 400)
            ->where('numero <=', 499)
            ->orderBy('numero', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Compte toutes les cartes de la salle 4
     */
    public function countCartesSalle4()
    {
        return $this->select('carte.*')
            ->join('activite', 'activite.numero = carte.activite_numero', 'left')
            ->where('activite.numero >=', 400)
            ->where('activite.numero <=', 499)
            ->countAllResults();
    }
}