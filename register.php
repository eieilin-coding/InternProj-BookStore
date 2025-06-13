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
  <style>
    body {
      background: linear-gradient(135deg, rgb(249, 231, 94), rgb(151, 15, 169));
      color: #fff;
      padding: 10px;
      min-height: 100vh;
    }
    .error { color: #ff3333; }
    a { color: black; }
  </style>
</head>
<body>
  <div class="container text-center" style="max-width: 600px;">
    <h1 class="h3 mb-3">Register</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger text-start">
        <ul class="mb-0">
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="_actions/create.php" method="post" class="mb-4 text-start">
      <!-- <form action="_actions/testCreate.php" method="post" class="mb-2 text-start"> -->

      <input type="text" class="form-control mb-4" name="name" placeholder="Name *" value="<?= htmlspecialchars($old['name'] ?? '') ?>">

      <input type="email" class="form-control mb-4" name="email" placeholder="Email *" value="<?= htmlspecialchars($old['email'] ?? '') ?>">

      <input type="text" class="form-control mb-4" name="phone" placeholder="Phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">

      <textarea name="address" class="form-control mb-4" placeholder="Address"><?= htmlspecialchars($old['address'] ?? '') ?></textarea>

      <input type="password" class="form-control mb-4" name="password" placeholder="Password *">

      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <a href="signIn.php">Already have an account? Login</a>
  </div>
</body>
</html>

