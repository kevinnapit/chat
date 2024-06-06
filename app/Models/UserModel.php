<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'profile_image',
     'created_at', 'update_at', 'deleted_at','is_online'];
    protected $useTimestamps = true;

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
