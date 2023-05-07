<?php

namespace app\services;

use app\repositories\UserRepository;
use app\repositories\WaitingListRepository;

class WaitingListService
{
    public function create(string $username)
    {
        $waitingListRepository = new WaitingListRepository();
        $waitingListRepository->create($username);
    }

    public function getList()
    {
        $waitingListRepository = new WaitingListRepository();
        return $waitingListRepository->getList();
    }
}