<?php
session_start();
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Helpers\HTTP;

function test_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$name = isset($_POST['name']) ? test_input($_POST['name']) : '';

if (empty($_POST['name'])) {
  $errors['name'] = 'Create name is required';
}

if ($errors) {
  $_SESSION['category_errors'] = $errors;
  $_SESSION['old_data'] = $_POST;
  HTTP::redirect("/testCategoryAll.php");
} 

$table = new CategoriesTable(new MySQL);
$table->insertCategories([
    "name" => $_POST['name'],
]);

HTTP::redirect("/testCategoryAll.php", "category=success");
