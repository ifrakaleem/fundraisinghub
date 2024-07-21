<?php
session_start();
include('config.php'); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campaign = $_POST['campaign'];
    $amount = $_POST['amount'];
    $cardnumber = $_POST['cardnumber'];
    $expirydate = $_POST['expirydate'];
    $cvv = $_POST['cvv'];
    $cardholdername = $_POST['cardholdername'];

   
    $sql = "INSERT INTO donations (campaign, amount, username) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sds", $campaign, $amount, $_SESSION['username']);
        if ($stmt->execute()) {
            header("location: thank_you.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
} else {
    header("location: index.php");
    exit;
}
?>
