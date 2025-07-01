<?php
session_start();
$errors = $_SESSION['login_errors'] ?? [];
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['login_errors'], $_SESSION['old_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
    }

    .card {
      width: 600px;
      height: 450px;
      background: #f1f1f1;
      color: black;
      font-size: 15px;
      border: 0;
      outline: 0;
      padding: 20px;
      border-radius: 10px;
      resize: none;
      margin-bottom: 30px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">📚 Bookstore</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i> Home </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container text-center" style="max-width: 600px">

    <h3 class="text-white my-3">Please Sign in </h3>
    <section class=" text-center text-lg-start">
      <style>
        .rounded-t-5 {
          border-top-left-radius: 0.5rem;
          border-top-right-radius: 0.5rem;
        }

        @media (min-width: 992px) {
          .rounded-tr-lg-0 {
            border-top-right-radius: 0;
          }

          .rounded-bl-lg-5 {
            border-bottom-left-radius: 0.5rem;
          }
        }
      </style>
      <div class="card mb-3">
        <div class="row g-0 d-flex align-items-center">
          <div class="col-lg-4 d-none d-lg-flex">
            <img src="_admins/photos/book1.jpg" alt="Books"
              class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
          </div>
          <div class="col-lg-8">
            <div class="card-body py-2 px-md-5">
              <?php if (isset($_GET['incorrect']) && $_GET['incorrect'] === 'login') : ?>
                <div class="alert alert-danger text-center" role="alert">
                  The email or password  is incorrect.
                </div>
                <?php elseif (isset($_GET['suspended']) && $_GET['suspended'] === 'account') : ?>
                  <div class="alert alert-danger text-center" role="alert">
                  The account is suspended.
                </div>
              <?php endif; ?>
                  
              <form action="_actions/login.php" method="post">

                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form2Example1">Email address</label>
                  <input type="email" name="email" id="form2Example1" class="form-control" />
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form2Example2">Password</label>
                  <input type="password" name="password" id="form2Example2" class="form-control" />
                </div>

                <div class="row mb-4">
                  <div class="col d-flex justify-content-center">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" value="" id="form2Example31" checked />
                      <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                  </div>

                  <div class="col">
                    <!-- Simple link -->
                    <a href="#">Forgot password?</a>
                  </div>
                </div>

                <!-- Submit button -->
                <div class="row mb-4">
                  <div class="col">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign in</button>
                  </div>
                  <div class="col">
                    <a href="register.php">Have not register yet?</a>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>