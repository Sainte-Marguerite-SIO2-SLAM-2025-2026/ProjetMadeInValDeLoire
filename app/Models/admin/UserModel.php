<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user', 'mdp'];

    public function getUser($user)
    {
        return $this->where('user', $user)->first();
    }
}
