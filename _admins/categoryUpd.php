<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Helpers\HTTP;

$id = $_POST['id'];
$name = $_POST['name'];

$table = new CategoriesTable(new MySQL);
$table->update($id, $name);

HTTP::redirect("/testCategoryAll.php");