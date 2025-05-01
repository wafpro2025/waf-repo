<?php
session_start();
include("php/config.php");

// Ensure the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /index.php");
    exit();
}

$query = mysqli_query($con, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #user-table tbody tr:hover {
            background-color: #2c3e50;
            transition: background-color 0.3s ease;
        }

        .btn {
            transition: all 0.3s ease-in-out;
            transform: scale(1);
        }

        .btn:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loader = document.getElementById("loader");
            const table = document.getElementById("user-table");
            const search = document.getElementById("search");

            loader.style.display = "block";
            setTimeout(() => {
                loader.style.display = "none";
                table.style.display = "table";
            }, 500);

            search.addEventListener("keyup", function () {
                const filter = search.value.toLowerCase();
                const rows = table.querySelectorAll("tbody tr");
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? "" : "none";
                });
            });
        });
    </script>
</head>

<body class="text-white" style="background: linear-gradient(to right, #0f2027, #203a43, #2c5364); min-height: 100vh;">
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-white">All Registered Users</h1>
        <p><a href="home.php" class="btn" style="background-color:#E74C3C; color:#fff; border:none;">Back to
                Dashboard</a></p>

        <div class="input-group mb-4">
            <input type="text" id="search" class="form-control" placeholder="Search users...">
        </div>

        <div id="loader" class="text-white text-center mb-3">Loading...</div>

        <table id="user-table" class="table text-white"
            style="background-color: #1f2d3a; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.3); display:none;">
            <thead style="background-color: #2C3E50;" class="text-center">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['Age']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="actions">
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn"
                                style="background-color:#F39C12; color:#fff; border:none;">Edit</a>
                            <?php if ($row['status'] === 'active') { ?>
                                <a href="block_user.php?id=<?php echo $row['id']; ?>" class="btn"
                                    style="background-color:#E74C3C; color:#fff; border:none;">Block</a>
                            <?php } else { ?>
                                <a href="unblock_user.php?id=<?php echo $row['id']; ?>" class="btn"
                                    style="background-color:#1ABC9C; color:#fff; border:none;">Unblock</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>