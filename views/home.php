<?php
session_start();
include("php/config.php");

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

// Get user data from the database to ensure updates are reflected
$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
$userData = mysqli_fetch_assoc($query);

$username = $userData['username']; // Updated username
$email = $userData['email'];
$age = $userData['Age'];
$role = $userData['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Navigation bar styles */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #2C3E50;
            color: #fff;
        }

        /* Links in the navigation bar */
        .nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        /* Button styling for logout */
        .btn {
            background-color: #E74C3C;
            color: #fff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #C0392B;
        }

        /* Main container styling */
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #34495E;
            color: #fff;
        }

        table th,
        table td {
            border: 1px solid #2C3E50;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #2C3E50;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #3E5773;
        }

        /* Header and paragraph styles */
        h1,
        h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        p,
        ul {
            text-align: left;
            margin: 10px 0;
        }

        ul li {
            margin-bottom: 5px;
        }

        /* Admin actions styling */
        .admin-actions a {
            color: #1ABC9C;
            text-decoration: none;
            margin-right: 10px;
        }

        .admin-actions a:hover {
            text-decoration: underline;
        }

        /* Toast notification styles */
        .toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 12px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }

        .toast.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 3s;
            animation: fadein 0.5s, fadeout 0.5s 3s;
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Navigation bar section -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="home.php">Logo</a>
        <div class="ms-auto">
            <a href="admin_add_blog.php" class="btn btn-primary">➕ Add New Blog</a>

            <a class="btn btn-outline-light me-2" href="Change_Profile2.php">Change Profile</a>
            <a class="btn btn-danger" href="php/logout.php">Log Out</a>
        </div>
    </nav>


    <div class="container py-5">

        <?php if ($role === 'admin') { ?>
            <!-- Section for admin-specific features -->

            <h1>Welcome, Admin <?php echo htmlspecialchars($username); ?>!</h1>
            <p>Manage the users of the WAF system below:</p>

            <table class="table table-dark table-hover table-bordered">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
                <?php
                // Fetch all users for admin management
                $query = mysqli_query($con, "SELECT * FROM users");
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Age']) . "</td>";
                    echo "<td class='admin-actions'>
                                <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> | 
                                <a href='delete_user.php?id=" . $row['id'] . "'>Delete</a>
                              </td>";
                    echo "</tr>";
                }
                ?>
            </table>



    </div>
    <br>
    <br>
    <h2>System Logs</h2>
    <table class="table table-dark table-hover table-bordered">
        <tr>
            <th>User ID</th>
            <th>Activity</th>
            <th>IP Address</th>
            <th>Time</th>
        </tr>
        <?php
            $logs_query = mysqli_query($con, "SELECT logs.*, users.username FROM logs JOIN users ON logs.user_id = users.id ORDER BY log_time DESC");
            while ($log = mysqli_fetch_assoc($logs_query)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($log['username']) . "</td>";
                echo "<td>" . htmlspecialchars($log['activity']) . "</td>";
                echo "<td>" . htmlspecialchars($log['ip_address']) . "</td>";
                echo "<td>" . $log['log_time'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>

<?php } else { ?>
    <!-- Section for regular user profile -->
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>Here is your profile information:</p>
    <ul>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($username); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
        <li><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></li>
    </ul>
    <p>If you believe you need additional permissions, please contact the admin.</p>
<?php }

?>
</main>

<!-- Toasted Group -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const params = new URLSearchParams(window.location.search);
        // التحقق إذا كان تم إضافة مقال بنجاح
        if (params.get("added") === "true") {
            // إظهار الرسالة
            const toastElement = document.getElementById("liveToast");
            const bsToast = new bootstrap.Toast(toastElement);
            bsToast.show();

            // إزالة المعلمة من الـ URL بعد عرض التوست
            setTimeout(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            }, 4000);
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const params = new URLSearchParams(window.location.search);
        // التحقق إذا كان تم إضافة مقال بنجاح
        if (params.get("added") === "true") {
            // إظهار الرسالة
            const toast = document.getElementById("toast");
            toast.classList.add("show");

            // إزالة الرسالة بعد 3.5 ثواني
            setTimeout(() => {
                toast.classList.remove("show");
                // إزالة المعلمة من الـ URL بعد إظهار الرسالة
                window.history.replaceState({}, document.title, window.location.pathname);
            }, 3500); // 3500 ملي ثانية = 3.5 ثانية
        }
    });
</script>

<!-- Bootstrap JS (اختياري لو هتستخدم توست أو مودال أو كومبوننت تفاعلي) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>