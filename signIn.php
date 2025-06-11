<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
      body{
          width: 100%;
          min-height: 100vh;
          background: linear-gradient(135deg,rgb(94, 20, 213), #90bafc);
          color:#fff;
          padding: 10px;
          }

         .card {
        width: 600px;
        height: 500px;
        background:rgb(129, 123, 245);
        color: #fff;
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
  
    <div class="container text-center" style="max-width: 600px">
    
<h1> <i>Welcome Back </i></h1>
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
        <img src="_admins/photos/book1.jpg" alt="Trendy Pants and Shoes"
          class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
      </div>
      <div class="col-lg-8">
        <div class="card-body py-5 px-md-5">

          <form action="_actions/login.php" method="post">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="email" name="email" id="form2Example1" class="form-control" />
              <label class="form-label" for="form2Example1">Email address</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="password" name="password" id="form2Example2" class="form-control" />
              <label class="form-label" for="form2Example2">Password</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                  <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
              </div>

              <div class="col">
                <!-- Simple link -->
                <b><a href="#">Forgot password?</a></b>
              </div>
            </div>

            <!-- Submit button -->
            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign in</button>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->

        <!-- <a href="register.php">Register</a> -->
     </div>
</body>
</html>