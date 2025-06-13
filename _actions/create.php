<?php
session_start();
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

function test_input($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$name = isset($_POST['name']) ? test_input($_POST['name']) : '';
$email = isset($_POST['email']) ? test_input($_POST['email']) : '';
$password = isset($_POST['password']) ? test_input($_POST['password']) : '';
$phone = isset($_POST['phone']) ? test_input($_POST['phone']) : '';
$address = isset($_POST['address']) ? test_input($_POST['address']) : '';

if (empty($_POST['name'])) {
  $errors['name'] = 'Name is required';
}
if (empty($_POST['email'])) {
  $errors['email'] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors['email'] = "Invalid email format";
}
if (empty($password)){
 $errors['password'] = "Password is required";
}


$table = new UsersTable(new MySQL);


$existingUser = $table->findByEmail($email);
if ($existingUser) {
  $errors['email'] = "This email is already registered.";
}

if ($errors) {
  $_SESSION['register_errors'] = $errors;
  $_SESSION['old_data'] = $_POST;
  HTTP::redirect("/register.php");
}

$table->insert([
  "name" => $name,
  "email" => $email,
  "password" => $password,
  "address" => $address,
  "phone" => $phone,
]);

HTTP::redirect("/signIn.php", "register=success");
