<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Helpers\HTTP;

$id = $_GET['id'];

$table = new CategoriesTable(new MySQL);
$table->hideCategory($id);

HTTP::redirect("/testCategoryAll.php");