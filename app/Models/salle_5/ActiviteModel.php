<?php

namespace App\salle_5;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    function getActivite(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('activite')
        ->where('salle_numero', $numSalle)
        ->get();
        if($query->getNumRows() > 0){
            $result = $query->getResult();
        }
        return $result;
    }
}