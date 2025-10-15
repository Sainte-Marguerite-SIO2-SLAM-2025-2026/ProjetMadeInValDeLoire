<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class MascotteModel extends Model
{
    function getMascotte(int $idSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('mascotte')
            ->where('salle_numero', $idSalle)
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }
}