<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ModeEmploiModel extends Model
{
    function getModeEmploi(int $numActivite){
        $result = false;
        $db = db_connect();
        $query = $db->table('mode_emploi')
            ->where('activite_numero', $numActivite)
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }
}