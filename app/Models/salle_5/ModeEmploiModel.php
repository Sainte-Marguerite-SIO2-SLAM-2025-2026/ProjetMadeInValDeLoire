<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ModeEmploiModel extends Model
{
    protected $table = 'mode_emploi';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['explication_1', 'explication_2', 'explication_3', 'activite_numero'];

}