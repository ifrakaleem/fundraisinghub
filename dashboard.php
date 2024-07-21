<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: userlogin.php");
    exit();
}

include 'config.php'; 

$username = $_SESSION['username'];


$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();


if (!$user) {
    echo "Error fetching user data.";
    exit();
}

$query = "SELECT * FROM donations WHERE donor_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user['email']);
$stmt->execute();
$donations = $stmt->get_result();
$stmt->close();

if ($donations === false) {
    echo "Error executing donations query: " . htmlspecialchars($stmt->error) . "<br>";
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .dashboard-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            flex: 1;
            padding: 20px;
        }
        .profile-box, .donations-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-bottom: 20px;
        }
        .profile-box h2, .donations-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .profile-box p, .donations-box p {
            margin: 10px 0;
            font-size: 16px;
        }
        .profile-box p strong, .donations-box p strong {
            display: inline-block;
            width: 150px;
        }
        .donations-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .donations-box table, .donations-box th, .donations-box td {
            border: 1px solid #ddd;
        }
        .donations-box th, .donations-box td {
            padding: 8px;
            text-align: left;
        }
        .donations-box th {
            background-color: #f2f2f2;
        }
        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-home a {
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }
        .back-to-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <section class="dashboard-section">
        <div class="profile-box">
            <h2>User Profile</h2>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Street Address:</strong> <?php echo htmlspecialchars($user['street_address']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($user['state']); ?></p>
            <p><strong>Zipcode:</strong> <?php echo htmlspecialchars($user['zipcode']); ?></p>
        </div>

        <div class="donations-box">
            <h2>Your Donations</h2>
            <?php if ($donations->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Campaign ID</th>
                            <th>Amount</th>
                            <th>Donor Name</th>
                            <th>Donor Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($donation = $donations->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($donation['id']); ?></td>
                                <td><?php echo htmlspecialchars($donation['campaign_id']); ?></td>
                                <td><?php echo htmlspecialchars($donation['amount']); ?></td>
                                <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                                <td><?php echo htmlspecialchars($donation['donor_email']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have not made any donations yet.</p>
            <?php endif; ?>
        </div>

        <div class="back-to-home">
            <a href="index.php">Go back to Home Page</a>
        </div>
    </section>
</body>
</html>
