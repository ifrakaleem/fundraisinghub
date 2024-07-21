<?php
session_start();
include('config.php'); 


$campaigns = [];
$sql = "SELECT id, title, short_description, goal, achieved, image FROM campaigns";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $campaigns[] = $row;
    }
    $result->close();
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
    <title>View Campaigns - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('header.php'); ?>

    <section class="view-campaigns-section">
        <div class="campaigns-container">
            <h2>All Campaigns</h2>
            <div class="featured-opportunities">
                <?php foreach ($campaigns as $campaign): ?>
                    <div class="campaign" style="background-image: url('uploads/<?php echo htmlspecialchars($campaign['image']); ?>'); background-size: cover; background-position: center;">
                        <h3><?php echo htmlspecialchars($campaign['title']); ?></h3>
                        <p><?php echo htmlspecialchars($campaign['short_description']); ?></p>
                        <p>Goal: $<?php echo number_format($campaign['goal'], 2); ?></p>
                        <p>Achieved: $<?php echo number_format($campaign['achieved'], 2); ?></p>
                        <a href="viewcampaign.php?id=<?php echo $campaign['id']; ?>">Learn More</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>
</html>
