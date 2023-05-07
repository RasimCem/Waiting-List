<?php

namespace app\services;

use app\repositories\UserRepository;

class UserService
{
    public function create(string $username)
    {
        $userRepository = new UserRepository();
        $userRepository->create($username);
    }
}