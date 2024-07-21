<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .register-section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
            padding-top: 20px; 
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
        .register-box input[type="tel"],
        .register-box input[type="email"],
        .register-box input[type="password"] {
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
        .register-box p {
            text-align: center;
            margin-top: 20px;
        }
        .register-box p a {
            color: #007BFF;
            text-decoration: none;
        }
        .register-box p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <section class="register-section">
        <div class="register-box">
            <h2>User Registration</h2>
            <form action="register.php" method="POST">
                <input type="hidden" name="user_registration" value="1">
                
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>
                
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>
                
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="street_address">Street Address:</label>
                <input type="text" id="street_address" name="street_address" required>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>

                <label for="state">State:</label>
                <input type="text" id="state" name="state" required>

                <label for="zipcode">Zip Code:</label>
                <input type="text" id="zipcode" name="zipcode" required>

                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="userlogin.php">Sign In</a></p>
        </div>
    </section>
</body>
</html>
