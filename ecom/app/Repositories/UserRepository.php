<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public function createUser(array $data)
    {
        return User::create($data);
    }
    public function findByName(string $username)
    {
        return User::where('username', $username)->first();
    }
}
