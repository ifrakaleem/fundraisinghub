<?php
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');

session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: orglogin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $short_description = $_POST['short_description'];
    $long_description = $_POST['long_description'];
    $goal = $_POST['goal'];
    $achieved = 0; 
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

   
    if ($_FILES['image']['size'] > 10000000) { // 10MB in bytes
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO campaigns (title, type, short_description, long_description, goal, achieved, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssdss", $title, $type, $short_description, $long_description, $goal, $achieved, $image);

            if ($stmt->execute()) {
                echo "New campaign created successfully";
                header("Location: campaignmanagement.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Campaign</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .add-campaign-section {
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            color: #333;
        }
        .form-container label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container textarea,
        .form-container select,
        .form-container input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <section class="add-campaign-section">
        <div class="form-container">
            <h2>Add New Campaign</h2>
            <form action="add_campaign.php" method="POST" enctype="multipart/form-data">
                <label for="title">Name of the Campaign:</label>
                <input type="text" id="title" name="title" required>

                <label for="type">Type of the Campaign:</label>
                <select id="type" name="type" required>
                    <option value="Education">Education</option>
                    <option value="Health">Health</option>
                    <option value="Environmental">Environmental</option>
                    <option value="Social Justice">Social Justice</option>
                </select>

                <label for="short_description">Short Description of the Campaign:</label>
                <textarea id="short_description" name="short_description" required></textarea>

                <label for="long_description">Long Description of the Campaign:</label>
                <textarea id="long_description" name="long_description" required></textarea>

                <label for="goal">Goal Amount:</label>
                <input type="number" id="goal" name="goal" required>

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" required>

                <button type="submit">Create Campaign</button>
            </form>
        </div>
    </section>
</body>
</html>
