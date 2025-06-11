<?php

include("../vendor/autoload.php");
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$table = new UsersTable(new MySQL);

$email = $_POST['email'];
$password = $_POST['password'];

$user = $table->find($email, $password);

if($email == "admin@gmail.com" AND $password == "password")
{
    HTTP::redirect("/admin.php");
}
else
{
    HTTP::redirect("/index.php");
}

