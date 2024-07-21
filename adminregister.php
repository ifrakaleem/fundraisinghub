<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('config.php'); 

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email']; 

    
    $email_domain = substr(strrchr($email, "@"), 1);
    if ($email_domain !== 'fundraisinghub.com') {
        $error = "You must use an @fundraisinghub.com email address to register.";
    } elseif ($password !== $confirm_password) {
        
        $error = "Passwords do not match.";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        
        $sql = "INSERT INTO administrators (username, password, email) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $username, $hashed_password, $email);
            if ($stmt->execute()) {
                
                header("Location: adminlogin.php");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error: " . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Registration - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            padding: 20px;
        }
        .register-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .register-box form {
            display: flex;
            flex-direction: column;
        }
        .register-box label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .register-box input[type="text"],
        .register-box input[type="password"],
        .register-box input[type="email"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .register-box button[type="submit"] {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .register-box button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message, .success-message {
            text-align: center;
            margin-bottom: 10px;
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007BFF;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <div class="content">
        <div class="register-box">
            <h2>Administrator Registration</h2>
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form action="adminregister.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                
                <button type="submit">Register</button>
            </form>
            <div class="login-link">
                <p>Already have an account? <a href="adminlogin.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
