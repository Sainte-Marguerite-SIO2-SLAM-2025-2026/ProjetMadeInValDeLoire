<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class SalleModel extends Model
{
    function getSalle(int $idSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('salle')
        ->where('numero', $idSalle)
        ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }
}