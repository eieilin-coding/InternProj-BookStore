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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>

</head>
<body>
     <nav class="navbar bg-dark navbar-dark navbar-expand">
        <div class="container">
            <a href="#" class="navbar-brand">Book Categories</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                   <a href="admin.php" class="nav-link">Admin</a>
                </li>
                <li class="nav-item">
                    <a href="_actions/logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="mt-4 mb-4 center">
        <a href="category.php" class="btn btn-sm btn-outline-success">Create</a>
    </div>
        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Categories</th>
                <th>Action</th>

            </tr>
            <?php foreach($categories as $category): ?>
            <tr>
                <td><?= $category->id ?></td>
                <td><?= $category->name ?></td>
                <td>
                    <div class="btn-group">
                        <a href="categoryUpdF.php?id=<?= $category->id ?>" 
                        class="btn btn-sm btn-outline-primary">Update</a>
                        <a href="_admins/categoryDel.php?id=<?= $category->id ?>" 
                        class="btn btn-sm btn-outline-danger"  onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                   
            </tr>
            <?php endforeach ?>
        </table>
        
    </div>
</body>
</html>