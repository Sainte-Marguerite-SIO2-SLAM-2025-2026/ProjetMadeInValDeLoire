<?php

namespace App\salle_6;

use CodeIgniter\Model;

class proposer_wifi extends Model
{
    protected $table      = 'proposer_wifi';
    protected $primaryKey = ['wifi_numero','activite_numero'];
    protected $allowedFields = ['numero', 'public','chiffrement'];
}