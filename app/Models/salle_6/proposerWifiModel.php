<?php

namespace App\Models\salle_6;

use CodeIgniter\Model;

class ProposerWifiModel extends Model
{
    protected $table      = 'proposer_wifi';
    protected $primaryKey = ['wifi_numero', 'activite_numero'];
    protected $allowedFields = ['wifi_numero', 'activite_numero', 'bonne_reponse', 'zone_clique'];
    protected $returnType = 'array';

    /**
     * Récupère UN bon WiFi aléatoirement pour une activité donnée
     * @param int $activite_numero
     * @return array|null
     */
    public function getBonWifiAlea($activite_numero)
    {
        return $this->select('proposer_wifi.*, wifi.nom, wifi.public, wifi.chiffrement')
            ->join('wifi', 'wifi.numero = proposer_wifi.wifi_numero')
            ->where('proposer_wifi.activite_numero', $activite_numero)
            ->where('bonne_reponse', 1)
            ->orderBy('RAND()')
            ->first();
    }

    /**
     * Récupère DEUX mauvais WiFi aléatoirement pour une activité donnée
     * @param int $activite_numero
     * @param int $limit Nombre de mauvais WiFi à récupérer (par défaut 2)
     * @return array
     */
    public function getMauvaisWifiAlea($activite_numero, $limit = 2)
    {
        return $this->select('proposer_wifi.*, wifi.nom, wifi.public, wifi.chiffrement')
            ->join('wifi', 'wifi.numero = proposer_wifi.wifi_numero')
            ->where('proposer_wifi.activite_numero', $activite_numero)
            ->where('bonne_reponse', 0)
            ->orderBy('RAND()')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Récupère 1 bon WiFi + 2 mauvais WiFi aléatoirement pour une activité
     * @param int $activite_numero
     * @return array ['bon' => array, 'mauvais' => array]
     */
    public function getWifiPourJeu($activite_numero)
    {
        $bonWifi = $this->getBonWifiAlea($activite_numero);
        $mauvaisWifi = $this->getMauvaisWifiAlea($activite_numero, 2);

        return [
            'bon' => $bonWifi,
            'mauvais' => $mauvaisWifi
        ];
    }

    /**
     * Vérifie si un WiFi est la bonne réponse pour une activité
     * @param int $wifi_numero
     * @param int $activite_numero
     * @return bool
     */
    public function estBonneReponse($wifi_numero, $activite_numero)
    {
        $result = $this->where('wifi_numero', $wifi_numero)
            ->where('activite_numero', $activite_numero)
            ->where('bonne_reponse', 1)
            ->first();

        return $result !== null;
    }

    /**
     * Récupère la zone cliquable associée à un WiFi pour une activité
     * @param int $wifi_numero
     * @param int $activite_numero
     * @return string|null
     */
    public function getZoneClique($wifi_numero, $activite_numero)
    {
        $result = $this->where('wifi_numero', $wifi_numero)
            ->where('activite_numero', $activite_numero)
            ->first();

        return $result ? $result['zone_clique'] : null;
    }

    /**
     * Récupère TOUS les WiFi (bon + mauvais) pour une activité donnée
     * @param int $activite_numero
     * @return array
     */
    public function getTousWifiPourActivite($activite_numero)
    {
        return $this->select('proposer_wifi.*, wifi.public, wifi.chiffrement')
            ->join('wifi', 'wifi.numero = proposer_wifi.wifi_numero')
            ->where('proposer_wifi.activite_numero', $activite_numero)
            ->findAll();
    }

    /**
     * Récupère tous les WiFi mélangés aléatoirement pour une activité
     * (pratique pour afficher les 3 cartes dans un ordre aléatoire)
     * @param int $activite_numero
     * @return array
     */
    public function getWifiMelanges($activite_numero)
    {
        $bonWifi = $this->getBonWifiAlea($activite_numero);
        $mauvaisWifi = $this->getMauvaisWifiAlea($activite_numero, 2);

        // Vérification améliorée avec log de debug
        if (!$bonWifi) {
            log_message('warning', "Aucun bon WiFi trouvé pour l'activité $activite_numero");
            return [];
        }

        // Vérifier que $mauvaisWifi est bien un tableau
        if (!is_array($mauvaisWifi)) {
            log_message('warning', "mauvaisWifi n'est pas un tableau pour l'activité $activite_numero");
            return [];
        }

        $nbMauvaisWifi = count($mauvaisWifi);
        log_message('debug', "Nombre de mauvais WiFi récupérés: $nbMauvaisWifi");

        // Vérifier qu'on a bien 2 mauvais WiFi
        if ($nbMauvaisWifi < 2) {
            log_message('warning', "Pas assez de mauvais WiFi trouvés pour l'activité $activite_numero (trouvé: $nbMauvaisWifi, attendu: 2)");
            return [];
        }

        // Fusionner et mélanger
        $tousWifi = array_merge([$bonWifi], $mauvaisWifi);
        shuffle($tousWifi);

        log_message('debug', "Total de WiFi mélangés: " . count($tousWifi));

        return $tousWifi;
    }
}