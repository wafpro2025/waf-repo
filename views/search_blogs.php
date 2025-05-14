<?php
include("php/config.php");

$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

$query = "SELECT * FROM blogs";
if (!empty($search)) {
    $query .= " WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
}
$query .= " ORDER BY created_at DESC";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    while ($blog = mysqli_fetch_assoc($result)) {
        echo '<div class="card mb-4 p-3 blog shadow-sm border-0">';
        echo '<h3>' . htmlspecialchars($blog['title']) . '</h3>';
        echo '<p>' . nl2br(htmlspecialchars($blog['content'])) . '</p>';
        echo '<small class="text-muted">🕒 Posted on: ' . $blog['created_at'] . '</small>';
        echo '</div>';
    }
} else {
    echo "<p>No matching blogs found.</p>";
}
?>