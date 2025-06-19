<?php
include("vendor/autoload.php");

session_start();

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Libs\Database\AuthorsTable;
use Libs\Database\BooksTable;
use Libs\Database\UsersTable;

$table = new CategoriesTable(new MySQL);
$categories = $table->showAll();

$table = new AuthorsTable(new MySQL);
$authors = $table->authorList();

$table = new UsersTable(new MySQL);
$users = $table->all();


$table = new BooksTable(new MySQL);
$books = $table->showAll();

$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$author = isset($_GET['author']) ? trim($_GET['author']) : '';
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search !== '') {
    $books = $table->searchBooks($search, $limit, $offset);
    $total = $table->searchBooksCount($search);
} elseif ($category !== '') {
    $books = $table->getBooksByCategory($category, $limit, $offset);
    $total = $table->getBooksByCategoryCount($category);
} elseif ($author !== '') {
    $books = $table->getBooksByAuthor($author, $limit, $offset);
    $total = $table->getBooksByAuthorCount($author);
} else {
    $books = $table->showAll($limit, $offset);
    $total = $table->totalCount();
}
$total_pages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Index Page</title>
    <?php include("header.php"); ?>
    <script src="js/bootstrap.bundle.min.js" defer></script>
    <style>
        .carousel-item img {
            max-height: 450px;
            /* object-fit: cover; */
            width: 100%;
        }

        .form #search-box {
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <strong>📚 BookStore</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="categoryDropdown" style="max-height: 180px; overflow-y: auto;">
                            <?php foreach ($categories as $category): ?>
                                <li> <a class="dropdown-item" href="?category=<?= urlencode($category->name) ?>"><?= $category->name ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Authors
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="authorsDropdown" style="max-height: 180px; overflow-y: auto;">
                            <?php foreach ($authors as $author): ?>
                                <li>
                                    <a class="dropdown-item" href="?author=<?= urlencode($author->name) ?>">
                                        <?= htmlspecialchars($author->name) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <form class="d-flex me-2" role="search" id="search-box" method="get" action="">
                        <input class="form-control me-2" type="search" name="q" placeholder="Search book" aria-label="Search" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <li class="nav-item">
                        <button class="nav-link btn btn-dark" href="#">Contact Us</button>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark">
                            <?php if (isset($_SESSION['user']) and $_SESSION['user']->role_id >= 2): ?>
                                <li><a class="dropdown-item" href="/bookstore/admin.php">Admin</a></li>
                                <li><a class="dropdown-item" href="/bookstore/_actions/logout.php">Logout</a></li>
                            <?php elseif (isset($_SESSION['user']) and $_SESSION['user']->role_id == 1): ?>
                                <li><a class="dropdown-item" href="/bookstore/_actions/logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="/bookstore/register.php">Register</a></li>
                                <li><a class="dropdown-item" href="signIn.php">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    <div class="container-fluid py-2">
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="_admins/photos/read1.jpg" class="img-fluid rounded shadow" alt="Banner 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Welcome to BookStore</h2>
                        <p>Explore amazing books today.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="_admins/photos/bookLight.jpg" class="img-fluid rounded shadow" alt="Banner 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Latest Releases</h2>
                        <p>New arrivals available now!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="_admins/photos/robot.png" class="img-fluid rounded shadow" alt="Banner 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Explore new book!</h2>
                        <p>Feed your brain!</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <h4 class="mt-2 text-center">
        Available Books
    </h4>

    <div class="container mt-4">
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="_admins/photos/<?= htmlspecialchars($book->photo) ?>" class="card-img-top"
                            style="max-width: 100%,height:200px;" class="img-fluid rounded shadow" loading="lazy" alt="<?= htmlspecialchars($book->title) ?>">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h6 class="card-title"><?= htmlspecialchars($book->title) ?></h6>
                            <a href="books/bookDetail.php?id=<?= $book->id ?>" class="btn btn-outline-primary mt-auto" style="width: 115px;">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <div>
        <footer class="bg-dark text-white text-center py-3">
            &copy; <?= date('Y') ?> BookStore
        </footer>
    </div>
</body>

</html>