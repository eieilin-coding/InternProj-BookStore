<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Helpers\HTTP;


$table = new CategoriesTable(new MySQL);
$table->insertCategories([
    "name" => $_POST['name'],
]);

HTTP::redirect("/categoryAll.php", "category=success");