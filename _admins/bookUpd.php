<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\BooksTable;
use Helpers\HTTP;

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $photo_name = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $type = $_FILES['photo']['type'];

    move_uploaded_file($tmp_name, __DIR__ . "/photos/" . $photo_name);
} else {
    $photo_name = $_POST['old_photo'];
}

if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['pdf']['name'];
    $tmp_name_pdf = $_FILES['pdf']['tmp_name'];
    $type_pdf = $_FILES['pdf']['type'];


    move_uploaded_file($tmp_name_pdf, __DIR__ . "/files/" . $file_name);
} else {

    $file_name = $_POST['old_file'];
}
$id = $_POST['id'];
$author_id = $_POST['author_id'];
$category_id = $_POST['category_id'];
$title = $_POST['title'];
$publisher = $_POST['publisher'];
$published_date = $_POST['published_date'];
$description = $_POST['description'];
$photo = $photo_name;
$file = $file_name;

$table = new BooksTable(new MySQL);
$table->update($id, $author_id, $category_id, $title, $publisher, $published_date, $description, $photo, $file);

HTTP::redirect("/testBookAll.php");
