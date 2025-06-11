<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center" style="max-width: 600px">
        <h1 class="h3 mt-y mb-3">Create Author</h1>

          <?php if(isset($_GET['author'])): ?>
            <div class="alert alert-info">
               Successfully created author
            </div>
        <?php endif ?>

        <form action="_admins/authorCreate.php" method="post" class="mb-2">
            <input type="text" class="form-control mb-2" name="name" placeholder="Name" required>
            <input type="email" class="form-control mb-2" name="email" placeholder="Email" required>
            <input type="text" class="form-control mb-2" name="phone" placeholder="Phone" required>
            <input type="text" class="form-control mb-2" name="address" placeholder="Address" required>
            <button class="btn btn-primary w-100">Create</button>
        </form>
         <a href="authorAll.php" class="btn btn-outline-success d-block">Cancel</a>
    </div>
   
</body>
</html>