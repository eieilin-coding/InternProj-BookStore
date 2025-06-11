<?php
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\BooksTable;

$table = new BooksTable(new MySQL);

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$books = $table->showAll($limit, $offset);
$total = $table->totalCount();
$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
<nav class="navbar bg-dark navbar-dark navbar-expand-lg shadow-sm">
    <div class="container">
        <a href="#" class="navbar-brand fw-bold">Books</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a href="admin.php" class="nav-link">Admin</a></li>
            <li class="nav-item"><a href="_actions/logout.php" class="nav-link">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="mt-4 mb-4">
        <a href="book.php" class="btn btn-sm btn-outline-success">Create</a>
        <!-- ✅ Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    </div>

    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Photo</th>
            <th>File</th>
            <th>Action</th>
        </tr>

        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book->id) ?></td>
                <td><?= htmlspecialchars($book->title) ?></td>
                <td><?= htmlspecialchars($book->author) ?></td>
                <td><?= htmlspecialchars($book->category) ?></td>
                <td><?= htmlspecialchars($book->photo) ?></td>
                <td><?= htmlspecialchars($book->file) ?></td>
                <td>
                    <div class="btn-group">
                        <a href="bookUpdF.php?id=<?= $book->id ?>" class="btn btn-sm btn-outline-primary">Update</a>
                        <?php if ($book->temp_delete): ?>
                            <a href="_admins/showBook.php?id=<?= $book->id ?>" class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure?')">Hide</a>
                        <?php else: ?>
                            <a href="_admins/hideBook.php?id=<?= $book->id ?>" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure?')">Show</a>
                        <?php endif; ?>
                        <a href="_admins/bookDel.php?id=<?= $book->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
