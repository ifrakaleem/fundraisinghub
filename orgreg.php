<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Registration - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
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
            padding-top: 70px; 
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
        .register-box input[type="date"],
        .register-box input[type="tel"],
        .register-box input[type="email"],
        .register-box input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px; /* Reduced font size */
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
            <h2>Organization Registration</h2>
            <form action="register.php" method="POST">
                <input type="hidden" name="org_registration" value="1">
                
                <label for="org_name">Organization Name:</label>
                <input type="text" id="org_name" name="org_name" required>
                
                <label for="org_id">Organization ID:</label>
                <input type="text" id="org_id" name="org_id" required>
                
                <label for="date_formed">Date Formed:</label>
                <input type="date" id="date_formed" name="date_formed" required>
                
                <label for="org_address">Organization Address:</label>
                <input type="text" id="org_address" name="org_address" required>
                
                <label for="org_phone">Organization Phone Number:</label>
                <input type="tel" id="org_phone" name="org_phone" required>
                
                <label for="org_email">Organization Email:</label>
                <input type="email" id="org_email" name="org_email" required>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="orglogin.html">Sign In</a></p>
        </div>
    </section>
</body>
</html>
