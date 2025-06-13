

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
      background: linear-gradient(135deg, rgb(249, 231, 94), rgb(151, 15, 169));
      color: #fff;
      padding: 10px;
      min-height: 100vh;
    }
    </style>
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">
            <h1 class="h4 text-center mb-4">Create New Category</h1>

            <?php if (isset($_GET['category'])) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                     Category created successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="_admins/categoryCreate.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Category Name" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Create Category</button>
            </form>

            <div class="d-grid mt-3">
                <a href="categoryAll.php" class="btn btn-outline-secondary">← Back to Categories</a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
