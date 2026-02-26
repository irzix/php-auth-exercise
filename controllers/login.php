<?php

namespace hfm\controllers;

use hfm\Models\User;

$error = '';

if ($_POST) {
    if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = 'Invalid request. Please refresh the page and try again.';
        return;
    }

    $user = new User($pdo);
    $login = $user->login($_POST['email'], $_POST['password']);
    if ($login['status']) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['user_id'] = $login['id'];
        header("Location: /dashboard");
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}