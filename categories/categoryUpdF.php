<?php
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Helpers\HTTP;

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Invalid Category ID.");
}

$table = new CategoriesTable(new MySQL);
$category = $table->find($id);

if (!$category) {
    die("Category not found.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js" defer></script>

</head>

<body class="bg-light">
    <?php require_once 'navbar.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-4 text-center">Edit Category</h2>

                        <form action="_admins/categoryUpd.php" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" id="name" name="name"
                                    class="form-control "
                                    placeholder="Enter category name"
                                    value="<?= htmlspecialchars($category['name']) ?>" required>
                            </div>

                            <div class="d-flex justify-content-center gap-2">
                                <button type="submit" class="btn btn-primary btn-md">Update</button>
                                <button type="button" class="btn btn-secondary btn-md" onclick="window.history.back()">Cancel</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>