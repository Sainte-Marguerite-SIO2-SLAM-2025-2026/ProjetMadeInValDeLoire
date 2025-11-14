<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ZoneModel extends Model
{
    protected $table = 'zone';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['nom', 'coordonnees', 'bonne_reponse'];

    /**
     * Récupérer toutes les zones d'une activité
     */
    public function getZonesByActivite($activite_numero)
    {
        return $this->db->table('zone')
            ->select('zone.*, avoir_zone.activite_numero')
            ->join('avoir_zone', 'avoir_zone.zone_numero = zone.numero')
            ->where('avoir_zone.activite_numero', $activite_numero)
            ->get()
            ->getResult();
    }

    /**
     * Vérifier si une zone cliquée est la bonne réponse
     */
    public function verifierZone($activite_numero, $zone_nom)
    {
        $zone = $this->db->table('zone')
            ->select('zone.*')
            ->join('avoir_zone', 'avoir_zone.zone_numero = zone.numero')
            ->where('avoir_zone.activite_numero', $activite_numero)
            ->where('zone.nom', $zone_nom)
            ->get()
            ->getRow();

        if (!$zone) {
            return [
                'valid' => false,
                'message' => 'Zone introuvable'
            ];
        }

        return [
            'valid' => (bool)$zone->bonne_reponse,
            'zone' => $zone
        ];
    }
}