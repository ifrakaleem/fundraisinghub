<?php
session_start();
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
