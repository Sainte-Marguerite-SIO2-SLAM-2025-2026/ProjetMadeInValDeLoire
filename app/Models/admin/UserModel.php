<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'numero';

    protected $allowedFields = ['login', 'mdp'];

    public function getUser($login)
    {
        return $this->where('login', $login)->first();
    }
}
