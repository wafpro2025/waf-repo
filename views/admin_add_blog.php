<?php
session_start();
include("php/config.php");

// التحقق من صلاحية الأدمين
if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// التحقق من إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // استعلام SQL لإدخال المقال في قاعدة البيانات
    $stmt = $con->prepare("INSERT INTO blogs (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        // إعادة التوجيه مع رسالة النجاح
        header("Location: home.php?added=true");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Alert</title>
    <link rel="stylesheet" href="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Basic styling for the entire body */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .btn {
            background-color: #2C3E50;
            color: #fff;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #34495E;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #34495E;
            color: white;
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
                <button class="btn btn-danger" title="go back">
                    <i class="fas fa-arrow-left"></i>Back
                </button>
            </a>
            <a href="php/logout.php">
                <button class="btn btn-danger" title="Good-Bye for a second session">Log Out</button>
            </a>
        </div>
    </div>

    <div class="container">
        <h1>Add New Alert</h1>

        <!-- نموذج إضافة المقال -->
        <form method="POST" action="admin_add_blog.php">
            <input type="text" name="title" placeholder="Enter Alert title" required><br>
            <textarea name="content" placeholder="Enter The content" rows="10" required></textarea><br>
            <button type="submit" class="btn" title="after publishing your alert it will be shown to all users pages">
                Publish </button>
        </form>
    </div>

</body>

</html>