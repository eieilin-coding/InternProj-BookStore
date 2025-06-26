<?php
include("vendor/autoload.php");
include("header.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Helpers\HTTP;

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Invalid Category ID.");
}

$table = new CategoriesTable(new MySQL);
$category = $table->find($id);

if (!$category) {
    die("Category not found.");
}
?>
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <style>
        .btn-md {
            justify-content: center;
            align-items: center;
        }
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
                                <li class="breadcrumb-item"><a href="testCategoryAll.php">Category List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Category</li>
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
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-5">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h2 class="h4 mb-4 text-center">Edit Category</h2>

                                    <form action="_admins/categoryUpd.php" method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Category Name</label>
                                            <input type="text" id="name" name="name"
                                                class="form-control "
                                                placeholder="Enter category name"
                                                value="<?= htmlspecialchars($category['name']) ?>" required>
                                        </div>

                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="submit" class="btn btn-primary btn-md">Update</button>
                                            <button type="button" class="btn btn-secondary btn-md" onclick="window.history.back()">Cancel</button>
                                        </div>
                                    </form>

                                </div>
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