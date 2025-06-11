<?php
include("vendor/autoload.php");

    use Libs\Database\MySQL;
    use Libs\Database\AuthorsTable;
    //use Helpers\Auth;

  //  $auth = Auth::check();

    $table = new AuthorsTable(new MySQL);
    $authors = $table->showAll();

    $limit = 8;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $authors = $table->showAll($limit, $offset);
    $total = $table->totalCount();
    $total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>

</head>
<body>
     <nav class="navbar bg-dark navbar-dark navbar-expand">
        <div class="container">
            <a href="#" class="navbar-brand">Authors</a>
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
        <a href="author.php" class="btn btn-sm btn-outline-success">Create</a>
        <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    </div>
        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>

            </tr>
            <?php foreach($authors as $author): ?>
            <tr>
                <td><?= $author->id ?></td>
                <td><?= $author->name ?></td>
                <td><?= $author->email ?></td>
                <td><?= $author->phone ?></td>
                <td><?= $author->address ?></td>
                <td>
                    <div class="btn-group">
                        <a href="authorUpdF.php?id=<?= $author->id ?>" 
                        class="btn btn-sm btn-outline-primary">Update</a>
                        <a href="_admins/authorDel.php?id=<?= $author->id ?>" 
                        class="btn btn-sm btn-outline-danger"  onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </td> 
            </tr>
            <?php endforeach ?>
        </table>
        
    </div>
</body>
</html>