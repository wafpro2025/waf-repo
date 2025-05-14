<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['comment_id'])) {
    $comment_id = intval($_POST['comment_id']);
    $user_id = $_SESSION['id'];
    $role = $_SESSION['role'];

    // التأكد من ملكية التعليق
    $check = mysqli_query($con, "SELECT * FROM comments WHERE id = $comment_id");
    $comment = mysqli_fetch_assoc($check);

    if ($comment && ($comment['user_id'] == $user_id || $role === 'admin')) {
        mysqli_query($con, "DELETE FROM comments WHERE id = $comment_id");
        $ip = $_SERVER['REMOTE_ADDR'];
        mysqli_query($con, "INSERT INTO logs (user_id, activity, ip_address) VALUES ($user_id, 'Deleted comment ID $comment_id', '$ip')");
    }
}

// ✅ بعد الحذف ارجع للصفحة
header("Location: user_profile.php");
exit();
?>