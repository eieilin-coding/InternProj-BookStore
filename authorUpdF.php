<?php
include("vendor/autoload.php");

    use Libs\Database\MySQL;
    use Libs\Database\AuthorsTable;
    use Helpers\HTTP;

    $id = $_GET['id'];

    $table = new AuthorsTable(new MySQL);
    $author = $table->find($id);

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    
    <div class="container text-center" style="max-width: 500px">
    <h1 class="h3">Edit</h1>
    <form action="_admins/authorUpd.php" method="post" class="mb-2">  
        <input type="hidden" name="id" value="<?= $author['id'] ?>">
        <input type="text" name="name" class="form-control " placeholder="Name" value="<?= $author['name'] ?>"><br>
        <input type="text" name="email" class="form-control " placeholder="Email" value="<?= $author['email'] ?>"><br>
        <input type="text" name="phone" class="form-control " placeholder="Phone" value="<?= $author['phone'] ?>"><br>
        <input type="text" name="address" class="form-control " placeholder="Address" value="<?= $author['address'] ?>"><br>
       <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary"> Update Author<button>
            <a href="authorAll.php" class="btn btn-secondary d-block">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>