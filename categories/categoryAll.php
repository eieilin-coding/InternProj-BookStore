<?php
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
//use Helpers\Auth;

//  $auth = Auth::check();

$table = new CategoriesTable(new MySQL);
$categories = $table->showAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>

</head>

<body>
    <div class="main-content" style="height: 580px;">
        <?php require_once 'navbar.php'; ?>

        <div class="d-flex content-wrapper">
            <nav class="bg-white border-end shadow-sm flex-shrink-0" id="sidebar">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link"><i class="fas fa-home me-2"></i> <span>Admin</span></a>
                    </li>
                    <li>
                        <a href="userAll.php" class="nav-link"><i class="fas fa-users me-2"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="bookAll.php" class="nav-link"><i class="fas fa-book me-2"></i> <span>Books</span></a>
                    </li>
                    <li>
                        <a href="categoryAll.php" class="nav-link active"><i class="fas fa-list-alt me-2"></i> <span>Categories</span></a>
                    </li>
                    <li>
                        <a href="authorAll.php" class="nav-link"><i class="fas fa-user-tie me-2"></i> <span>Authors</span></a>
                    </li>

                </ul>
            </nav>
            <div class="container mt-2">
                <div class="mt-2 mb-2 center">
                    <a href="category.php" class="btn btn-sm btn-outline-success">Create</a>
                </div>
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
                                    <a href="categoryUpdF.php?id=<?= $category->id ?>"
                                        class="btn btn-sm btn-outline-primary">Update</a>
                                    <a href="_admins/categoryDel.php?id=<?= $category->id ?>"
                                        class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>

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