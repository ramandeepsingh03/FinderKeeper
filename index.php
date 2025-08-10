<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get the requested page from the URL (e.g., index.php?page=dashboard)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Define valid pages to prevent errors
$valid_pages = ['dashboard', 'lost_items', 'post_item', 'about', 'contact'];

// If the requested page is valid, include it, otherwise show 404 error page
if (in_array($page, $valid_pages)) {
    include "$page.php";
} else {
    include "404.php"; // Redirect to custom 404 error page
}
?>