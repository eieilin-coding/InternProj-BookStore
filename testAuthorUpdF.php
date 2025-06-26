<?php
include("vendor/autoload.php");
include("header.php");

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
use Helpers\HTTP;

// Validate the ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    HTTP::redirect("/testAuthorAll.php", "error=invalid_id");
    exit();
}

$id = (int)$_GET['id'];

$table = new AuthorsTable(new MySQL);
$author = $table->find($id);

// Check if author exists
if (!$author) {
    HTTP::redirect("/testAuthorAll.php", "error=author_not_found");
    exit();
}

// Initialize error variables
$errors = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'address' => ''
];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Validate inputs
    $valid = true;

    // Name validation
    if (empty($name)) {
        $errors['name'] = "Name is required";
        $valid = false;
    } elseif (strlen($name) > 255) {
        $errors['name'] = "Name must be less than 255 characters";
        $valid = false;
    }

    // Email validation
    if (empty($email)) {
        $errors['email'] = "Email is required";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
        $valid = false;
    } elseif (strlen($email) > 255) {
        $errors['email'] = "Email must be less than 255 characters";
        $valid = false;
    }

    // Phone validation
    if (empty($phone)) {
        $errors['phone'] = "Phone is required";
        $valid = false;
    } elseif (!preg_match('/^[0-9\+\-\(\)\s]+$/', $phone)) {
        $errors['phone'] = "Invalid phone number format";
        $valid = false;
    } elseif (strlen($phone) > 20) {
        $errors['phone'] = "Phone must be less than 20 characters";
        $valid = false;
    }

    // Address validation
    // if (empty($address)) {
    //     $errors['address'] = "Address is required";
    //     $valid = false;
    // } elseif (strlen($address) > 500) {
    //     $errors['address'] = "Address must be less than 500 characters";
    //     $valid = false;
    // }

    // If all validation passed, process the form
    if ($valid) {
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];

        $result = $table->update($id, $name, $email, $phone, $address);

        if ($result) {
            HTTP::redirect("/testAuthorAll.php", "success=author_updated");
            exit();
        } else {
            $errors['general'] = "Failed to update author. Please try again.";
        }
    }
}
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
                <div class="container mt-0 justify-content-center align-items-center" style="max-width: 500px;">
                    <div class="card shadow mt-4">
                        <div class="card-body">
                            <h1 class="h4 mb-4 text-center">Update Author</h1>

                            <?php if (isset($_GET['author'])): ?>
                                <div class="alert alert-info text-center">
                                    Successfully updated author
                                </div>
                            <?php endif ?>

                            <?php if (isset($errors['general'])): ?>
                                <div class="alert alert-danger text-center">
                                    <?= htmlspecialchars($errors['general']) ?>
                                </div>
                            <?php endif ?>

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?id=<?= $id ?>" method="post" class="mb-2">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($author['id']) ?>">

                                <div class="mb-4">
                                    <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>"
                                        name="name" placeholder="Name"
                                        value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : htmlspecialchars($author['name']) ?>">
                                    <?php if (!empty($errors['name'])): ?>
                                        <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
                                    <?php endif ?>
                                </div>

                                <div class="mb-4">
                                    <input type="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>"
                                        name="email" placeholder="Email"
                                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($author['email']) ?>">
                                    <?php if (!empty($errors['email'])): ?>
                                        <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                                    <?php endif ?>
                                </div>

                                <div class="mb-4">
                                    <input type="text" class="form-control <?= !empty($errors['phone']) ? 'is-invalid' : '' ?>"
                                        name="phone" placeholder="Phone"
                                        value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : htmlspecialchars($author['phone']) ?>">
                                    <?php if (!empty($errors['phone'])): ?>
                                        <div class="invalid-feedback"><?= htmlspecialchars($errors['phone']) ?></div>
                                    <?php endif ?>
                                </div>

                                <div class="mb-4">
                                    <input type="text" class="form-control <?= !empty($errors['address']) ? 'is-invalid' : '' ?>"
                                        name="address" placeholder="Address"
                                        value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : htmlspecialchars($author['address']) ?>">
                                    <?php if (!empty($errors['address'])): ?>
                                        <div class="invalid-feedback"><?= htmlspecialchars($errors['address']) ?></div>
                                    <?php endif ?>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                    <a type="button" class="btn btn-secondary" href="testAuthorAll.php">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!--end::App Main-->
        <?php include("footer.php"); ?>
    </div>
</body>
<!--end::Body-->

</html>