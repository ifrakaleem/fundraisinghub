<?php
session_start();
include('config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campaign_id = $_POST['campaign_id'];
    $amount = $_POST['amount'];

    
    $sql = "SELECT title FROM campaigns WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $campaign_id);
        $stmt->execute();
        $stmt->bind_result($title);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Information - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .payment-section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .payment-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .payment-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .payment-container p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .payment-container form {
            display: flex;
            flex-direction: column;
        }
        .payment-container label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .payment-container input[type="text"],
        .payment-container input[type="email"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .payment-container button[type="submit"] {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .payment-container button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <section class="payment-section">
        <div class="payment-container">
            <h2>Payment Information</h2>
            <p>Campaign: <?php echo htmlspecialchars($title); ?></p>
            <p>Amount: $<?php echo number_format($amount, 2); ?></p>
            <!-- Payment form -->
            <form action="process_payment.php" method="POST">
                <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                <label for="donor_name">Donor Name:</label>
                <input type="text" id="donor_name" name="donor_name" required>
                
                <label for="donor_email">Donor Email:</label>
                <input type="email" id="donor_email" name="donor_email" required>
                
                <label for="cardholder_name">Cardholder Name:</label>
                <input type="text" id="cardholder_name" name="cardholder_name" required>

                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" required>

                <label for="expiry_date">Expiry Date:</label>
                <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required>

                <button type="submit">Submit Payment</button>
            </form>
        </div>
    </section>
</body>
</html>
