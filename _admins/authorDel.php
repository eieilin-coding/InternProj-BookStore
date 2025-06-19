<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
use Helpers\HTTP;

$id = $_GET['id'];

$table = new AuthorsTable(new MySQL);
$table->delete($id);

HTTP::redirect("../authorAll.php");
