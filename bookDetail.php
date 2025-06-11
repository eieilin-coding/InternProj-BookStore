<?php
// Include your database connection file
require_once 'db_config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid Book ID');
}

$book_id = intval($_GET['id']);

// Fetch book details with author and category
$sql = "SELECT b.*, a.name AS author_name, c.name AS category_name 
        FROM books b 
        JOIN authors a ON b.author_id = a.id 
        JOIN categories c ON b.category_id = c.id 
        WHERE b.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Book not found.");
}

$book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['title']) ?> - Book Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">📚 View Details</a>
        </div>
    </nav>

    <div class="container" style="height: 500px">
        <div class="row g-4">
            <div class="col-md-4">
                <img src="_admins/photos/<?= htmlspecialchars($book['photo']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-8">
                <h2><?= htmlspecialchars($book['title']) ?></h2>
                <p><strong>Author:</strong> <?= htmlspecialchars($book['author_name']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($book['category_name']) ?></p>
                <p><strong>Published Date:</strong> <?= htmlspecialchars(date('F d, Y', strtotime($book['published_date']))) ?></p>
                <hr>
                <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                <a href="_admins/files/<?= htmlspecialchars($book['file']) ?>" class="btn btn-danger mt-3" download>
                <i class="fa-solid fa-circle-down"></i> Download PDF</a>
                <a href="index.php" class="btn btn-secondary mt-3"> Back to Books</a>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        &copy; <?= date('Y') ?> BookStore
    </footer>
</body>
</html>
