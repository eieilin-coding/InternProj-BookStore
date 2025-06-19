<?php
include("../vendor/autoload.php");

require_once '../db_config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid Book ID');
}

$book_id = intval($_GET['id']);

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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <style>
        #download .btn {
            display: flex;
        }

        #download .btn i {
            margin-right: 5px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">

        <div class="container">
            <a class="navbar-brand" href="index.php">📚 View Details</a>
        </div>
    </nav>

    <div class="container mt-4" style="height: 520px">
        <div class="row g-4">
            <div class="col-md-4">
                <img src="../_admins/photos/<?= htmlspecialchars($book['photo']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-8">
                <h2><?= htmlspecialchars($book['title']) ?></h2>
                <p><strong>Author:</strong> <?= htmlspecialchars($book['author_name']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($book['category_name']) ?></p>
                <p><strong>Published Date:</strong> <?= htmlspecialchars(date('F d, Y', strtotime($book['published_date']))) ?></p>
                <hr>
                <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>

                <div class="d-flex justify-content-center gap-3 my-4" id="download">

                    <a href="../download.php?id=<?= $book['id'] ?>" class="btn btn-danger px-4 py-2">
                        <i class="fa-solid fa-circle-down"></i> Download PDF </a>
                    <a href="index.php" class="btn btn-secondary px-4 py-2">Back to Books</a>
                </div>
                <p id="count"><strong>Downloads:</strong> <?= $book['download_count'] ?></p>
            </div>

        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        &copy; <?= date('Y') ?> BookStore
    </footer>
</body>

</html>