<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = "pengguna";
    protected $primaryKey = "no";
    protected $useTimestamps = true;
    protected $allowedFields = ['id', 'password', 'nama'];
}
