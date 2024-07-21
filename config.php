<?php
$servername = "localhost";
$username = "user1";
$password = "Asadsaad12#@";
$dbname = "donation_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
