<?php
// اتصال بقاعدة البيانات
include("php/config.php");  // تأكد من تحديث المسار لملف الاتصال الخاص بك

// التحقق من إرسال التعليق
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['comment'])) {
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    // استعلام SQL لإدخال التعليق في قاعدة البيانات
    $stmt = $con->prepare("INSERT INTO comments (username, comment) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $comment);

    if ($stmt->execute()) {
        echo "Comment added successfully!";
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
    <title>Add Comment</title>
</head>

<body>

    <h2>Add Your Comment</h2>

    <!-- نموذج إضافة تعليق -->
    <form method="POST" action="add_comment.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Submit Comment</button>
    </form>

</body>

</html>