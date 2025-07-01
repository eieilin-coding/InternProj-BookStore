<?php
session_start();

use Helpers\HTTP;


unset($_SESSION['user']);

header("location: ../index.php");
