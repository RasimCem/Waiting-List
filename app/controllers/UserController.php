<?php

namespace app\controllers;

use Exception;
use app\services\UserService;

class UserController
{

    private UserService $userService;

    public function register()
    {
        try {
            $userService = new UserService();
            $userService->create($_POST['username']);
            setcookie("username", $_POST['username'], time() + (86400 * 30));
            session_start();
            $_SESSION['successMessage']  = "User created successfully.";
            header("Location: /waiting-list");
            exit();
        } catch (Exception $e) {
            session_start();
            $_SESSION['errorMessage']  = $e->getMessage();
            header("Location: /waiting-list");
            exit();
        }

    }
}