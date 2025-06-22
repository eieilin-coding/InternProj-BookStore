<?php
include("vendor/autoload.php");
include("header.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;

//This code is needed. Don't delete it!
$auth = Auth::check();

$table = new UsersTable(new MySQL);
// $users = $table->all();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$listUsers = $table->showAllUsers($limit, $offset);
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
              <a href="testAuthorAll.php" class="nav-link">
                <i class="fas fa-user-tie me-2"></i>
                <p>
                  Authors
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testUserAll.php" class="nav-link active">
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
                <li class="breadcrumb-item active" aria-current="page">User List</li>
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
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tr>
                <th>ID</th>
                <th> Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th></th>
              </tr>
              <?php foreach ($listUsers as $user): ?>
                <tr>
                  <td><?= $user->id ?></td>
                  <td><?= $user->name ?></td>
                  <td><?= $user->email ?></td>
                  <td><?= $user->phone ?></td>
                  <td>
                    <?php if ($user->role_id == 3): ?>
                      <span class="badge bg-success">
                        <?= $user->role ?>
                      </span>
                    <?php elseif ($user->role_id == 2): ?>
                      <span class="badge bg-primary">
                        <?= $user->role ?>
                      </span>
                    <?php else:  ?>
                      <span class="badge bg-secondary">
                        <?= $user->role ?>
                      </span>
                    <?php endif ?>
                  </td>
                  <td>
                    <div class="btn-group dropdown">

                      <?php if ($auth->role_id == 3): ?>

                        <a href="#" class="btn btn-sm btn-outline-primary dropdown-toggle"
                          data-bs-toggle="dropdown">Role</a>
                        <div class="dropdown-menu">
                          <a href="_actions/role.php?id=<?= $user->id ?>&role=1"
                            class="dropdown-item">User</a>
                          <a href="_actions/role.php?id=<?= $user->id ?>&role=2"
                            class="dropdown-item">Manager</a>
                          <a href="_actions/role.php?id=<?= $user->id ?>&role=3"
                            class="dropdown-item">Admin</a>
                        </div>
                      <?php endif ?>


                      <?php if ($auth->role_id >= 2): ?>
                        <?php if ($user->suspended): ?>
                          <a href="_actions/unsuspend.php?id=<?= $user->id ?>"
                            class="btn btn-sm btn-warning">Ban</a>
                        <?php else: ?>
                          <a href="_actions/suspend.php?id=<?= $user->id ?>"
                            class="btn btn-sm btn-outline-warning">Ban</a>
                        <?php endif ?>
                      <?php endif ?>
                      <?php if ($auth->role_id == 3): ?>
                        <a href="_actions/delete.php?id=<?= $user->id ?>"
                          class="btn btn-sm btn-outline-danger">Delete</a>
                      <?php endif ?>
                    </div>

                  </td>
                </tr>
              <?php endforeach ?>
            </table>
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
      <!--end::Container-->
  </div>
  <!--end::App Content-->
  </main>
  <!--end::App Main-->
  <?php include("footer.php") ?>
</body>
<!--end::Body-->

</html>