

<?php
session_start();
include("../php/config.php"); // Database connection

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $post_id = intval($_POST['post_id']); // Assume each blog has an ID

    // Insert the comment into the database
    $insert_query = "INSERT INTO comments (user_id, post_id, comment_text) VALUES ('$user_id', '$post_id', '$comment')";
    if (mysqli_query($con, $insert_query)) {
        echo "<script>alert('Comment added successfully!'); window.location.href = 'blog.php';</script>";
    } else {
        echo "<script>alert('Failed to add comment.'); window.location.href = 'blog.php';</script>";
    }
}
?>