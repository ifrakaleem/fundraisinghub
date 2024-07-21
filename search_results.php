<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['search'])) {
    $searchQuery = htmlspecialchars($_GET['search']);

   
    $servername = "localhost";
    $username = "user1";
    $password = "Asadsaad12#@";
    $dbname = "donation_portal";

   
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $stmt = $conn->prepare("SELECT id, title, short_description, goal, achieved, image FROM campaigns WHERE title LIKE ? OR type LIKE ?");
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();

    
    $result = $stmt->get_result();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Results - Donation Portal</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <section class="campaign-section">
            <h1>Search Results for '<?php echo $searchQuery; ?>'</h1>
            <div class="campaign-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="campaign" style="background-image: url('uploads/<?php echo htmlspecialchars($row['image']); ?>'); background-size: cover; background-position: center;">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><?php echo htmlspecialchars($row['short_description']); ?></p>
                        <p>Goal: $<?php echo number_format($row['goal'], 2); ?></p>
                        <p>Achieved: $<?php echo number_format($row['achieved'], 2); ?></p>
                        <a href="viewcampaign.php?id=<?php echo $row['id']; ?>">Learn More</a>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No results found</p>";
            }
            ?>
            </div>
        </section>
    </body>
    </html>
    <?php
    $stmt->close();
    $conn->close();
} else {
    echo "<p>Please enter a search query.</p>";
}
?>
