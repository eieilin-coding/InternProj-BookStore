<?php
include("vendor/autoload.php");
include("header.php");

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
use Helpers\HTTP;

$id = $_GET['id'];

$table = new AuthorsTable(new MySQL);
$author = $table->find($id);

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
                                <li class="breadcrumb-item"><a href="testAuthorAll.php">Author List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Author</li>
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
                <!-- <div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;"> -->
                <div class="container mt-0 justify-content-center align-items-center" style="max-width: 500px;">
                    <div class="card shadow mt-4">
                        <div class="card-body">
                            <h1 class="h4 mb-4 text-center">Update Author</h1>

                            <?php if (isset($_GET['author'])): ?>
                                <div class="alert alert-info text-center">
                                    Successfully update author
                                </div>
                            <?php endif ?>

                            <form action="_admins/authorUpd.php" method="post" class="mb-2">
                                <input type="hidden" name="id" value="<?= $author['id'] ?>">
                                <div class="mb-4">
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="<?= $author['name'] ?>" required>
                                </div>
                                <div class="mb-4">
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $author['email'] ?>" required>
                                </div>
                                <div class="mb-4">
                                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?= $author['phone'] ?>" required>
                                </div>
                                <div class="mb-4">
                                    <input type="text" class="form-control" name="address" placeholder="Address" value="<?= $author['address'] ?>" required>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!--end::Container-->
    </div>
    <!--end::App Content-->
    </main>
    <!--end::App Main-->
    <?php include("footer.php"); ?>
</body>
<!--end::Body-->

</html>