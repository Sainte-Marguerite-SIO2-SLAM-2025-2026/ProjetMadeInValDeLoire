<?php

namespace App\Models\salle_6;

use CodeIgniter\Model;

class VpnModel extends Model
{
    protected $table      = 'vpn';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['numero', 'libelle'];
    protected $returnType = 'array';

    /**
     * Récupère tous les vpn
     * @return array
     */
    public function getVpn()
    {
        return $this->findAll();
    }

    /**
     * Récupère un vpn par son numéro
     * @param int $numero
     * @return array|null
     */
    public function getVpnByNumero($numero)
    {
        return $this->find($numero);
    }

    /**
     * Récupère un vpn aléatoire
     * @return array|null
     */
    public function getVpnAleatoire()
    {
        return $this->orderBy('RAND()')->first();
    }
}