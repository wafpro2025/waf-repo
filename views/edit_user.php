<?php
session_start();
include("php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_start(); // لمنع أي طباعة غير مقصودة
}

include("php/smart_security_check.php"); // Include your smart security check function
// include("php/validateURL.php");
// Check if the user is an admin 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit();
}

// Check if a user ID is provided 
if (!isset($_GET['id'])) {
    die("User ID not specified.");
}

$user_id = intval($_GET['id']);

// Sanitize user ID 
// Fetch user data 
$query = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    die("User not found.");
}

// Handle form submission 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $age = intval($_POST['age']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $text_to_check = array($username . $age . $role .  $password . $email);
    smartSecurityCheck($text_to_check);

    // if (isset($result)) {
    //     // استخراج التنبؤ من الرد
    //     $prediction = $result;

    //     echo "<pre>Prediction response: " . $prediction . "</pre>";  // عرض التنبؤ للمساعدة في التصحيح

    //     // إذا كانت النتيجة 1، نقوم بحظر تسجيل الدخول
    //     if ($prediction == 1) {
    //         header("location:blockpage.php");
    //         exit(); // إيقاف عملية تسجيل الدخول
    //     }
    // } else {
    //     echo "<div class='message'>
    //         <p>Error: Unable to get prediction from the model.</p>
    //       </div>";
    //     exit();
    // }

    if (!empty($password)) {
        $hashed_password = hash("sha256", $password);
        $update_query = mysqli_query($con, "UPDATE users SET username='$username', email='$email', Age='$age', role='$role', password='$hashed_password' WHERE id=$user_id");
    } else {
        $update_query = mysqli_query($con, "UPDATE users SET username='$username', email='$email', Age='$age', role='$role' WHERE id=$user_id");
    }

    if ($update_query) {
        $admin_id = $_SESSION['id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        log_activity($admin_id, "Updated user ID $user_id profile", $ip_address);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'User updated successfully!']);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo json_encode(["success" => true, "message" => "Test JSON OK ✅"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('editUserForm');
            const passwordField = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');

            // Password strength validation
            passwordField.addEventListener('input', () => {
                const password = passwordField.value;
                if (password.length < 6) {
                    passwordStrength.textContent = 'Weak';
                    passwordStrength.style.color = 'red';
                } else if (password.match(/[A-Z]/) && password.match(/[0-9]/)) {
                    passwordStrength.textContent = 'Strong';
                    passwordStrength.style.color = 'lightgreen';
                } else {
                    passwordStrength.textContent = 'Medium';
                    passwordStrength.style.color = 'orange';
                }
            });

            // AJAX form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const request = new XMLHttpRequest();
                request.open("POST", window.location.href, true);

                request.onload = function() {
                    console.log("Raw response from server:", request.responseText); // ✅ هنا مكانه الصح

                    const responseMessage = document.getElementById('response-message');
                    if (request.status === 200) {
                        const response = JSON.parse(request.responseText);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    }
                };

                request.onerror = function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Failed',
                        text: 'Could not connect to the server.'
                    });
                };

                request.send(formData);
            });
        });
    </script>
</head>

<body>
    <div class="nav d-flex justify-content-between  navbar-dark bg-success p-4">
        <div class="logo">
            <a class="navbar-brand" href="home.php" title="go to your profile">Logo</a>
        </div>
        <div class="right-links">
            <a href="home.php">
                <button class="btn btn-danger" title="go back">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </a>
            <a href="php/logout.php">
                <button class="btn btn-danger" title="Good-Bye for a second session">Log Out</button>
            </a>
        </div>
    </div>



    <div class="container mt-5">
        <h1 class="text-center text-success mb-4">Edit User Controller</h1>
        <div class="text-center mb-3">
            <a href="view_all_users.php" class="btn btn-success">View All Users</a>
        </div>

        <form id="editUserForm" class="border rounded p-4 bg-light">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" id="username"
                    value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age:</label>
                <input type="number" class="form-control" name="age" id="age" value="<?php echo $user['Age']; ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" name="role" id="role" required>
                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="soc_analyst" <?php echo $user['role'] === 'soc_analyst' ? 'selected' : ''; ?>>SOC
                        Analyst</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password (leave blank to keep current):</label>
                <input type="password" class="form-control" name="password" id="password">
                <small id="password-strength" class="form-text mt-1"></small>
            </div>

            <button type="submit" class="btn btn-success w-100">Update User</button>
        </form>

        <div id="response-message" class="text-center mt-3 fw-bold"></div>
    </div>
</body>

</html>