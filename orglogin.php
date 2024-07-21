<?php

session_start();
include('config.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM organizations WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: campaignmanagement.php");
            exit;
        } else {
            echo "Invalid username or password.";
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Login - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('header.php'); ?>

    <section class="login-section">
        <div class="login-box">
            <h2>Organization Login</h2>
            <form action="orglogin.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="orgreg.php">Register here</a></p>
        </div>
    </section>
</body>
</html>
