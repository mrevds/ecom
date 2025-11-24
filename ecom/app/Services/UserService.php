<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService {
    public function __construct(
        private UserRepository  $repository
    ){}
    public function registerCustomer(string $username, string $password): User
    {
        return $this->repository->createUser([
            'username' => $username,
            'password' => $password,
            'role_id' => 1,
        ]);
    }
    public function registerSeller(string $username, string $password): User
    {
        return $this->repository->createUser([
            'username' => $username,
            'password' => $password,
            'role_id' => 2,
        ]);
    }
    public function login(string $username, string $password): ?User
    {
        $user = $this->repository->findByName($username);

        if (!$user || $user->password !== $password) {
            return null;
        }

        return $user;
    }
}
