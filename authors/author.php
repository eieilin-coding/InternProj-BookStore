<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            width: 100%;
            min-height: 100vh;
            color: #fff;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('_admins/photos/read1.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
    </style>
</head>

<body>
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
                        <a class="nav-link" href="authorAll.php"><i class="fas fa-home me-1"></i>Author</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="_actions/logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="container mt-0" style="max-width: 500px;">
            <div class="card shadow mt-4">
                <div class="card-body">
                    <h1 class="h4 mb-4 text-center">Create Author</h1>

                    <?php if (isset($_GET['author'])): ?>
                        <div class="alert alert-info text-center">
                            Successfully created author
                        </div>
                    <?php endif ?>

                    <form action="_admins/authorCreate.php" method="post" class="mb-2">
                        <div class="mb-4">
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="mb-4">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-4">
                            <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                        </div>
                        <div class="mb-4">
                            <input type="text" class="form-control" name="address" placeholder="Address" required>
                        </div>

                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary" name="create">Create</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>