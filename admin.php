<?php
include("vendor/autoload.php");

use Helpers\HTTP;

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']->role_id != 3) {
    HTTP::redirect("/index.php", "error=unauthorized");
    exit;
}

require_once 'db_config.php';

$totalCategories = 0;
$sql_total_categories = "SELECT COUNT(id) AS total_categories FROM categories";
$result_total_categories = $conn->query($sql_total_categories);
if ($result_total_categories && $result_total_categories->num_rows > 0) {
    $row = $result_total_categories->fetch_assoc();
    $totalCategories = $row['total_categories'];
}

$topCategories = [];
$sql_top_categories = "SELECT c.name AS category_name, COUNT(b.id) AS book_count
                       FROM categories c
                       LEFT JOIN books b ON c.id = b.category_id
                       GROUP BY c.name
                       ORDER BY book_count DESC
                       LIMIT 4";
$result_top_categories = $conn->query($sql_top_categories);
if ($result_top_categories && $result_top_categories->num_rows > 0) {
    while ($row = $result_top_categories->fetch_assoc()) {
        $topCategories[] = $row;
    }
}

$recentCategoryActivity = [];
$sql_recent_activity = "SELECT c.name AS category_name, b.title AS book_title, b.created_at
                        FROM books b
                        JOIN categories c ON b.category_id = c.id
                        ORDER BY b.created_at DESC
                        LIMIT 5";
$result_recent_activity = $conn->query($sql_recent_activity);
if ($result_recent_activity && $result_recent_activity->num_rows > 0) {
    while ($row = $result_recent_activity->fetch_assoc()) {
        $activity = [
            'category' => $row['category_name'],
            'action' => 'New book added: "' . $row['book_title'] . '"',
            'date' => date('Y-m-d H:i', strtotime($row['created_at']))
        ];
        $recentCategoryActivity[] = $activity;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style2.css">

</head>

<body class="bg-light">

    <div class="main-content">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">📚 Bookstore</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="_actions/logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="d-flex content-wrapper">
            <nav class="bg-white border-end shadow-sm flex-shrink-0" id="sidebar">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link active"><i class="fas fa-home me-2"></i> <span>Admin</span></a>
                    </li>
                    <li>
                        <a href="userAll.php" class="nav-link"><i class="fas fa-users me-2"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="/books/bookAll.php" class="nav-link"><i class="fas fa-book me-2"></i> <span>Books</span></a>
                    </li>
                    <li>
                        <a href="/categories/categoryAll.php" class="nav-link"><i class="fas fa-list-alt me-2"></i> <span>Categories</span></a>
                    </li>
                    <li>
                        <a href="/authors/authorAll.php" class="nav-link"><i class="fas fa-user-tie me-2"></i> <span>Authors</span></a>
                    </li>
                </ul>
            </nav>

            <div class="container my-2 p-4 bg-white rounded-3 shadow" style="height: 750px;">
                <h3 class="text-center mb-4 text-secondary">Admin Dashboard Overview</h3>

                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card text-center p-3 shadow-sm h-100 border-primary border-3">
                            <div class="card-body">
                                <i class="fas fa-cubes fa-3x text-primary mb-3"></i>
                                <h5 class="card-title text-primary">Total Categories</h5>
                                <p class="card-text fs-1 fw-bold"><?php echo htmlspecialchars($totalCategories); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8">
                        <div class="card p-3 shadow-sm h-100 border-success border-3">
                            <div class="card-body">
                                <h5 class="card-title text-success mb-3"><i class="fas fa-trophy me-2"></i>Top Categories by Books</h5>
                                <ul class="list-group list-group-flush">
                                    <?php if (!empty($topCategories)): ?>
                                        <?php foreach ($topCategories as $category): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?php echo htmlspecialchars($category['category_name']); ?>
                                                <span class="badge bg-success rounded-pill"><?php echo htmlspecialchars($category['book_count']); ?> Books</span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="list-group-item text-muted">No top categories to display or no books assigned.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card p-3 shadow-sm border-info border-3">
                            <div class="card-body">
                                <h5 class="card-title text-info mb-3"><i class="fas fa-history me-2"></i>Recent Category Activity</h5>
                                <ul class="list-group list-group-flush">
                                    <?php if (!empty($recentCategoryActivity)): ?>
                                        <?php foreach ($recentCategoryActivity as $activity): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong><?php echo htmlspecialchars($activity['category']); ?>:</strong>
                                                    <span><?php echo htmlspecialchars($activity['action']); ?></span>
                                                </div>
                                                <small class="text-muted"><?php echo htmlspecialchars($activity['date']); ?></small>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="list-group-item text-muted">No recent category activity (based on new book additions).</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End d-flex content-wrapper -->
        <footer class="footer bg-dark text-white-50 py-3 sticky-bottom">
            <div class="container text-center">
                <small>&copy; 2025 Admin Panel. All rights reserved.</small>
            </div>
        </footer>
    </div> <!-- End main-content -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>