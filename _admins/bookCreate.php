<?php

include("../vendor/autoload.php");

use Helpers\HTTP;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $photo_name = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $type = $_FILES['photo']['type'];

    move_uploaded_file($tmp_name, __DIR__ . "/photos/" . $photo_name);
} else {

    $photo = null; // Or a default image name
}

if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['pdf']['name'];
    $tmp_name_pdf = $_FILES['pdf']['tmp_name'];
    $type_pdf = $_FILES['pdf']['type'];


    move_uploaded_file($tmp_name_pdf, __DIR__ . "/files/" . $file_name);
} else {
    // Handle cases where PDF is not uploaded or an error occurred
    $file_name = null; // Or a default PDF name
}

$author_id = $_POST['author_id'];
$category_id = $_POST['category_id'];
$title = $_POST['title'];
$publisher = $_POST['publisher'];
$published_date = $_POST['published_date'];
$description = $_POST['description'];
$photo = $photo_name; // Make sure your database column is 'photo_name'
$file = $file_name;   // Make sure your database column is 'pdf_name'

if (
    $author_id && $category_id && $title && $publisher
    && $published_date && $description && $photo && $file
) {
    $query = "INSERT INTO books(author_id, category_id, title, publisher,
        published_date, description, photo, file) VALUES (?,?,?,?,?,?,?,?)";

    $statement = $conn->prepare($query);

    if (!$statement) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $bind = $statement->bind_param(
        "iissssss",
        $author_id,
        $category_id,
        $title,
        $publisher,
        $published_date,
        $description,
        $photo,
        $file
    );

    if (!$bind) {
        die("Bind failed: (" . $statement->errno . ") " . $statement->error);
    }

    if ($statement->execute()) {
        HTTP::redirect("/bookAll.php", "info=success");
    } else {
        HTTP::redirect("/bookAll.php", "info=error");
    }
} else {
    die("Execute failed: (" . $statement->errno . ") " . $statement->error);
}
