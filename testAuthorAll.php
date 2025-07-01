<?php
include("vendor/autoload.php");
include("header.php");

use Helpers\HTTP;

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']->role_id == 1) {
  HTTP::redirect("/index.php", "error=unauthorized");
  exit;
}

//require_once 'db_config.php';

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
//use Helpers\Auth;

//  $auth = Auth::check();

$table = new AuthorsTable(new MySQL);
$authors = $table->showAll();

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$authors = $table->showAll($limit, $offset);
$total = $table->totalCount();
$total_pages = ceil($total / $limit);

?>
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Admin Panel</a></li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">View</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="_actions/logout.php">
              <i class="fas fa-sign-out-alt me-1"></i> Logout</a>
          </li>
        </ul>
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="index.php" class="brand-link">
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">📚 Bookstore</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="menu"
            data-accordion="false">
            <li class="nav-item">
              <a href="testAdmin.php" class="nav-link">
                <i class="fas fa-home me-2"></i>
                <p>
                  Admin
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testBookAll.php" class="nav-link">
                <i class="fas fa-book me-2"></i>
                <p>
                  Books
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testCategoryAll.php" class="nav-link">
                <i class="fas fa-list-alt me-2"></i>
                <p>
                  Categories
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testAuthorAll.php" class="nav-link active">
                <i class="fas fa-user-tie me-2"></i>
                <p>
                  Authors
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testUserAll.php" class="nav-link">
                <i class="fas fa-users me-2"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0"></h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="testAdmin.php">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Author List</li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <div class="app-content">
        <!--begin::Container-->
        <!-- <div class="container-fluid"> -->
        <!-- Info boxes -->
        <div class="container  mt-0">
          <a href="testAuthor.php" class="btn btn-sm btn-outline-success mb-2">Create</a>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tr>
                <!-- <th>ID</th> -->
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>

              </tr>
              <?php foreach ($authors as $author): ?>
                <tr>
                  <!-- <td><?= $author->id ?></td> -->
                  <td><?= $author->name ?></td>
                  <td><?= $author->email ?></td>
                  <td><?= $author->phone ?></td>
                  <td><?= $author->address ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="testAuthorUpdF.php?id=<?= $author->id ?>"
                        class="btn btn-sm btn-outline-primary">Update</a>
                      <?php if ($author->temp_delete): ?>
                        <a href="_admins/showAuthor.php?id=<?= $author->id ?>" class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure?')">SoftDel</a>
                      <?php else: ?>
                        <a href="_admins/hideAuthor.php?id=<?= $author->id ?>" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure?')">HardDel</a>
                      <?php endif; ?>
                      <a href="_admins/authorDel.php?id=<?= $author->id ?>"
                        class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </table>
          </div>
          <div class="mt-2 mb-2 center">
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
        </div>
      </div>
      <!-- </div> -->
      <!--end::Container-->
  </div>
  <!--end::App Content-->
  </main>
  <!--end::App Main-->
  <?php include("footer.php"); ?>
</body>
<!--end::Body-->

</html>