<?php

namespace app\repositories;

use PDO;
use Exception;

class UserRepository
{

    public function create(string $username)
    {
        $connection = getDBConnection();
        $user = $connection->query("SELECT * from users WHERE username = '{$username}'")->fetch(PDO::FETCH_ASSOC);
        if($user) throw new Exception("Username already exists");
        $query = $connection->prepare('INSERT INTO users (username) VALUES (:username)');
        $query->bindParam(':username', $username);
        $query->execute();
    }


}