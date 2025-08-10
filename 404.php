<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the header
include 'header.php';
?>

<div class="container">
  <section
    class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center"
  >
    <h1>404</h1>
    <h2>The page you are looking for doesn't exist.</h2>
    <a class="btn btn-primary" href="dashboard.php">Back to Home</a>
  </section>
</div>

