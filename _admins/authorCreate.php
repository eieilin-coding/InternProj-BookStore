<?php
session_start();
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
use Helpers\HTTP;

$table = new AuthorsTable(new MySQL);

function test_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$name = isset($_POST['name']) ? test_input($_POST['name']) : '';
$email = isset($_POST['email']) ? test_input($_POST['email']) : '';
$phone = isset($_POST['phone']) ? test_input($_POST['phone']) : '';
// $address = isset($_POST['address']) ? test_input($_POST['address']) : '';

if (empty($_POST['name'])) {
  $errors['name'] = 'Name is required';
}
if (empty($_POST['email'])) {
  $errors['email'] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors['email'] = "Invalid email format";
}
if (empty($phone)) {
  $errors['phone'] = "Phone Number is required";
}

if ($errors) {
  $_SESSION['authorCreate_errors'] = $errors;
  $_SESSION['old_data'] = $_POST;
  HTTP::redirect("/testAuthor.php");
}

$table->insertAuthor([
    "name" => $_POST['name'],
    "email" => $_POST['email'],
    "phone" => $_POST['phone'],
    "address" => $_POST['address'],

]);

HTTP::redirect("/testAuthorAll.php", "author=success");
