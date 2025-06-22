<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\BooksTable;
use Helpers\HTTP;

$id = $_GET['id'];

$table = new BooksTable(new MySQL);
$table->showBook($id);

HTTP::redirect("/testBookAll.php");