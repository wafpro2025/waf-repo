<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "waf_project";

$con = mysqli_connect($host, $user, $password, $database);

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Uncomment this line only when debugging
// echo "Database connected successfully!";
function log_activity($user_id, $activity, $ip_address)
{
    global $con;
    $stmt = $con->prepare("INSERT INTO logs (user_id, activity, ip_address) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $activity, $ip_address);
    /*    if ($stmt->execute()) {
           // عرض رسالة log
           echo "<div id='logMessage'>Log inserted!</div>";
           // إضافة JavaScript لإخفاء الرسالة بعد ثانية
           echo "<script>
               setTimeout(function() {
                   var logMessage = document.getElementById('logMessage');
                   if (logMessage) {
                       logMessage.style.display = 'none';
                   }
               }, 1000); // 1000 ملي ثانية = 1 ثانية
           </script>";
       } else {
           echo "Error: " . $stmt->error;
       } */
    $stmt->close();
}
?>