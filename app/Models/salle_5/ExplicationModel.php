<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ExplicationModel extends Model
{
    function getExplication(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('explication')
            ->where('numero', $numSalle)
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }
}