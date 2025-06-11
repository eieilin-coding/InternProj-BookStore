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
        <h1 class="h3 mt-y mb-3">Create Categories</h1>

          <?php if(isset($_GET['category'])): ?>
            <div class="alert alert-info">
               Successfully created category
            </div>
        <?php endif ?>

        <form action="_admins/categoryCreate.php" method="post" class="mb-2">
            <input type="text" class="form-control mb-2" name="name" placeholder="Name" required>
            <button class="btn btn-primary w-100">Create</button>
        </form>
         <a href="categoryAll.php" class="btn btn-outline-success">Back</a>
    </div>
   
</body>
</html>