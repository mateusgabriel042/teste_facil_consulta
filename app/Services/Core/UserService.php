<?php

namespace App\Services\Core;

use App\Models\Core\User;

class UserService
{
    public function listUsers()
    {
        return User::paginate(20);
    }
}
