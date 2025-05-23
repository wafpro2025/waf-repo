<!--    related to home page admin page     -->
<?php
session_start();
include("php/config.php");// Ensure you're including your database connection

// Fetch user data from the database when the page is loaded
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");
    $result = mysqli_fetch_assoc($query);

    // Set initial values for the form
    $res_Uname = $result['username'];
    $res_email = $result['email'];
    $res_Age = $result['Age'];
}
// Fetch user data from the database when the page is loaded
else {
    echo "No user session found.";// If session is not found
}

// Process form submission to update profile
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $Age = $_POST['Age'];
    $id = $_SESSION['id'];

    // Update the user profile in the database
    $edit_query = mysqli_query($con, "UPDATE users SET username='$username', email='$email', Age='$Age' WHERE id=$id");

    if ($edit_query) {
        $_SESSION['username'] = $username;
        $_SESSION['valid'] = $email;
        $_SESSION['Age'] = $Age;

        // Get IP Address
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Log profile update
        log_activity($id, "Updated profile information", $ip_address);
        echo "<div class='alert alert-success mt-3'>Profile Updated!</div>";
        echo "<a href='home.php' class='btn btn-success mt-3'>Go Home</a>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .form-box {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease;
        }

        .btn-custom {
            background-color: #2c3e50;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #16a085;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="nav d-flex justify-content-between p-3">
        <div class="logo">
            <a class="navbar-brand" href="home.php" title="go to your profile">Logo</a>
        </div>
        <div class="right-links">
            <a href="home.php">
                <button class="btn btn-danger" title="go back">
                    <i class="fas fa-arrow-left"></i>Back
                </button>
            </a>
            <a href="php/logout.php">
                <button class="btn btn-danger" title="Good-Bye for a second session">Log Out</button>
            </a>
        </div>
    </div>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="form-box box col-md-6">
            <h2 class="text-uppercase mb-4 text-success">Change Profile</h2>
            <form action="" method="post">
                <div class="mb-3 text-start">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username"
                        value="<?php echo htmlspecialchars($res_Uname); ?>" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="<?php echo htmlspecialchars($res_email); ?>" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="Age" class="form-label">Age</label>
                    <input type="number" class="form-control" name="Age" id="Age"
                        value="<?php echo htmlspecialchars($res_Age); ?>" required>
                </div>
                <div class="d-grid">
                    <input type="submit" name="submit" class="btn btn-custom" value="Update">
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
        setTimeout(() => {
            alertBox.remove();
        }, 3000);
    }
</script>

</html>