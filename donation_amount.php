<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['donation_amount'] = $_POST['amount'];
    
    header("Location: payment.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Amount</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="logo.jpg" alt="Donation Portal Logo">
        </div>
        <nav>
            <ul>
                <li>
                    <form action="search.php" method="GET">
                        <input type="text" name="search" placeholder="Search for campaigns">
                        <button type="submit">Search</button>
                    </form>
                </li>
                <li><a href="index.html">Home</a></li>
                <li><a href="dashboard.html">My Dashboard</a></li>
                <li><a href="donate.html">Make a Donation</a></li>
                <li><a href="whatsnew.html">What's New</a></li>
            </ul>
        </nav>
    </header>
    <h2>Enter Donation Amount</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>
        <button type="submit">Donate</button>
    </form>
</body>
</html>
