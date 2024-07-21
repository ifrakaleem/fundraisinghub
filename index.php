<?php
session_start();
include('config.php'); 

$types = ['Education', 'Health', 'Environmental', 'Social Justice'];
$campaigns_by_type = [];

foreach ($types as $type) {
    $sql = "SELECT id, title, short_description, goal, achieved, image FROM campaigns WHERE type = ? ORDER BY created_at DESC LIMIT 3";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $campaigns_by_type[$type] = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <?php include('header.php'); ?>

    <section class="donation-section">
        <h2>Find a Campaign that Interests You</h2>

        <?php foreach ($campaigns_by_type as $type => $campaigns): ?>
            <h1><?php echo htmlspecialchars($type); ?> Campaigns</h1>
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
        <?php endforeach; ?>
    </section>
</body>
</html>
