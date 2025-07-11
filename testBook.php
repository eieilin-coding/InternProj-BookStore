<?php

require_once 'db_config.php';

include("vendor/autoload.php");
include("header.php");

use Helpers\HTTP;

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']->role_id == 1) {
  HTTP::redirect("/index.php", "error=unauthorized");
  exit;
}

use Libs\Database\MySQL;
use Libs\Database\CategoriesTable;
use Libs\Database\AuthorsTable;
use Libs\Database\BooksTable;

$table = new CategoriesTable(new MySQL);
$categories = $table->showAll();

$table = new AuthorsTable(new MySQL);
$authors = $table->authorList();

$table = new BooksTable(new MySQL);
$books = $table->showAll();
?>
<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Admin Panel</a></li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">View</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="_actions/logout.php">
              <i class="fas fa-sign-out-alt me-1"></i> Logout</a>
          </li>
        </ul>
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="index.php" class="brand-link">
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">📚 Bookstore</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="menu"
            data-accordion="false">
            <li class="nav-item">
              <a href="testAdmin.php" class="nav-link">
                <i class="fas fa-home me-2"></i>
                <p>
                  Admin
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testBookAll.php" class="nav-link active">
                <i class="fas fa-book me-2"></i>
                <p>
                  Books
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testCategoryAll.php" class="nav-link">
                <i class="fas fa-list-alt me-2"></i>
                <p>
                  Categories
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testAuthorAll.php" class="nav-link">
                <i class="fas fa-user-tie me-2"></i>
                <p>
                  Authors
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="testUserAll.php" class="nav-link">
                <i class="fas fa-users me-2"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0"></h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="testBookAll.php">Book</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Book</li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <div class="app-content">
        <!--begin::Container-->
        <!-- <div class="container-fluid"> -->
        <!-- Info boxes -->
        <div class="container bg-white shadow rounded p-4 my-0">
          <div id="h4">
            <h1 class="h4 mb-2 text-center">Add New Book</h1>
          </div>
          <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-info">Successfully created author</div>
          <?php endif ?>

          <form action="_admins/bookCreate.php" method="POST" enctype="multipart/form-data">

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="category_id" class="form-label fw-semibold">Category</label>
                <select name="category_id" id="category_id" class="form-select form-control" >
                  <option value="">-- Select Category --</option>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category->id); ?>">
                      <?php echo htmlspecialchars($category->name); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="author_id" class="form-label fw-semibold">Author</label>
                <select name="author_id" id="author_id" class="form-select form-control" >
                  <option value="">-- Select Author --</option>
                  <?php foreach ($authors as $author): ?>
                    <option value="<?php echo htmlspecialchars($author->id); ?>">
                      <?php echo htmlspecialchars($author->name); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="title" class="form-label fw-semibold">Book Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title">
              </div>

              <div class="col-md-6">
                <label for="publisher" class="form-label fw-semibold">Publisher</label>
                <input type="text" name="publisher" id="publisher" class="form-control" placeholder="Enter publisher">
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="published_date" class="form-label fw-semibold">Published Date</label>
                <input type="date" name="published_date" id="published_date" class="form-control">
              </div>

              <div class="col-md-6">
                <label for="book_photo" class="form-label fw-semibold">Book Cover (Photo)</label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                <small class="text-muted">Max: 5MB (JPG, PNG, GIF)</small>
              </div>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label fw-semibold">Description</label>
              <textarea name="description" id="description" class="form-control" rows="3" placeholder="Short book description"></textarea>
            </div>

            <div class="mb-4">
              <label for="book_pdf" class="form-label fw-semibold">Upload Book PDF</label>
              <input type="file" id="pdf" name="pdf" class="form-control" accept="application/pdf">
              <small class="text-muted">Max: 20MB (PDF only)</small>
            </div>

            <div class="d-flex justify-content-center gap-3">
              <button type="submit" class="btn btn-primary px-4" name="upload">Add Book</button>
              <button type="button" class="btn btn-secondary px-4" onclick="window.history.back()">Cancel</button>
            </div>

          </form>
        </div>

        <!-- </div> -->
        <!--end::Container-->
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->
  </div>
  <?php include("footer.php"); ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("form");
      const photoInput = document.getElementById("photo");
      const pdfInput = document.getElementById("pdf");

      form.addEventListener("submit", function(e) {
        let errors = [];

        // Validate required fields
        const category = document.getElementById("category_id").value.trim();
        const author = document.getElementById("author_id").value.trim();
        const title = document.getElementById("title").value.trim();
        const publisher = document.getElementById("publisher").value.trim();
        const publishedDate = document.getElementById("published_date").value.trim();
        const description = document.getElementById("description").value.trim();

        if (!category) errors.push("Please select a category.");
        if (!author) errors.push("Please select an author.");
        if (!title) errors.push("Book title is required.");
        if (!publisher) errors.push("Publisher is required.");
        if (!publishedDate) errors.push("Published date is required.");
        if (!description) errors.push("Description is required.");

        // Validate image file
        if (photoInput.files.length === 0) {
          errors.push("Please upload a book cover photo.");
        } else {
          const photo = photoInput.files[0];
          const allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];
          if (!allowedImageTypes.includes(photo.type)) {
            errors.push("Photo must be JPG, PNG, or GIF.");
          }
          if (photo.size > 5 * 1024 * 1024) {
            errors.push("Photo must be smaller than 5MB.");
          }
        }

        // Validate PDF file
        if (pdfInput.files.length === 0) {
          errors.push("Please upload the book PDF.");
        } else {
          const pdf = pdfInput.files[0];
          if (pdf.type !== "application/pdf") {
            errors.push("Uploaded file must be a PDF.");
          }
          if (pdf.size > 20 * 1024 * 1024) {
            errors.push("PDF must be smaller than 20MB.");
          }
        }

        // Display errors if any
        const existingAlert = document.querySelector(".js-validation-alert");
        if (existingAlert) existingAlert.remove();

        if (errors.length > 0) {
          e.preventDefault();
          const alertBox = document.createElement("div");
          alertBox.className = "alert alert-danger js-validation-alert";
          alertBox.innerHTML = "*" + errors.join("<br> *");
          form.parentElement.insertBefore(alertBox, form);
          window.scrollTo({
            top: alertBox.offsetTop - 20,
            behavior: "smooth"
          });
        }
      });
    });
  </script>

</body>
<!--end::Body-->

</html>