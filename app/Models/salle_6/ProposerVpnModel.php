<?php

namespace App\Models\salle_6;

use CodeIgniter\Model;

class ProposerVpnModel extends Model
{
    protected $table      = 'proposer_vpn';
    protected $primaryKey = ['vpn_numero', 'activite_numero'];
    protected $allowedFields = ['vpn_numero', 'activite_numero', 'bonne_reponse'];
    protected $returnType = 'array';

    /**
     * Récupère UN bon vpn aléatoirement pour une activité donnée
     * @param int $activite_numero
     * @return array|null
     */
    public function getBonVpnAlea($activite_numero)
    {
        return $this->select('proposer_vpn.*, vpn.libelle')
            ->join('vpn', 'vpn.numero = proposer_vpn.vpn_numero')
            ->where('proposer_vpn.activite_numero', $activite_numero)
            ->where('proposer_vpn.bonne_reponse', 1)
            ->orderBy('RAND()')
            ->first();
    }

    /**
     * Récupère DEUX mauvais vpn aléatoirement pour une activité donnée
     * @param int $activite_numero
     * @param int $limit Nombre de mauvais vpn à récupérer (par défaut 2)
     * @return array
     */
    public function getMauvaisVpnAlea($activite_numero, $limit = 2)
    {
        return $this->select('proposer_vpn.*, vpn.libelle')
            ->join('vpn', 'vpn.numero = proposer_vpn.vpn_numero')
            ->where('proposer_vpn.activite_numero', $activite_numero)
            ->where('proposer_vpn.bonne_reponse', 0)
            ->orderBy('RAND()')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Récupère 1 bon vpn + 2 mauvais vpn aléatoirement pour une activité
     * @param int $activite_numero
     * @return array ['bon' => array, 'mauvais' => array]
     */
    public function getVpnPourJeu($activite_numero)
    {
        $bonVpn = $this->getBonVpnAlea($activite_numero);
        $mauvaisVpn = $this->getMauvaisVpnAlea($activite_numero, 2);

        return [
            'bon' => $bonVpn,
            'mauvais' => $mauvaisVpn
        ];
    }

    /**
     * Vérifie si un vpn est la bonne réponse pour une activité
     * @param int $vpn_numero
     * @param int $activite_numero
     * @return bool
     */
    public function estBonneReponse($vpn_numero, $activite_numero)
    {
        $result = $this->where('vpn_numero', $vpn_numero)
            ->where('activite_numero', $activite_numero)
            ->where('bonne_reponse', 1)
            ->first();

        return $result !== null;
    }

    /**
     * Récupère TOUS les vpn (bon + mauvais) pour une activité donnée
     * @param int $activite_numero
     * @return array
     */
    public function getTousVpnPourActivite($activite_numero)
    {
        return $this->select('proposer_vpn.*, vpn.libelle')
            ->join('vpn', 'vpn.numero = proposer_vpn.vpn_numero')
            ->where('proposer_vpn.activite_numero', $activite_numero)
            ->findAll();
    }

    /**
     * Récupère tous les vpn mélangés aléatoirement pour une activité
     * (pratique pour afficher les 3 cartes dans un ordre aléatoire)
     * @param int $activite_numero
     * @return array
     */
    public function getVpnMelanges($activite_numero)
    {
        $bonVpn = $this->getBonVpnAlea($activite_numero);
        $mauvaisVpn = $this->getMauvaisVpnAlea($activite_numero, 2);

        // Si pas de données en base, retourner un tableau vide
        // (le contrôleur gérera les données de test)
        if (!$bonVpn || empty($mauvaisVpn)) {
            return [];
        }

        // Fusionner et mélanger
        $tousVpn = array_merge([$bonVpn], $mauvaisVpn);
        shuffle($tousVpn);

        return $tousVpn;
    }
}