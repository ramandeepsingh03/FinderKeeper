<?php
session_start();
?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="container-lg d-flex justify-content-between px-4">
    <!-- Logo Section -->
    <div class="d-flex align-items-center">
      <a href="<?= base_url ?>" class="logo d-flex align-items-center">
        <img src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo">
        <span class="d-none d-lg-block"><?= $_settings->info('short_name') ?></span>
      </a>
    </div>
    <!-- End Logo -->

    <!-- Navigation Menu -->
    <nav class="header-nav me-auto">
      <ul class="d-flex align-items-center h-100">
        <li class="nav-item pe-3">
            <a href="<?= base_url ?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item pe-3">
            <a href="<?= base_url.'?page=items' ?>" class="nav-link">Lost and Found</a>
        </li>
        <li class="nav-item pe-3">
            <a href="<?= base_url.'?page=found' ?>" class="nav-link">Post an Item</a>
        </li>
        <li class="nav-item pe-3">
            <a href="<?= base_url."?page=about" ?>" class="nav-link">About</a>
        </li>
        <li class="nav-item pe-3">
            <a href="<?= base_url.'?page=contact' ?>" class="nav-link">Contact Us</a>
        </li>
      </ul>
    </nav>
    <!-- End Navigation -->

    <!-- User Profile & Logout Section -->
    <div class="d-flex align-items-center">
      <?php if (isset($_SESSION['user'])): ?>
        <span class="me-3 text-white">Welcome, <?= $_SESSION['user']; ?></span>
        <form action="logout.php" method="post">
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
      <?php else: ?>
        <a href="<?= base_url.'admin' ?>" class="btn btn-primary">Login</a>
      <?php endif; ?>
    </div>
  </div>
</header>
<!-- End Header -->

<!-- Sticky Header Styling -->
<style>
  .header {
      width: 100%;
      background-color: #007bff;
      padding: 10px 0;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  .header-nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
  }
  .header-nav ul li {
      display: inline;
  }
  .header-nav ul li a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      font-weight: bold;
  }
  .header-nav ul li a:hover {
      text-decoration: underline;
  }
  .btn-primary, .btn-danger {
      padding: 8px 12px;
      font-size: 14px;
      font-weight: bold;
      border-radius: 5px;
  }
</style>