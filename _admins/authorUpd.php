<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
use Helpers\HTTP;

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$table = new AuthorsTable(new MySQL);
$table->update($id, $name, $email, $phone, $address);

HTTP::redirect("/authorAll.php");