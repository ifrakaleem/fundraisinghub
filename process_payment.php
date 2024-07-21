<?php
session_start();
include('config.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campaign_id = $_POST['campaign_id'];
    $amount = $_POST['amount'];
    $donor_name = $_POST['donor_name'];
    $donor_email = $_POST['donor_email'];
    $cardholder_name = $_POST['cardholder_name'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    

    $sql = "INSERT INTO donations (campaign_id, amount, donor_name, donor_email) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("idss", $campaign_id, $amount, $donor_name, $donor_email);
        if ($stmt->execute()) {
            
            $sql_update = "UPDATE campaigns SET achieved = achieved + ? WHERE id = ?";
            if ($stmt_update = $conn->prepare($sql_update)) {
                $stmt_update->bind_param("di", $amount, $campaign_id);
                if ($stmt_update->execute()) {
                    
                    header("Location: thank_you.php");
                } else {
                    echo "Error: " . $stmt_update->error;
                }
                $stmt_update->close();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request.";
    exit;
}

$conn->close();
?>
