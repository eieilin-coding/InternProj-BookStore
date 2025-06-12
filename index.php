<?php
include("vendor/autoload.php");

    use Libs\Database\MySQL;
    use Libs\Database\CategoriesTable;
    use Libs\Database\AuthorsTable;
    use Libs\Database\BooksTable;
    use Libs\Database\UsersTable;
    use Helpers\Auth;

    // $auth = Auth::check();

    // $table = new UsersTable(new MySQL);
    // $users = $table->all();
    
    $table = new CategoriesTable(new MySQL);
    $categories = $table->showAll();

    $table = new AuthorsTable(new MySQL);
    $authors = $table->showAll();

    $table = new BooksTable(new MySQL);
    $books = $table->showAll();

$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search !== '') {
    $books = $table->searchBooks($search, $limit, $offset);
    $total = $table->searchBooksCount($search);
} else {
    $books = $table->showAll($limit, $offset);
    $total = $table->totalCount();
}
$total_pages = ceil($total / $limit);



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>BookStore</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js" defer></script>
  <style>
    .navbar {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card img {
      height: 200px;
      object-fit: cover;
    }

    .carousel-item img {
      max-height: 400px;
      object-fit: cover;
    }
    .form #search-box {
            text-align: center;
        }
  </style>
</head>

<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <i class="fas fa-book-open me-2"></i> <strong>📚 BookStore</strong>
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
              <ul class="dropdown-menu dropdown-menu-dark">              
                <?php foreach($categories as $category): ?>
                  <li> <a class="dropdown-item" herf="#" value="<?= $category->id ?>"><?= $category->name ?></a></li>
                <?php endforeach; ?>
              </ul>
          </li>
        <li class="nav-item dropdown">
              <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
               Authors
              </button>
              <ul class="dropdown-menu dropdown-menu-dark">
                <?php foreach($authors as $author): ?>
                  <li> <a class="dropdown-item" herf="#" value="<?= $author->id ?>"><?= $author->name ?></a></li>
                <?php endforeach; ?>
              </ul>
        </li>
      

        <form class="d-flex me-2" role="search" id="search-box" method="get" action="">
              <input class="form-control me-2" type="search" name="q" placeholder="Search by title, author, or category" aria-label="Search" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
              <button class="btn btn-outline-success" type="submit">Search</button>
        </form>


      <li class="nav-item">
          <button class="nav-link btn btn-dark" href="#" >Contact Us</button>
      </li>

      <!-- <li class="nav-item">
             <a href="profile.php" class="nav-link">
                  <?= $auth->name ?>
               </a>
        </li> -->

      <li class="nav-item dropdown">
              <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
               Account
              </button>
              <ul class="dropdown-menu dropdown-menu-dark">
                  <li> <a class="dropdown-item" href="/bookstore/register.php" >Register</a></li>
                  <li> <a class="dropdown-item" href="signIn.php" >Login</a></li>
                  <li> <a class="dropdown-item" href="/bookstore/_actions/logout.php" >Logout</a></li>
                
              </ul>
        </li>
      </ul>
    </div>
    </div>
  </div>
</nav>

<!-- ✅ Carousel -->
<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="_admins/photos/read1.jpg" class="d-block w-100" alt="Banner 1">
      <div class="carousel-caption d-none d-md-block">
        <h2>Welcome to BookStore</h2>
        <p>Explore amazing books today.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="_admins/photos/banner2.jpg" class="d-block w-100" alt="Banner 2">
      <div class="carousel-caption d-none d-md-block">
        <h2>Latest Releases</h2>
        <p>New arrivals available now!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="_admins/photos/read2.jpg" class="d-block w-100" alt="Banner 2">
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

<!-- ✅ Book List -->
<div class="container my-5">
  <!-- <h2 class="mb-4 text-center">Latest Books</h2> -->

  <h2 class="mb-4 text-center">
  <?= $search !== '' ? "Search Results for '$search'" : 'Latest Books' ?>
  </h2>
  <div class="row">
    <?php foreach( $books as $book ): ?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="_admins/photos/<?= htmlspecialchars($book->photo) ?>" class="card-img-top" loading="lazy" alt="<?= htmlspecialchars($book->title) ?>">
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><?= htmlspecialchars($book->title) ?></h6>
            <!-- <p class="card-text small text-muted"><?= htmlspecialchars($book->publisher) ?></p> -->
            <a href="bookDetail.php?id=<?= $book->id ?>" class="btn btn-primary mt-auto">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

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

<!-- ✅ Footer -->
<footer class="bg-dark text-white text-center py-3">
  &copy; <?= date('Y') ?> BookStore
</footer>

<!-- ✅ FontAwesome for Icons (optional, remove if unused) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>
