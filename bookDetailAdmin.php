<?php
include("vendor/autoload.php");
include("header.php");

require_once 'db_config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid Book ID');
}

$book_id = intval($_GET['id']);

$sql = "SELECT b.*, a.name AS author_name, c.name AS category_name 
        FROM books b 
        JOIN authors a ON b.author_id = a.id 
        JOIN categories c ON b.category_id = c.id 
        WHERE b.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Book not found.");
}

$book = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }

        #download .btn i {
            margin-right: 8px;
        }

        .book-cover {

            width: 100%;
            height: 460px;
            /* max-height: 500px;
            min-height: 300px; 
            Don't use */
        }

        .book-details {
            padding-top: 1.5rem;
        }

        @media (min-width: 768px) {
            .book-details {
                padding-top: 0;
                padding-left: 1rem;
            }
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
                            <a href="testBookAll.php" class="nav-link active">
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
                                <li class="breadcrumb-item"><a href="testBookAll.php">Book</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Details</li>
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
                <div class="container my-0 my-md-5">
                    <div class="row g-4">
                        <!-- Book Image -->
                        <div class="col-12 col-md-5">
                            <img src="_admins/photos/<?= htmlspecialchars($book['photo']) ?>"
                                alt="<?= htmlspecialchars($book['title']) ?>"
                                class="img-fluid rounded shadow book-cover">
                        </div>

                        <!-- Book Details -->
                        <div class="col-12 col-md-7 book-details justify-content-center">
                            <div class="mb-3">
                                <p class="mb-1"><strong>Title:</strong> <?= htmlspecialchars($book['title']) ?></p>
                                <p class="mb-1"><strong>Author:</strong> <?= htmlspecialchars($book['author_name']) ?></p>
                                <p class="mb-1"><strong>Category:</strong> <?= htmlspecialchars($book['category_name']) ?></p>
                                <p class="mb-3"><strong>Published Date:</strong> <?= htmlspecialchars(date('F d, Y', strtotime($book['published_date']))) ?></p>

                            </div>

                            <hr>

                            <div class="mb-4">
                                <p class="lead">Description:</p>
                                <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                            </div>
                            <a href="_admins/files/<?= htmlspecialchars($book['file']) ?>" class="d-block text-decoration-none my-2">
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <?= htmlspecialchars($book['title']) ?>.pdf
                            </a>
                            <p id="count"><strong>Downloads:</strong> <?= $book['download_count'] ?></p>
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