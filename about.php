<?php
session_start();
include 'header.php'; // Including your navbar/header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Us - FinderKeeper</title>
    <style>
        body {
            padding-top: 70px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f8fb;
        }

        .about-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            max-width: 1200px;
            border-radius: 12px;
        }

        .about-image {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        .about-image img {
            max-width: 90%;
            border-radius: 10px;
        }

        .about-content {
            flex: 1;
            padding: 30px;
        }

        .about-content h1 {
            font-size: 36px;
            color: #3742fa;
            margin-bottom: 20px;
        }

        .about-content p {
            font-size: 18px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .about-content ul {
            list-style: none;
            padding: 0;
        }

        .about-content ul li {
            margin-bottom: 10px;
            font-size: 17px;
        }

        .about-content ul li::before {
            content: "✓";
            color: #27ae60;
            margin-right: 8px;
        }

        .btn-learn {
            background-color: #27ae60;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-learn:hover {
            background-color: #1e8449;
        }
    </style>
</head>
<body>

<div class="about-section">
    <div class="about-image">
        <img src="assets/img 15-26-54-183/lost_found_storage.webp" alt="Lost and Found Storage">
    </div>

    <div class="about-content">
        <h1>Welcome to FinderKeeper!</h1>
        <p>
            At <strong>FinderKeeper</strong>, we understand how valuable your belongings are to you.
            Our mission is to reunite lost items with their rightful owners through an easy, fast, and secure online platform.
            Whether it's your precious gadgets, important documents, or personal accessories — FinderKeeper is here to help you find your way back to them!
        </p>

        <ul>
            <li>🔒 Privacy First: Your information is safe and secure.</li>
            <li>⚡ Fast Lost and Found Reporting.</li>
            <li>🤝 Trusted by hundreds of students and staff members.</li>
            <li>🌐 Accessible 24/7 anytime, anywhere.</li>
        </ul>

        <a href="post_item.php" class="btn-learn">Get Started</a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>