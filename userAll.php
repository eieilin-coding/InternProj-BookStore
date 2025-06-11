<?php
include("vendor/autoload.php");

    use Libs\Database\MySQL;
    use Libs\Database\UsersTable;
    //use Helpers\Auth;

    //$auth = Auth::check();

    $table = new UsersTable(new MySQL);
    $users = $table->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
     <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
    <nav class="navbar bg-dark navbar-dark navbar-expand">
        <div class="container">
            <a href="#" class="navbar-brand">Users</a>
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
        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->phone ?></td>
                    <td>
                    <div class="btn-group">
                        <a href="_actions/delete.php?id=<?= $user->id ?>" 
                        class="btn btn-sm btn-outline-danger"  onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </td> 
                </tr>

            <?php endforeach ?>
        </table>
    </div>  
</body>
</html>