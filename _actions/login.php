<?php

include("../vendor/autoload.php");
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;
//use Helpers\Auth;

//$auth = Auth::check();

$table = new UsersTable(new MySQL);


$email = $_POST['email'];
$password = $_POST['password'];

$user = $table->find($email, $password);

if($user) {
    if($user->suspended)
    {
     HTTP::redirect("/signIn.php", "suspended=account");
     }
        session_start();
        $_SESSION['user'] = $user;

       if ($user->role_id == 3) {
        HTTP::redirect("/admin.php", "login=success");
    } else {
        HTTP::redirect("/index.php", "login=success");
    }
    
}else{
    HTTP::redirect("/signIn.php", "incorrect=login");
}

