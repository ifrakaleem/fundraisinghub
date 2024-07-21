<?php
session_start();
include('config.php'); 

if (!isset($_GET['id'])) {
    echo "Invalid campaign ID.";
    exit;
}

$campaign_id = $_GET['id'];


$sql = "SELECT title, type, short_description, long_description, goal, achieved, image FROM campaigns WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    $stmt->bind_result($title, $type, $short_description, $long_description, $goal, $achieved, $image);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .campaign-details-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .campaign-details-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        .campaign-details-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .campaign-image {
            width: 100%;
            height: 300px;
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .campaign-details-container p {
            margin: 10px 0;
            font-size: 16px;
        }
        .campaign-details-container p strong {
            display: inline-block;
            width: 150px;
        }
        #donateButton, .donateButton {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }
        #donateButton:hover, .donateButton:hover {
            background-color: #0056b3;
        }
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }
        #donationForm label {
            display: block;
            margin: 15px 0 5px;
            text-align: left;
        }
        #donationForm input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        #donationForm button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <section class="campaign-details-section">
        <div class="campaign-details-container">
            <h2><?php echo htmlspecialchars($title); ?></h2>
            <div class="campaign-image" style="background-image: url('uploads/<?php echo htmlspecialchars($image); ?>');"></div>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($type); ?></p>
            <p><strong>Short Description:</strong> <?php echo htmlspecialchars($short_description); ?></p>
            <p><strong>Long Description:</strong> <?php echo nl2br(htmlspecialchars($long_description)); ?></p>
            <p><strong>Goal:</strong> $<?php echo number_format($goal, 2); ?></p>
            <p><strong>Achieved:</strong> $<?php echo number_format($achieved, 2); ?></p>
            <?php if (isset($_SESSION['username'])): ?>
                <button id="donateButton" class="donateButton">Donate</button>
            <?php else: ?>
                <button onclick="window.location.href='userlogin.html'" class="donateButton">Sign In to Donate</button>
            <?php endif; ?>
        </div>
    </section>

    <div id="donationPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>Enter Donation Amount</h2>
            <form id="donationForm" action="payment_info.php" method="POST">
                <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" min="1" required>
                <button type="submit">Proceed to Payment</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('donateButton').addEventListener('click', function() {
            document.getElementById('donationPopup').style.display = 'flex';
        });

        function closePopup() {
            document.getElementById('donationPopup').style.display = 'none';
        }
    </script>
</body>
</html>
