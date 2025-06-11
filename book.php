<?php

require_once 'db_config.php';

include("vendor/autoload.php");

    use Libs\Database\MySQL;
    use Libs\Database\CategoriesTable;
    use Libs\Database\AuthorsTable;
    use Libs\Database\BooksTable;
    
    $table = new CategoriesTable(new MySQL);
    $categories = $table->showAll();

    $table = new AuthorsTable(new MySQL);
    $authors = $table->authorList();

    $table = new BooksTable(new MySQL);
    $books = $table->showAll();
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
        /* body {
            background: linear-gradient(135deg,rgb(251, 196, 141),rgb(246, 145, 38));
        } */
        body {
            width: 100%;
            height: 100vh;
            background-image: linear-gradient(rgba(0,0,0,0.8),
            rgba(0,0,0,0.8)), url(_admins/photos/read.jpg);
            background-size: cover;
            background-position: center;
            padding: 10px 10%;
            color: #fff;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color:rgb(85, 54, 107);
        }
        .form-group label {
            font-weight: bold;
        }

        #button {
            display: flex; 
            text-align: center;
            
        }
    </style>
</head>
<body>
<div class="container" >
    <h1 class="h3 mb-4 font-weight-normal text-center">Add New Book</h1>

      <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-info">
               Successfully created author
            </div>
        <?php endif ?>

    <form action="_admins/bookCreate.php" method="POST" enctype="multipart/form-data">

        <div class="form-group mb-3">
            <label for="category_id">Select a Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category->id); ?>">
                        <?php echo htmlspecialchars($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="author_id">Select an Author:</label>
            <select name="author_id" id="author_id" class="form-control" required>
                <option value="">-- Select Author --</option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?php echo htmlspecialchars($author->id); ?>">
                        <?php echo htmlspecialchars($author->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="title">Book Title:</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title" required>
        </div>

        <div class="form-group mb-3">
            <label for="publisher">Publisher:</label>
            <input type="text" name="publisher" id="publisher" class="form-control" placeholder="Enter publisher name" required>
        </div>

        <div class="form-group mb-3">
            <label for="published_date">Published Date:</label>
            <input type="date" name="published_date" id="published_date" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter book description" required></textarea>
        </div>

        <!-- <?php if ($user->photo): ?>
            <img src="_admins/photos/<?= $book->photo ?>" width="300"
                clsss="img-thumbnail" />
        <?php endif ?> -->

        <div class="form-group mb-3">
            <label for="book_photo">Upload Book Photo:</label>
            <!-- <input type="file" name="photo" class="form-control">
            <button class="btn btn-secondary">Upload</button> -->
            <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required>
            <small class="form-text text-muted">Max file size: 5MB. Accepted formats: JPG, PNG, GIF.</small>
        </div>

        <div class="form-group mb-4">
            <label for="book_pdf">Upload Book PDF:</label>
            <input type="file" id="pdf" name="pdf" class="form-control" accept="application/pdf" required>
            <small class="form-text text-muted">Max file size: 20MB. Accepted format: PDF.</small>
        </div> 
        <div class="d-grid gap-2 d-md-block" id="button">
            <button type="submit" class="btn btn-primary btn-md " name="upload">Add Book</button>
            <button type="button" class="btn btn-secondary btn-md" onclick="window.history.back()">Cancel</button>
        </div>   
    </form>
    
</div>

</body>
</html>