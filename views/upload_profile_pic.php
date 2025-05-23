<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];
    $fileName = basename($file['name']);
    $targetDir = "uploads/";
    $targetFile = $targetDir . time() . "_" . $fileName;

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowed)) {
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Update profile_pic in database
            $relativePath = $targetFile; // Path to store in DB
            $update = mysqli_query($con, "UPDATE users SET profile_pic='$relativePath' WHERE id=$user_id");

            if ($update) {
                $_SESSION['success'] = "Profile picture updated successfully!";
                header("Location: user_profile.php");
                exit();
            } else {
                echo "Database update failed!";
            }
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, and GIF allowed.";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>

<head>
    <title>Upload Profile Picture</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .form-box {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease;
        }

        .btn-custom {
            background-color: #2c3e50;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #16a085;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="nav d-flex justify-content-between p-3">
        <div class="logo">
            <a class="navbar-brand" href="home.php" title="go to your profile">Logo</a>
        </div>
        <div class="right-links">
            <a href="home.php">
                <button class="btn btn-info" title="go back">
                    <i class="fas fa-arrow-left"></i>Back
                </button>
            </a>
            <a href="php/logout.php">
                <button class="btn btn-info" title="Good-Bye for a second session">Log Out</button>
            </a>
        </div>
    </div>
    <h2>Change Profile Picture</h2>
    <br>
    <form method="post" enctype="multipart/form-data"  >
        <input type="file" name="profile_pic" class="btn btn-secondary" required>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</body>

</html>