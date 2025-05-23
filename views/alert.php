<?php
session_start();
$message = $_SESSION['warning_message'] ?? '';
unset($_SESSION['warning_message']);
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>تنبيه أمني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card text-center shadow" style="max-width: 400px;">
        <div class="card-body">
            <h5 class="card-title text-danger">🚨 You are Trying somthing illegal please enter valid input</h5>
            <p class="card-text"><?= htmlspecialchars($message) ?></p>
            <a href="index.php" class="btn btn-primary">return to main page</a>
        </div>
    </div>
</body>

</html>