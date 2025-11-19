<?php

namespace App\Models\salle_6;

use CodeIgniter\Model;

class WifiModel extends Model
{
    protected $table      = 'wifi';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['numero', 'public', 'chiffrement'];
    protected $returnType = 'array';

    /**
     * Récupère tous les WiFi
     * @return array
     */
    public function getWifi()
    {
        return $this->findAll();
    }

    /**
     * Récupère un WiFi par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getWifiByNumero($numero)
    {
        return $this->find($numero);
    }

    /**
     * Récupère les WiFi publics
     * @return array
     */
    public function getWifiPublics()
    {
        return $this->where('public', 1)->findAll();
    }

    /**
     * Récupère les WiFi privés
     * @return array
     */
    public function getWifiPrives()
    {
        return $this->where('public', 0)->findAll();
    }

    /**
     * Récupère un WiFi aléatoire
     * @return array|null
     */
    public function getWifiAleatoire()
    {
        return $this->orderBy('RAND()')->first();
    }
}
