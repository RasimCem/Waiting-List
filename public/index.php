<?php
require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\UserController;
use app\controllers\WaitingListController;

$current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$request = str_replace("http://localhost/waiting-list", '', $current_url);
$method = $_SERVER['REQUEST_METHOD'];


if ($request === "/" && $method === "GET") {
    $waitingListController = new WaitingListController();
    $waitingListController->index();
} elseif ($request === "/register" && $method === "POST") {
    $userController = new UserController();
    $userController->register();
} elseif ($request === "/join" && $method === "POST") {
    $waitingListControlle2r = new WaitingListController();
    $waitingListControlle2r->joinToWaitingList();
}elseif ($request === "/list" && $method === "GET") {
    $waitingListControlle2r = new WaitingListController();
    $waitingListControlle2r->getList();
}
 else {
    echo "Route not found!";
    die();
}

?>