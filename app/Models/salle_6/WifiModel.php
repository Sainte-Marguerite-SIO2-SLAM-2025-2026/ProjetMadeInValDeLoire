<?php

namespace App\salle_6;

use CodeIgniter\Model;

class WifiModel extends Model
{
    protected $table      = 'wifi';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['numero', 'public','chiffrement'];

    public function getWifi($numero)
    {

    }
}