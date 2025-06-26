<?php

include("../vendor/autoload.php");
include("../db_config.php");

use Helpers\HTTP;

//This file is not use. Just save to study.
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "bookstore";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Form fields
$author_id = isset($_POST['author_id']) ? intval($_POST['author_id']) : 0;
$category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$publisher = isset($_POST['publisher']) ? trim($_POST['publisher']) : '';
$published_date = isset($_POST['published_date']) ? $_POST['published_date'] : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';

// Validation errors array
$errors = [];

// Validate required fields
if (!$author_id) $errors[] = "Author is required.";
if (!$category_id) $errors[] = "Category is required.";
if (empty($title)) $errors[] = "Book title is required.";
if (empty($publisher)) $errors[] = "Publisher is required.";
if (empty($published_date)) $errors[] = "Published date is required.";
if (empty($description)) $errors[] = "Description is required.";

// Validate Photo upload
$photo_name = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Error uploading photo.";
    } else {
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_image_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($_FILES['photo']['type'], $allowed_image_types)) {
            $errors[] = "Invalid photo file type.";
        }
        if ($_FILES['photo']['size'] > $max_image_size) {
            $errors[] = "Photo file size must be 5MB or less.";
        }

        if (empty($errors)) {
            $photo_name = time() . "_" . basename($_FILES['photo']['name']);
            $photo_destination = __DIR__ . "/photos/" . $photo_name;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_destination);
        }
    }
} else {
    $errors[] = "Book cover photo is required.";
}

// Validate PDF upload
$file_name = null;
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['pdf']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Error uploading PDF.";
    } else {
        $allowed_pdf_type = 'application/pdf';
        $max_pdf_size = 20 * 1024 * 1024; // 20MB

        if ($_FILES['pdf']['type'] !== $allowed_pdf_type) {
            $errors[] = "Invalid PDF file type.";
        }
        if ($_FILES['pdf']['size'] > $max_pdf_size) {
            $errors[] = "PDF file size must be 20MB or less.";
        }

        if (empty($errors)) {
            $file_name = time() . "_" . basename($_FILES['pdf']['name']);
            $file_destination = __DIR__ . "/files/" . $file_name;
            move_uploaded_file($_FILES['pdf']['tmp_name'], $file_destination);
        }
    }
} else {
    $errors[] = "Book PDF file is required.";
}

// If errors, redirect back with error message
if (count($errors) > 0) {
    $error_message = urlencode(implode(", ", $errors));
    HTTP::redirect("/testBookAll.php", "error=" . $error_message);
    exit;
}

// Insert into database
$query = "INSERT INTO books (author_id, category_id, title, publisher, published_date, description, photo, file)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$statement = $conn->prepare($query);

if (!$statement) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$statement->bind_param(
    "iissssss",
    $author_id,
    $category_id,
    $title,
    $publisher,
    $published_date,
    $description,
    $photo_name,
    $file_name
);

if ($statement->execute()) {
    HTTP::redirect("/testBookAll.php", "success=Book successfully created");
} else {
    HTTP::redirect("/testBookAll.php", "error=Failed to create book");
}
