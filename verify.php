<?php
if (!isset($_GET['token'])) {
    echo "Invalid verification token.";
    exit;
}

include('config.php'); 

$token = $_GET['token'];

// Verify the token
$sql = "UPDATE administrators SET status = 'verified' WHERE verification_token = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Your account has been verified. You can now <a href='adminlogin.php'>login</a>.";
    } else {
        echo "Invalid or expired verification token.";
    }

    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
