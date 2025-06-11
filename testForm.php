<?php
//test file
// DB connection
$conn = new mysqli("localhost", "root", "", "bookstore");

// Fetch categories and authors
$categories = $conn->query("SELECT id, name FROM categories");
$authors = $conn->query("SELECT id, name FROM authors");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
     <nav class="navbar bg-dark navbar-dark navbar-expand-lg shadow-sm" class="col-12 col-md-12 col-lg-3">
        <div class="container">
            <a href="#" class="navbar-brand fw-bold"><i class="fa-solid fa-book" style="color: #dcb804;"></i>
            <span class="ms-2">BookStore</span></a>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
              <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
              </button>
              <ul class="dropdown-menu dropdown-menu-dark">              
                <?php while($cat = $categories->fetch_assoc()): ?>
                  <li> <a class="dropdown-item" herf="#" value="<?= $cat['id'] ?>"><?= $cat['name'] ?></a></li>
                <?php endwhile; ?>
              </ul>
              </li>

              <li class="nav-item dropdown">
              <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
               Authors
              </button>
              <ul class="dropdown-menu dropdown-menu-dark">
                <?php while($auth = $authors->fetch_assoc()): ?>
                  <li> <a class="dropdown-item" herf="#" value="<?= $auth['id'] ?>"><?= $auth['name'] ?></a></li>
                <?php endwhile; ?>
              </ul>
              </li>

               <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <li class="nav-item">
                   <a href="admin.php" class="nav-link">Admin</a>
                </li>
                <li class="nav-item">
                    <a href="_actions/logout.php" class="nav-link"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <form method="POST" action="insert_book.php">
    <label>Book Title:</label>
    <input type="text" name="title" required><br>

    <label>Category:</label>
    <select name="category_id" required>
        <option value="">Select Category</option>
        <?php while($cat = $categories->fetch_assoc()): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
        <?php endwhile; ?>
    </select><br>

    <label>Author:</label>
    <select name="author_id" required>
        <option value="">Select Author</option>
        <?php while($auth = $authors->fetch_assoc()): ?>
            <option value="<?= $auth['id'] ?>"><?= $auth['name'] ?></option>
        <?php endwhile; ?>
    </select><br>

    <button type="submit">Add Book</button>
</form>
</body>
</html>

