<?php
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\BooksTable;

$id = $_GET['id'];

$table = new BooksTable(new MySQL);
$book = $table->find($id);

require_once 'db_config.php';

$categories = $conn->query("SELECT id, name FROM categories");
$authors = $conn->query("SELECT id, name FROM authors");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Book</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style2.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <style>
        body {   
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('_admins/photos/read1.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">📚 Bookstore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="bookAll.php"><i class="fas fa-book me-2"></i>Book</a>
                </li>
                <li class="nav-item"><a href="index.php" class="nav-link"><i class="fas fa-home me-1"></i>Home</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="_actions/logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container bg-white shadow rounded p-4 my-0">
    <h1 class="h4 mb-4 text-center">Edit Book</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-info">
            Successfully update book
        </div>
    <?php endif ?>

    <form action="_admins/bookUpd.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="category_id" class="form-label fw-semibold">Category</label>
                <select name="category_id" id="category_id" class="form-select" required style="height: 50px ;overflow-y: auto;">
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $book['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="author_id" class="form-label fw-semibold">Author</label>
                <select name="author_id" id="author_id" class="form-select" required style="height: 50px ;overflow-y: auto;">
                    <option value="">-- Select Author --</option>
                    <?php while ($auth = $authors->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($auth['id']) ?>" <?= $book['author_id'] == $auth['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($auth['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="title" class="form-label fw-semibold">Book Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    placeholder="Enter book title" value="<?= $book['title'] ?>" required>
            </div>

            <div class="col-md-6">
                <label for="publisher" class="form-label fw-semibold">Publisher</label>
                <input type="text" name="publisher" id="publisher" class="form-control"
                    value="<?= $book['publisher'] ?>" placeholder="Enter publisher" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="published_date" class="form-label fw-semibold">Published Date</label>
                <?php
                $date = date('Y-m-d', strtotime($book['published_date']));
                ?>
                <input type="date" name="published_date" id="published_date"
                    class="form-control" value="<?= $date ?>" required>
            </div>

            <div class="col-md-6">
                <?php if (!empty($book['photo'])): ?>
                    <p>Current: <?= htmlspecialchars($book['photo']) ?></p>
                <?php endif; ?>
                <!-- Hidden inputs to retain old values -->
                <input type="hidden" name="old_photo" value="<?= htmlspecialchars($book['photo']) ?>">
                <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                <small class="text-muted">Max: 5MB (JPG, PNG, GIF)</small>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>
            <?= htmlspecialchars($book['description']) ?></textarea>
        </div>

        <div class="mb-4">
            <label for="book_pdf" class="form-label fw-semibold">Upload Book PDF</label>
            <?php if (!empty($book['file'])): ?>
                <p>Current: <?= htmlspecialchars($book['file']) ?></p>
            <?php endif; ?>
            <input type="hidden" name="old_file" value="<?= htmlspecialchars($book['file']) ?>">
            <input type="file" id="pdf" name="pdf" class="form-control" accept="application/pdf">
            <small class="text-muted">Max: 20MB (PDF only)</small>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-primary px-4" name="upload">Update</button>
            <button type="button" class="btn btn-secondary px-4" onclick="window.history.back()">Cancel</button>
        </div>

    </form>
</div>

</body>

</html>