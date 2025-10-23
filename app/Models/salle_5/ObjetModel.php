<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ObjetModel extends Model
{
    protected $table = 'objet';
    protected $primaryKey = 'numero';
    protected $returnType = 'object';
    protected $allowedFields = ['libelle', 'image', 'salle_numero', 'pos_x', 'pos_y'];

}