<footer class="footer">
<div class="container text-center">
        <div class="footer-links">
            <a href="dashboard.php">Home</a> |
            
            <a href="report_item.php">Post an Item</a> |
            <a href="about.php">About</a> |
            <a href="contact.php">Contact Us</a>
        </div>

        <p>&copy; <?= date('Y'); ?> FinderKeeper. All Rights Reserved.</p>
    </div>
</footer>

<!-- Footer Styling -->
<style>
    /* Ensures footer stays at the bottom */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }
    .container {
    flex: 1; /* Pushes the footer to the bottom */
}
    .footer {
        width: 100%;
        background-color: #f8f9fa;
        color: black;
        text-align: center;
        padding: 15px 0;
        position: relative;
        bottom: 0;
        left: 0;
        font-size: 14px;
        border-top: 1px solid #ddd;
        margin-top: auto; /* Pushes footer to the bottom */
    }
    .footer-links a {
        color: black;
        text-decoration: none;
        margin: 0 10px;
        font-weight: bold;
    }
    .footer-links a:hover {
        text-decoration: underline;
    }
</style>