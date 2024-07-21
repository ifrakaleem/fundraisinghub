<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: userlogin.html");
    exit();
}

include 'config.php'; 

$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .profile-section {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            background-color: #f4f4f9;
            padding-top: 40px; 
        }
        .profile-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .profile-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .profile-box p {
            margin: 10px 0;
            font-size: 16px;
        }
        .profile-box p strong {
            display: inline-block;
            width: 150px;
        }
        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-home a {
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }
        .back-to-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <section class="profile-section">
        <div class="profile-box">
            <h2>User Profile</h2>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Street Address:</strong> <?php echo htmlspecialchars($user['street_address']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($user['state']); ?></p>
            <p><strong>Zipcode:</strong> <?php echo htmlspecialchars($user['zipcode']); ?></p>
            <div class="back-to-home">
                <a href="index.php">Go back to Home Page</a>
            </div>
        </div>
    </section>
</body>
</html>
