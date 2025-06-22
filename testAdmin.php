<?php
include("vendor/autoload.php");
include("header.php");

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
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <style>
     #change1, #change2 {
      display: flex;
      justify-content: space-between !important;
      text-align: center !important;
    }
  /* @media (max-width: 576px) {
    .list-group-item {
      flex-direction: column;
      text-align: center;
    }
    .list-group-item small {
      margin-top: 5px;
    }
  } */
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
            class="nav sidebar-menu flex-column text-lg-start"
            data-lte-toggle="treeview"
            role="menu"
            data-accordion="false">
            <li class="nav-item">
              <a href="testAdmin.php" class="nav-link active">
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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Admin</li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <div class="app-content">
        <div class="container mb-4 p-4 bg-white rounded-3 shadow text-center">
          <h3 class="text-center mb-4 text-secondary">Admin Dashboard Overview</h3>

          <div class="row g-4 mb-4 justify-content-center">
            <div class="col-sm-10 col-md-6 col-lg-4">
              <div class="card text-center p-3 shadow-sm h-100 border-primary border-3">
                <div class="card-body">
                  <div class="d-flex justify-content-center">
                  <i class="fas fa-cubes fa-3x text-primary mb-3"></i>
                  <h5 class=" text-primary">Total Categories</h5>
                  </div>
                  <p class="card-text fs-1 fw-bold"><?php echo htmlspecialchars($totalCategories); ?></p>
                </div>
              </div>
            </div>

            <div class="col-sm-10 col-md-6 col-lg-8">
              <div class="card p-3 shadow-sm h-100 border-success border-3">
                <div class="card-body text-center">
                  <h5 class=" text-success mb-3"><i class="fas fa-trophy me-2"></i>Top Categories by Books</h5>
                  <ul class="list-group list-group-flush">
                    <?php if (!empty($topCategories)): ?>
                      <?php foreach ($topCategories as $category): ?>
                        <li class="list-group-item" id="change1">
                          <span class="text-start">
                            <?php echo htmlspecialchars($category['category_name']); ?>
                          </span>
                          <span class="badge bg-success rounded-pill"><?php echo htmlspecialchars($category['book_count']); ?> Books</span>
                        </li>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li class="list-group-item text-muted text-center">No top categories to display or no books assigned.</li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-12">
              <div class="card p-3 shadow-sm border-info border-3">
                <div class="card-body text-center" >
                  <h5 class=" text-info mb-3"><i class="fas fa-history me-2"></i>Recent Category Activity</h5>
                  <ul class="list-group list-group-flush" >
                    <?php if (!empty($recentCategoryActivity)): ?>
                      <?php foreach ($recentCategoryActivity as $activity): ?>
                        <li class="list-group-item" id="change2">
                          <div class="text-start">
                            <strong><?php echo htmlspecialchars($activity['category']); ?>:</strong>
                            <span><?php echo htmlspecialchars($activity['action']); ?></span>
                          </div>
                          <small class="text-muted"><?php echo htmlspecialchars($activity['date']); ?></small>
                        </li>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li class="list-group-item text-muted text-center">No recent category activity.</li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end::Container-->
      <!--end::App Content-->
    </main>
  </div>
  <!--end::App Main-->
  <?php include("footer.php"); ?>
</body>
<!--end::Body-->

</html>