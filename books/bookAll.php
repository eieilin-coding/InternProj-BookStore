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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style2.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    <div class="main-content">
        <?php require_once 'navbar.php'; ?>
        <div class="d-flex content-wrapper">
            <nav class="bg-white border-end shadow-sm flex-shrink-0" id="sidebar">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link"><i class="fas fa-home me-2"></i> <span>Admin</span></a>
                    </li>
                    <li>
                        <a href="userAll.php" class="nav-link"><i class="fas fa-users me-2"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="bookAll.php" class="nav-link active"><i class="fas fa-book me-2"></i> <span>Books</span></a>
                    </li>
                    <li>
                        <a href="categoryAll.php" class="nav-link"><i class="fas fa-list-alt me-2"></i> <span>Categories</span></a>
                    </li>
                    <li>
                        <a href="authorAll.php" class="nav-link"><i class="fas fa-user-tie me-2"></i> <span>Authors</span></a>
                    </li>

                </ul>
            </nav>

            <div class="container mt-2" style="height: 580px;">
                <div class="mt-2 mb-2">
                    <a href="book.php" class="btn btn-sm btn-outline-success">Create</a>
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
        </div>
        <footer class="footer bg-dark text-white-50 py-3 sticky-bottom">
            <div class="container text-center">
                <small>&copy; 2025 Admin Panel. All rights reserved.</small>
            </div>
        </footer>
    </div>
</body>

</html>