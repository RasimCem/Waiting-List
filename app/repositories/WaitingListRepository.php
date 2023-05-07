<?php

namespace app\repositories;

use PDO;
use Exception;

class WaitingListRepository
{

    public function create(string $username)
    {
        $connection = getDBConnection();
        $user = $connection->query("SELECT * from users WHERE username = '{$username}'")->fetch(PDO::FETCH_ASSOC);
        $alreadyInList = $connection->query("SELECT * from waiting_list WHERE user_id = '{$user['id']}'")->fetch(PDO::FETCH_ASSOC);
        if ($alreadyInList)
            throw new Exception("You are already joined to waiting list.");
        $fillableWaitingList = $connection->query("SELECT group_code, COUNT(user_id) AS user_count from waiting_list group by group_code having user_count < 4")->fetch(PDO::FETCH_ASSOC);
        $groupCode = $fillableWaitingList ? $fillableWaitingList['group_code'] : uniqid();
        $query = $connection->prepare('INSERT INTO waiting_list (user_id, group_code) VALUES (:user_id, :group_code)');
        $query->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
        $query->bindParam(':group_code', $groupCode);
        $query->execute();
    }

    public function getList()
    {
        $connection = getDBConnection();

        return $connection->query("SELECT group_code, COUNT(user_id) AS user_count from waiting_list group by group_code")->fetchAll(PDO::FETCH_ASSOC);
    }



}