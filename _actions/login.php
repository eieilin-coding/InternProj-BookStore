<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$email = $_POST['email'];
$password = $_POST['password'];

$table = new UsersTable(new MySQL);
$user = $table->find($email, $password);

if ($user) {
    if ($user->suspended) {
        HTTP::redirect("/signIn.php", "suspended=account");
    }
    session_start();
    $_SESSION['user'] = $user;

    if ($user->role_id >= 2) {
        HTTP::redirect("/testAdmin.php", "login=success");
    } else {
        HTTP::redirect("/index.php", "login=success");
    }
} else {
    HTTP::redirect("/signIn.php", "incorrect=login");
}
