<?php
session_start();
$conn = new mysqli("localhost", "root", "", "FinderKeeper");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Both fields are required!";
    } else {
        $stmt = $conn->prepare("SELECT id, first_name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $first_name, $hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user'] = $first_name;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "No account found with this email!";
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
    <title>Login | FinderKeeper</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('assets/img 15-26-54-183/login_bg.png') no-repeat center center/cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }
        .login-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            padding: 40px 30px;
            width: 320px;
            color: white;
            text-align: center;
            animation: fadeSlideIn 1s ease forwards;
        }
        .login-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffffff;
        }
        .login-container input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.25);
            color: white;
            font-size: 16px;
        }
        .login-container input::placeholder {
            color: #e0e0e0;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: linear-gradient(90deg, #4a90e2, #6a11cb);
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-container button:hover {
            background: linear-gradient(90deg, #6a11cb, #4a90e2);
        }
        .login-container .link {
            margin-top: 15px;
        }
        .login-container .link a {
            color:rgb(50, 183, 255);
            text-decoration: underline;
            font-size: 14px;
        }
        .error {
            background: rgba(255, 0, 0, 0.6);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
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
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="link">
    New User? <a href="signup.php">Sign Up</a>
    </div>
    
</div>

</body>
</html>