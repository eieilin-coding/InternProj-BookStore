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
    <title>Add New Book</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
      
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
           background-color:rgb(169, 131, 196);
        }
        .form-group label {
            font-weight: bold;
        }

        div #btn {
            display: flex;
            text-align: center;
        }

    </style>
</head>
<body>
<div class="container bg-warning" >
    <h1 class="h3 mb-4 font-weight-normal text-center">Add New Book</h1>

      <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-info">
               Successfully update author
            </div>
        <?php endif ?>

    <form action="_admins/bookUpd.php" method="POST" enctype="multipart/form-data">

        <div class="form-group mb-3">
            <input type="hidden" name="id" value="<?= $book['id'] ?>">
            <label for="category_id">Select a Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php while($cat = $categories->fetch_assoc()): ?>

                    <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $book['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                     <?= htmlspecialchars($cat['name']) ?>
                    </option>

                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="author_id">Select an Author:</label>
            <select name="author_id" id="author_id" class="form-control" required>
                <option value="">-- Select Author --</option>
                <?php while($auth = $authors->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($auth['id']) ?>" <?= $book['author_id'] == $auth['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($auth['name']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="title">Book Title:</label>
            <input type="text" name="title" id="title" class="form-control" 
            placeholder="Enter book title" value="<?= $book['title'] ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="publisher">Publisher:</label>
            <input type="text" name="publisher" id="publisher" class="form-control" 
            placeholder="Enter publisher name" value="<?= $book['publisher'] ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="published_date">Published Date:</label>
            <?php
        $date = date('Y-m-d', strtotime($book['published_date']));
        ?>
        <input type="date" name="published_date" id="published_date" 
        class="form-control" value="<?= $date ?>" required>

        </div>

        <div class="form-group mb-3">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>
            <?= htmlspecialchars($book['description']) ?>
            </textarea>

        </div>

        <div class="form-group mb-3">
            <label for="book_photo">Upload Book Photo:</label>
            <?php if (!empty($book['photo'])): ?>
                <p>Current: <?= htmlspecialchars($book['photo']) ?></p>
            <?php endif; ?>
            <!-- Hidden inputs to retain old values -->
            <input type="hidden" name="old_photo" value="<?= htmlspecialchars($book['photo']) ?>">
            <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
            <small class="form-text text-muted">Max file size: 5MB. Accepted formats: JPG, PNG, GIF.</small>
        </div>

        <div class="form-group mb-4">
            <label for="book_pdf">Upload Book PDF:</label>
            <?php if (!empty($book['file'])): ?>
                <p>Current: <?= htmlspecialchars($book['file']) ?></p>
            <?php endif; ?>
            <input type="hidden" name="old_file" value="<?= htmlspecialchars($book['file']) ?>">
            <input type="file" id="pdf" name="pdf" class="form-control" accept="application/pdf">

            <small class="form-text text-muted">Max file size: 20MB. Accepted format: PDF.</small>
        </div>
           
        <div class="d-grid gap-2 d-md-block" id="btn">
            <button class="btn btn-primary" type="submit" name="upload">Button</button>
            <button class="btn btn-secondary" type="button" onclick="window.history.back()">Cancel</button>
        </div>
    </form>
</div>

</body>
</html>