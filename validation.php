
<?php
include("vendor/autoload.php");

use Helpers\HTTP;
session_start();
 $nameErr = $emailErr = $passErr = "";
$name = $email = $phone = $address = $password = "";
$hasError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validation code here...

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

  if (empty($_POST["name"])) {
    $nameErr = "* Name is required";
    $hasError = true;
  } else {
    $name = test_input($_POST["name"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "* Email is required";
    $hasError = true;
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "* Invalid email format";
      $hasError = true;
    }
  }

  if (empty($_POST["password"])) {
    $passErr = "* Password is required";
    $hasError = true;
  } else {
    $password = test_input($_POST["password"]);
  }

  $phone = !empty($_POST["phone"]) ? test_input($_POST["phone"]) : "";
  $address = !empty($_POST["address"]) ? test_input($_POST["address"]) : "";


  if (!$hasError) {
    $_SESSION['register'] = [
      'name' => $name,
      'email' => $email,
      //'password' => password_hash($password, PASSWORD_DEFAULT),
      'password' => $password,
      'address' => $address,
      'phone' => $phone,     
    ];
    HTTP::redirect("/_actions/createValid.php");
    exit();
  }
}
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
      width: 100%;
      min-height: 100vh;
      background: linear-gradient(135deg, rgb(249, 231, 94), #90bafc);
      color: #fff;
      padding: 10px;
    }
    .error { color: red; }
    a { color: black; }
  </style>
</head>
<body>
  <div class="container text-center" style="max-width: 600px">
    <h1 class="h3 mt-y mb-3">Register</h1>

    <p><span class="error">* required field</span></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mb-2">

      <input type="text" class="form-control mb-2" name="name" placeholder="Name *" value="<?php echo htmlspecialchars($name); ?>">
      <span class="error"><?php echo $nameErr; ?></span><br><br>

      <input type="email" class="form-control mb-2" name="email" placeholder="Email *" value="<?php echo htmlspecialchars($email); ?>">
      <span class="error"><?php echo $emailErr; ?></span><br><br>

      <input type="text" class="form-control mb-2" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($phone); ?>">
      <br><br>

      <textarea name="address" class="form-control mb-2" placeholder="Address"><?php echo htmlspecialchars($address); ?></textarea>
      <br><br>

      <input type="password" class="form-control mb-2" name="password" placeholder="Password *">
      <span class="error"><?php echo $passErr; ?></span><br><br>

      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <a href="_actions/signIn.php">Login</a>
  </div>
</body>
</html>
