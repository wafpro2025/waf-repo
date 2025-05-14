<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comment_text']) && isset($_POST['blog_id'])) {
    $user_id = $_SESSION['id'];
    $blog_id = intval($_POST['blog_id']);
    $comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);

    $insert = mysqli_query($con, "INSERT INTO comments (user_id, blog_id, comment_text) VALUES ($user_id, $blog_id, '$comment_text')");

    if ($insert) {
        // Optionally log activity
        $ip = $_SERVER['REMOTE_ADDR'];
        mysqli_query($con, "INSERT INTO logs (user_id, activity, ip_address) VALUES ($user_id, 'Posted a comment', '$ip')");

        echo json_encode([
            "status" => "success",
            "username" => $_SESSION['username'], // تأكد إنها محفوظة في السيشن
            "text" => $comment_text,
            "created_at" => date("Y-m-d H:i:s")
        ]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}