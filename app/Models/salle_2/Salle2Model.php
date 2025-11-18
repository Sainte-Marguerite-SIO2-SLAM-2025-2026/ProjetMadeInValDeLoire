<?php

namespace App\Models\salle_2;

use CodeIgniter\Model;

class Salle2Model extends Model
{
    protected $table = 'mail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['expediteur', 'objet', 'contenu', 'phishing', 'difficulte'];
}
