<?php
include 'header.php'; // Reuse your existing header (if any)
include 'config.php'; // Connect to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form fields safely
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Check if any field is empty (extra protection)
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Prepare and insert into database
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Thank you, $name! Your message has been submitted successfully.');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About & Contact Us - FinderKeeper</title>
    <style>
        body {
            padding-top: 70px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
        }
        /* About Section */
        .about-section {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }
        .about-section h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .about-section p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }
        .features {
            padding: 50px 20px;
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            background: #ffffff;
        }
        .feature-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .feature-card h3 {
            margin-bottom: 15px;
            color: #2575fc;
        }

        /* Contact Section */
        .contact-section {
            padding: 48px 40px;
            background: white;
            max-width: 1000px;
            margin: 60px auto 0 auto;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(37, 117, 252, 0.10);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .contact-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 64px;
            width: 100%;
        }
        .contact-form, .contact-info {
            width: 48%;
            min-width: 320px;
        }
        .contact-title {
            text-align: center;
            margin-bottom: 40px;
            width: 100%;
        }
        .contact-title h1 {
            font-size: 2.7rem;
            color: #2575fc;
            margin-bottom: 10px;
        }
        .contact-title p {
            font-size: 1.2rem;
            color: #222;
            margin-bottom: 0;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 16px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 1.1rem;
            margin-top: 8px;
            background: #f9fafb;
            transition: border 0.2s;
        }
        .form-group input:focus, .form-group textarea:focus {
            border: 1.5px solid #2575fc;
            outline: none;
        }
        .btn-submit {
            background: linear-gradient(90deg, #2575fc 0%, #6a11cb 100%);
            color: white;
            padding: 16px 0;
            border: none;
            border-radius: 10px;
            width: 100%;
            font-size: 1.15rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(37, 117, 252, 0.10);
            transition: background 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
        }
        .contact-info h3 {
            margin-bottom: 8px;
            color: #222;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .contact-info p {
            margin: 8px 0;
            color: #444;
            font-size: 1.05rem;
        }
        @media (max-width: 1100px) {
            .contact-section {
                max-width: 98vw;
                padding: 24px 2vw;
            }
            .contact-container {
                gap: 32px;
            }
        }
        @media (max-width: 900px) {
            .contact-section {
                max-width: 99vw;
                padding: 18px 1vw;
            }
            .contact-container {
                flex-direction: column;
                gap: 24px;
            }
            .contact-form, .contact-info {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<!-- ABOUT US SECTION -->
<section class="about-section">
    <h1>Welcome to FinderKeeper</h1>
    <p>At FinderKeeper, we are passionate about reuniting people with their lost treasures. 
    Whether you misplaced your wallet or left your laptop behind, FinderKeeper offers a fast, 
    secure, and reliable platform to help you retrieve it. We are not just a Lost & Found system, 
    we are a community that cares!</p>
</section>

<section class="features">
    <div class="feature-card">
        <h3>Privacy by Default</h3>
        <p>All your information is securely protected and never shared without consent.</p>
    </div>
    <div class="feature-card">
        <h3>Revolutionary Service</h3>
        <p>Our smart matching algorithm ensures faster and accurate item recovery.</p>
    </div>
    <div class="feature-card">
        <h3>Trusted By Users</h3>
        <p>Thousands trust FinderKeeper every day to find what's valuable to them.</p>
    </div>
</section>

<!-- CONTACT US SECTION -->
<section class="contact-section">
    <div class="contact-title">
        <h1>Get In Touch</h1>
        <p>Have any questions? We're here to help you out!</p>
    </div>

    <div class="contact-container">
        <div class="contact-form">
            <form method="POST" action="">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name *" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email *" required>
                </div>
                <div class="form-group">
                    <input type="text" name="subject" placeholder="Subject *" required>
                </div>
                <div class="form-group">
                    <textarea name="message" rows="5" placeholder="Your Message *" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>

        <div class="contact-info">
            <h3>FinderKeeper Headquarters</h3>
            <p>123 Finder Street, New Delhi, India</p>
            <p>📞 +91 9876543210</p>
            <p>📧 support@finderkeeper.com</p>

            <h3>Branch Office</h3>
            <p>456 Recovery Road, Mumbai, India</p>
            <p>📞 +91 9123456780</p>
            <p>📧 info@finderkeeper.com</p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>