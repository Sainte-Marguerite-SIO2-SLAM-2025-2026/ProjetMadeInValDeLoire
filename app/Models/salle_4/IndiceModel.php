<?php

namespace App\Models\salle_4;

use CodeIgniter\Model;

class IndiceModel extends Model
{
    protected $table = 'indice';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['libelle', 'bouton','intro_salle'];
}