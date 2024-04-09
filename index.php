<?php
session_start();

// Check if the user is already logged in (optional, based on your needs)
if (isset($_SESSION['user_id'])) {
  // If logged in, redirect to a different page (e.g., home page)
  header("Location: views/dashboard.php");
  exit;
}

// User not logged in or session not set, redirect to login page
header("Location: login/login.php");
exit;
?>
