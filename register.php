<?php
session_start();
$errors = $_SESSION['register_errors'] ?? [];
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['register_errors'], $_SESSION['old_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="js/bootstrap.bundle.min.js" defer></script>
  <style>
    .navbar {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

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

    .error {
      color: #ff3333;
    }

    a {
      color: #0d6efd;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">📚 Bookstore</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i> Home </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="signIn.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-sm w-100" style="max-width: 500px;">
      <div class="card-body p-4">
        <h2 class="card-title mb-4 text-center">Register</h2>

        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form action="_actions/create.php" method="post">
          <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Name *" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
          </div>

          <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email *" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
          </div>

          <div class="mb-3">
            <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
          </div>

          <div class="mb-3">
            <textarea name="address" class="form-control" placeholder="Address"><?= htmlspecialchars($old['address'] ?? '') ?></textarea>
          </div>

          <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password *">
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Register</button>
          </div>
        </form>

        <div class="text-center mt-3">
          <a href="signIn.php">Already have an account? Login</a>
        </div>
      </div>
    </div>
  </div>

</body>

</html>