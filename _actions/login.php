<?php

include("../vendor/autoload.php");


use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$remember = isset($_POST['remember']);

$table = new UsersTable(new MySQL);
$user = $table->find($email, $password);

if ($user) {
    if ($user->suspended) {
        HTTP::redirect("/signIn.php", "suspended=account");
    }
    
    $_SESSION['user'] = $user;

    // ✅ Remember Me: Set cookie if checked
    if ($remember) {
        // Create a unique token for the user
        $token = bin2hex(random_bytes(16));
        setcookie("remember_token", $token, time() + (86400 * 30), "/"); // 30 days

        // Save the token in the database
        $table->saveRememberToken($user->id, $token);
    }
    if ($user->role_id >= 2) {
        HTTP::redirect("/testAdmin.php", "login=success");
    } else {
        HTTP::redirect("/index.php", "login=success");
    }
} else {
    HTTP::redirect("/signIn.php", "incorrect=login");
}
