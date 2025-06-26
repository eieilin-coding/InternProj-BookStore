<?php
include("vendor/autoload.php");
include("header.php");

require_once 'db_config.php';

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;

$table = new CategoriesTable(new MySQL);
$categories = $table->showAll();

session_start();
$errors = $_SESSION['category_errors'] ?? [];
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['category_errors'], $_SESSION['old_data']);

?>
<!doctype html>
<html lang="en">
<!--begin::Head-->
<link rel="stylesheet" href="css/style2.css">

<head>
  <style>
    
  </style>
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
              <a href="testCategoryAll.php" class="nav-link active">
                <i class="fas fa-list-alt me-2"></i>
                <p>
                  Categories
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testAuthorAll.php" class="nav-link">
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
                <li class="breadcrumb-item active" aria-current="page">Category List</li>
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
        <div class="container mt-0">
          <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
          <!-- Changed the Create button to trigger modal -->
          <button type="button" class="btn btn-sm btn-outline-success mb-2"
            data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            Create
          </button>
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tr>
                <th>ID</th>
                <th>Categories</th>
                <th>Action</th>
              </tr>
              <?php foreach ($categories as $category): ?>
                <tr>
                  <td><?= $category->id ?></td>
                  <td><?= $category->name ?></td>
                  <td>
                    <div class="btn-group">
                      <!-- Update Button (triggers modal) -->
                      <button type="button" class="btn btn-sm btn-outline-primary update-btn"
                        data-bs-toggle="modal" data-bs-target="#updateCategoryModal"
                        data-id="<?= $category->id ?>"
                        data-name="<?= htmlspecialchars($category->name) ?>">
                        Update
                      </button>
                      <?php if ($category->temp_delete): ?>
                        <a href="_admins/showCategory.php?id=<?= $category->id ?>" class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure?')">SoftDel</a>
                      <?php else: ?>
                        <a href="_admins/hideCategory.php?id=<?= $category->id ?>" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure?')">HardDel</a>
                      <?php endif; ?>
                      <a href="_admins/categoryDel.php?id=<?= $category->id ?>"
                        class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </table>
          </div>
        </div>
      </div>
      <!--end::Container-->
  </div>
  <!--end::App Content-->
  </main>
  <!--end::App Main-->

  <!-- Create Category Modal -->
  <div class="modal" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createCategoryModalLabel">Create New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="_admins/categoryCreate.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label for="categoryName" class="form-label">Category Name</label>
              <input type="text" class="form-control" id="categoryName" name="name" placeholder="Enter category name">
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Update Category Modal -->
  <div class="modal " id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="_admins/categoryUpd.php" method="POST">
          <div class="modal-body">
            <input type="hidden" id="updateCategoryId" name="id">
            <div class="mb-3">
              <label for="updateCategoryName" class="form-label">Category Name</label>
              <input type="text" class="form-control" id="updateCategoryName" name="name">
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JavaScript to populate update modal -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const updateButtons = document.querySelectorAll('.update-btn');

      updateButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const name = this.getAttribute('data-name');

          document.getElementById('updateCategoryId').value = id;
          document.getElementById('updateCategoryName').value = name;
        });
      });
    });
  </script>
  <?php include("footer.php"); ?>
</body>
<!--end::Body-->

</html>