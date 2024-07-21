<?php
session_start();
include('config.php'); 


function exportToCSV($tableName, $data) {
    $filename = $tableName . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);

    $output = fopen('php://output', 'w');
    if (count($data) > 0) {
        fputcsv($output, array_keys($data[0]));
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit;
}


if (isset($_GET['export'])) {
    $tableName = $_GET['export'];
    $data = [];
    switch ($tableName) {
        case 'organizations':
            $sql = "SELECT id, org_name, org_id, date_formed, org_address, org_phone, org_email FROM organizations";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            exportToCSV('organizations', $data);
            break;
        case 'donations':
            $sql = "SELECT donations.id, donations.campaign_id, campaigns.title AS campaign_name, donations.amount, donations.donor_name, donations.donor_email, donations.date 
                    FROM donations 
                    JOIN campaigns ON donations.campaign_id = campaigns.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            exportToCSV('donations', $data);
            break;
        case 'users':
            $sql = "SELECT id, firstname, lastname, phone, email, street_address, city, state, zipcode FROM users";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            exportToCSV('users', $data);
            break;
        case 'campaigns':
            $sql = "SELECT id, title, goal, created_at, type, short_description, long_description, achieved FROM campaigns";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            exportToCSV('campaigns', $data);
            break;
    }
}


$organizations = [];
$sql = "SELECT id, org_name, org_id, date_formed, org_address, org_phone, org_email FROM organizations LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $organizations[] = $row;
    }
}

$donations = [];
$sql = "SELECT donations.id, donations.campaign_id, campaigns.title AS campaign_name, donations.amount, donations.donor_name, donations.donor_email, donations.date 
        FROM donations 
        JOIN campaigns ON donations.campaign_id = campaigns.id LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donations[] = $row;
    }
}

$users = [];
$sql = "SELECT id, firstname, lastname, phone, email, street_address, city, state, zipcode FROM users LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$campaigns = [];
$sql = "SELECT id, title, goal, created_at, type, short_description, long_description, achieved FROM campaigns LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $campaigns[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Display - Donation Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(to bottom, #f4f4f9, #f4f4f9 90%, grey 100%);
            color: #333; 
            border-bottom: 3px solid grey; 
        }

        .logo img {
            max-width: 120px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: #333; 
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #b3b3b3;
            color: white; 
        }

        nav ul li form {
            display: flex;
        }

        nav ul li form input[type="text"] {
            padding: 12px; 
            font-size: 16px; 
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        nav ul li form button {
            background-color: grey; 
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li form button:hover {
            background-color: #b3b3b3;
        }

        .section {
            margin-bottom: 40px;
        }

        .section h2 {
            background-color: grey;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .section table {
            width: 100%;
            border-collapse: collapse;
        }

        .section table, .section th, .section td {
            border: 1px solid #ccc;
        }

        .section th, .section td {
            padding: 10px;
            text-align: left;
        }

        .section th {
            background-color: #f4f4f9;
        }

        .export-button {
            margin-top: 10px;
            display: inline-block;
            padding: 10px 20px;
            background-color: grey;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .export-button:hover {
            background-color: #b3b3b3;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <div class="section" id="organizations">
        <h2>Organizations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Org ID</th>
                    <th>Date Formed</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($organizations as $organization): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($organization['id']); ?></td>
                        <td><?php echo htmlspecialchars($organization['org_name']); ?></td>
                        <td><?php echo htmlspecialchars($organization['org_id']); ?></td>
                        <td><?php echo htmlspecialchars($organization['date_formed']); ?></td>
                        <td><?php echo htmlspecialchars($organization['org_address']); ?></td>
                        <td><?php echo htmlspecialchars($organization['org_phone']); ?></td>
                        <td><?php echo htmlspecialchars($organization['org_email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="?export=organizations" class="export-button">Export to CSV</a>
    </div>

    <div class="section" id="donations">
        <h2>Donations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Campaign ID</th>
                    <th>Campaign Name</th>
                    <th>Amount</th>
                    <th>Donor Name</th>
                    <th>Donor Email</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($donation['id']); ?></td>
                        <td><?php echo htmlspecialchars($donation['campaign_id']); ?></td>
                        <td><?php echo htmlspecialchars($donation['campaign_name']); ?></td>
                        <td><?php echo htmlspecialchars($donation['amount']); ?></td>
                        <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                        <td><?php echo htmlspecialchars($donation['donor_email']); ?></td>
                        <td><?php echo htmlspecialchars($donation['date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="?export=donations" class="export-button">Export to CSV</a>
    </div>

    <div class="section" id="users">
        <h2>Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Street Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip Code</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['street_address']); ?></td>
                        <td><?php echo htmlspecialchars($user['city']); ?></td>
                        <td><?php echo htmlspecialchars($user['state']); ?></td>
                        <td><?php echo htmlspecialchars($user['zipcode']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="?export=users" class="export-button">Export to CSV</a>
    </div>

    <div class="section" id="campaigns">
        <h2>Campaigns</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Goal</th>
                    <th>Created At</th>
                    <th>Type</th>
                    <th>Short Description</th>
                    <th>Long Description</th>
                    <th>Achieved</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campaigns as $campaign): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($campaign['id']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['title']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['goal']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['type']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['short_description']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['long_description']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['achieved']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="?export=campaigns" class="export-button">Export to CSV</a>
    </div>
</body>
</html>
