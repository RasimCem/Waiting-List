<?php

namespace app\controllers;

use Exception;
use app\response\Response;
use app\services\WaitingListService;

class WaitingListController
{
    public function index()
    {
        $title = "denem123";

        $view = require __DIR__ . '/../views/index.php';
        return $view;
    }

    public function joinToWaitingList()
    {
        try {
            $waitingListService = new WaitingListService();
            if (!isset($_COOKIE['username']) && !$_COOKIE['username']) {
                throw new Exception('You must register first.');
            }
            $waitingListService->create($_COOKIE['username']);
            echo Response::successResponseJson("You have been added to waiting list.", [], 201);

        } catch (Exception $e) {
            echo Response::errorResponseJson($e->getMessage());
        }
    }

    public function getList()
    {
        try {
            $waitingListService = new WaitingListService();
            $list = $waitingListService->getList();
            echo Response::successResponseJson("Ok", $list, 200);

        } catch (Exception $e) {
            echo Response::errorResponseJson($e->getMessage());
        }
    }
}
?>