<?php

namespace hfm\controllers;

use hfm\Models\User;
use hfm\helpers\Validator;


$error = "";

if ($_POST) {
    if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = 'Invalid request. Please refresh the page and try again.';
        return;
    }

    $validator = new Validator();
    $validate = $validator->register($_POST);
    if (!$validate[0]) {
        $error = $validate[1];
    } else {
        $user = new User($pdo);
        $result = $user->save($_POST);
        if ($result) {
            header("Location: /login");
            exit;
        } else {
            $error = "Contact Suppport";
        }
    }
}