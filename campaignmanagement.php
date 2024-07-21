<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php'); 

if (!isset($_SESSION['username'])) {
    header("location: orglogin.php");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT org_name, org_id, org_address, date_formed, org_phone, org_email FROM organizations WHERE username = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($org_name, $org_id, $org_address, $date_formed, $org_phone, $org_email);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Campaigns - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .manage-campaign-section {
            padding: 20px;
        }
        .manage-campaign-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .manage-campaign-box h2 {
            color: #333333;
        }
        .manage-campaign-box p {
            font-size: 1.1em;
            color: #666666;
        }
        .manage-campaign-box ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .manage-campaign-box ul li {
            margin: 10px;
        }
        .manage-campaign-box ul li a {
            color: #fff;
            background-color: #007BFF;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .manage-campaign-box ul li a:hover {
            background-color: #0056b3;
        }
        .manage-campaign-box strong {
            color: #333333;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <section class="manage-campaign-section">
        <div class="manage-campaign-box">
            <h2>Manage Your Campaigns</h2>
            <p>Welcome, <?php echo htmlspecialchars($org_name); ?>! Here you can manage your organization's campaigns.</p>
            <h3>Organization Profile</h3>
            <p><strong>Organization Name:</strong> <?php echo htmlspecialchars($org_name); ?></p>
            <p><strong>Organization ID:</strong> <?php echo htmlspecialchars($org_id); ?></p>
            <p><strong>Organization Address:</strong> <?php echo htmlspecialchars($org_address); ?></p>
            <p><strong>Date Formed:</strong> <?php echo htmlspecialchars($date_formed); ?></p>
            <p><strong>Organization Phone:</strong> <?php echo htmlspecialchars($org_phone); ?></p>
            <p><strong>Organization Email:</strong> <?php echo htmlspecialchars($org_email); ?></p>
            <ul>
                <li><a href="add_campaign.php">Create a New Campaign</a></li>
                <li><a href="editcampaign.php">Edit Existing Campaigns</a></li>
                <li><a href="viewcampaigns.php">View All Campaigns</a></li>
            </ul>
        </div>
    </section>
</body>
</html>
