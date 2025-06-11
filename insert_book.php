<?php
//test file
$conn = new mysqli("localhost", "root", "", "bookstore");

// Get POST data
$title = $_POST['title'];
$category_id = $_POST['category_id'];
$author_id = $_POST['author_id'];

// Validate
if ($title && $category_id && $author_id) {
    $stmt = $conn->prepare("INSERT INTO books (title, category_id, author_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $title, $category_id, $author_id);
    if ($stmt->execute()) {
        echo "Book added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "All fields are required.";
}
?>
