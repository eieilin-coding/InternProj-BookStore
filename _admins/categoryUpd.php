<?php
session_start();
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Helpers\HTTP;

$id = $_POST['id'];
$name = $_POST['name'];

function test_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$name = isset($_POST['name']) ? test_input($_POST['name']) : '';

if (empty($_POST['name'])) {
  $errors['name'] = 'Update name is required';
}

if ($errors) {
  $_SESSION['category_errors'] = $errors;
  $_SESSION['old_data'] = $_POST;
  HTTP::redirect("/testCategoryAll.php");
} 

$table = new CategoriesTable(new MySQL);
$table->update($id, $name);

HTTP::redirect("/testCategoryAll.php");