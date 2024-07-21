<?php
session_start();
include('config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['user_registration'])) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
        $email = $_POST['email'];
        $street_address = $_POST['street_address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zipcode = $_POST['zipcode'];

        
        $sql = "INSERT INTO users (firstname, lastname, phone, username, password, email, street_address, city, state, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssssss", $firstname, $lastname, $phone, $username, $password, $email, $street_address, $city, $state, $zipcode);
            if ($stmt->execute()) {
                header("location: userlogin.php");
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['org_registration'])) {
        
        $org_name = $_POST['org_name'];
        $org_id = $_POST['org_id'];
        $date_formed = $_POST['date_formed'];
        $org_address = $_POST['org_address'];
        $org_phone = $_POST['org_phone'];
        $org_email = $_POST['org_email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

        
        $sql = "INSERT INTO organizations (org_name, org_id, date_formed, org_address, org_phone, org_email, username, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssss", $org_name, $org_id, $date_formed, $org_address, $org_phone, $org_email, $username, $password);
            if ($stmt->execute()) {
                header("location: orglogin.php");
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    }
    $conn->close();
}
?>
