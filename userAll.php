<?php
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style2.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    <div class="main-content">
        <nav class="navbar bg-dark navbar-dark navbar-expand sticky-top">
            <div class="container">
                <a href="#" class="navbar-brand">📚 Bookstore</a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link"><i class="fas fa-book me-2"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link">
                            <?= $auth->name ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="_actions/logout.php" class="nav-link">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="d-flex content-wrapper">
            <nav class="bg-white border-end shadow-sm flex-shrink-0" id="sidebar">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link"><i class="fas fa-home me-2"></i> <span>Admin</span></a>
                    </li>
                    <li>
                        <a href="userAll.php" class="nav-link active"><i class="fas fa-users me-2"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="bookAll.php" class="nav-link"><i class="fas fa-book me-2"></i> <span>Books</span></a>
                    </li>
                    <li>
                        <a href="categoryAll.php" class="nav-link"><i class="fas fa-list-alt me-2"></i> <span>Categories</span></a>
                    </li>
                    <li>
                        <a href="authorAll.php" class="nav-link"><i class="fas fa-user-tie me-2"></i> <span>Authors</span></a>
                    </li>

                </ul>
            </nav>

            <div class="container mt-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
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
            </div>
        </div>
        <footer class="footer bg-dark text-white-50 py-3 sticky-bottom">
            <div class="container text-center">
                <small>&copy; 2025 Admin Panel. All rights reserved.</small>
            </div>
        </footer>
    </div>
</body>

</html>