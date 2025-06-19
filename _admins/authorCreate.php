<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
use Helpers\HTTP;

$table = new AuthorsTable(new MySQL);
$table->insertAuthor([
    "name" => $_POST['name'],
    "email" => $_POST['email'],
    "phone" => $_POST['phone'],
    "address" => $_POST['address'],

]);

HTTP::redirect("/authorAll.php", "author=success");
