<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
    <div class="container-lg d-flex align-items-center justify-content-between">
        <!-- Logo Section -->
        <a href="dashboard.php" class="logo d-flex align-items-center">
            <img src="assets/img 15-26-54-183/logo.png" alt="FinderKeeper Logo">
            <span class="name">FinderKeeper</span>
        </a>

        <!-- Navbar Links -->
        <nav class="header-nav">
            <ul class="d-flex align-items-center mb-0">
                <li class="nav-item"><a href="dashboard.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="post_item.php" class="nav-link">Post an Item</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Right Side: Welcome & Logout -->
        <div class="user-info d-flex align-items-center">
            <span>Welcome, <?= htmlspecialchars($_SESSION['user']); ?></span>
            <form action="logout.php" method="post">
                <button class="btn-logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>

<!-- ======= Aesthetic Navbar Styling ======= -->
<style>
/* Global Reset */
body {
    padding-top: 70px;
    margin: 0;
    font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f7f9fc;
}

/* Header */
.header {
    width: 100%;
    background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
    padding: 0;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Container Layout */
.header .container-lg {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 70px;
}

/* Logo */
.logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    padding: 0;
}
.logo img {
    height: 44px;
    width: 44px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
    border: 2px solid #fff;
    transition: transform 0.3s;
}
.logo:hover img {
    transform: rotate(5deg);
}
.name {
    font-size: 22px;
    font-weight: bold;
    color: white;
}

/* Navbar Links */
.header-nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}
.header-nav ul li {
    display: inline-block;
}
.header-nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 6px;
    transition: background-color 0.3s, color 0.3s;
}
.header-nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.18);
    color: #fff;
}

/* User Info and Logout */
.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: 18px;
}
.user-info span {
    font-size: 15px;
    font-weight: 500;
}
.btn-logout {
    background: white;
    color: #2575fc;
    padding: 7px 14px;
    font-size: 13px;
    font-weight: bold;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    transition: all 0.3s;
}
.btn-logout:hover {
    background: #f1f1f1;
    color: #2575fc;
}

/* Mobile Responsive */
@media (max-width: 900px) {
    .header .container-lg {
        flex-direction: column;
        align-items: stretch;
        padding: 0 10px;
    }
    .header-nav ul {
        justify-content: center;
        gap: 12px;
    }
    .user-info {
        justify-content: center;
        margin: 10px 0 0 0;
    }
}
@media (max-width: 600px) {
    .header .container-lg {
        min-width: 100vw;
        padding: 0 2vw;
    }
    .logo img {
        height: 36px;
        width: 36px;
    }
    .name {
        font-size: 18px;
    }
    .user-info span {
        font-size: 13px;
    }
}
</style>