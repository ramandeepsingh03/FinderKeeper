<?php
session_start();
$conn = new mysqli("localhost", "root", "", "FinderKeeper");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($first_name) || empty($last_name) || empty($email) || empty($contact) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match('/^[0-9]{10}$/', $contact)) {
        $error = "Contact number must be exactly 10 digits!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR contact = ? OR (first_name = ? AND last_name = ?)");
        $stmt->bind_param("ssss", $email, $contact, $first_name, $last_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "User with same email, contact or name already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, contact, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $email, $contact, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['user'] = $first_name;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Something went wrong. Try again!";
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FinderKeeper - Sign Up</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        background: url('assets/img 15-26-54-183/login_bg.png') no-repeat center center/cover;
        backdrop-filter: blur(5px);
        height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .signup-box {
        background: rgba(255, 255, 255, 0.25);
        border-radius: 16px;
        backdrop-filter: blur(12px);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        padding: 40px 30px;
        width: 400px;
        text-align: center;
        animation: fadeSlideIn 1s ease forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    @keyframes fadeSlideIn {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .signup-box h2 {
        color: #fff;
        font-weight: 600;
        margin-bottom: 25px;
    }

    .signup-box input {
        width: 90%;
        padding: 12px 15px;
        margin: 10px 0;
        background: rgba(255, 255, 255, 0.25);
        border: none;
        border-radius: 8px;
        font-size: 14px;
        color: #333;
        outline: none;
    }
    .signup-box input::placeholder {
        color: #555;
    }

    .signup-box button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(90deg, #4a90e2, #6a11cb);
        border: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border-radius: 8px;
        margin-top: 15px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .signup-box button:hover {
        background: linear-gradient(90deg, #6a11cb, #4a90e2);
    }

    .error {
        background: rgba(255, 0, 0, 0.1);
        color: #d8000c;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 8px;
        font-size: 14px;
    }

    .link {
        margin-top: 15px;
        font-size: 14px;
        color: #eee;
    }
    .link a {
        color: #00c3ff;
        text-decoration: none;
    }
    .link a:hover {
        text-decoration: underline;
    }
</style>
</head>

<body>

<div class="signup-box">
    <h2>Sign Up</h2>

    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <form method="POST" action="">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit">Sign Up</button>
    </form>

    <div class="link">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>