<?php
session_start();
include("php/config.php");

if (isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $user_id = $_SESSION['id'] ?? 0;
    $blog_id = 1;

    if ($user_id > 0) {
        $insert = mysqli_query($con, "INSERT INTO comments (user_id, blog_id, comment_text) VALUES ($user_id, $blog_id, '$comment')");
        if (!$insert) {
            error_log("Comment insert error: " . mysqli_error($con));
            echo "db-error";
            exit;
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $log = mysqli_query($con, "INSERT INTO logs (user_id, action, ip_address) VALUES ($user_id, 'Posted a comment', '$ip')");
        if (!$log) {
            error_log("Log insert error: " . mysqli_error($con));
        }

        echo "success";
    } else {
        echo "no-session";
    }
}
?>