<?php
include("vendor/autoload.php");

require_once 'db_config.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?> - Book Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <style>
        #download .btn {
            display: flex;
            align-items: center;
        }

        * {
            margin: 0;
            box-sizing: border-box;
        }

        #download .btn i {
            margin-right: 8px;
        }

        .book-cover {
        
            width: 100%;
            height: auto;
            max-height: 500px;
            min-height: 300px;
        }

        .book-details {
            padding-top: 1.5rem;
        }

        @media (min-width: 768px) {
            .book-details {
                padding-top: 0;
                padding-left: 1rem;
            }
        }

        .footer {
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">📚 View Details</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container my-4 my-md-5">
        <div class="row g-4">
            <!-- Book Image -->
            <div class="col-12 col-md-5">
                <img src="_admins/photos/<?= htmlspecialchars($book['photo']) ?>"
                    alt="<?= htmlspecialchars($book['title']) ?>"
                    class="img-fluid rounded shadow book-cover">
            </div>

            <!-- Book Details -->
            <div class="col-12 col-md-7 book-details">
                <h1 class="h2 mb-3"><?= htmlspecialchars($book['title']) ?></h1>
                <div class="mb-3">
                    <p class="mb-1"><strong>Author:</strong> <?= htmlspecialchars($book['author_name']) ?></p>
                    <p class="mb-1"><strong>Category:</strong> <?= htmlspecialchars($book['category_name']) ?></p>
                    <p class="mb-3"><strong>Published Date:</strong> <?= htmlspecialchars(date('F d, Y', strtotime($book['published_date']))) ?></p>
                </div>

                <hr>

                <div class="mb-4">
                    <p class="lead">Description:</p>
                    <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 mb-4" id="download">
                    <a href="download.php?id=<?= $book['id'] ?>" class="btn btn-danger px-4 py-2">
                        <i class="fa-solid fa-circle-down"></i> Download PDF
                    </a>
                    <a href="index.php" class="btn btn-secondary px-4 py-2">Back to Books</a>
                </div>

                <p id="count"><strong>Downloads:</strong> <?= $book['download_count'] ?></p>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 footer">
        <div class="container">
            &copy; <?= date('Y') ?> BookStore
        </div>
    </footer>
</body>

</html>