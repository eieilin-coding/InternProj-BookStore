<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user'])) {
    header('Location: signIn.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid book ID.');
}

$book_id = intval($_GET['id']);

$sql = "SELECT file, title, download_count FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Book not found.");
}

$book = $result->fetch_assoc();
$file_path = "_admins/files/" . $book['file'];

if (!file_exists($file_path)) {
    die("File not found.");
}

$update = $conn->prepare("UPDATE books SET download_count = download_count + 1 WHERE id = ?");
$update->bind_param("i", $book_id);
if (!$update->execute()) {
    die("Failed to update download count.");
}
$update->close();

// Now serve the file
if (ob_get_level()) {
    ob_end_clean(); // Clear any existing output buffer
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));
readfile($file_path);
exit();
