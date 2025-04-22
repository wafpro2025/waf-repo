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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: white;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #34495E;
        }

        th,
        td {
            border: 1px solid #2C3E50;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #2C3E50;
        }

        tr:nth-child(even) {
            background-color: #3E5773;
        }

        a {
            color: #1ABC9C;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn {
            background-color: #E74C3C;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #C0392B;
        }

        .actions a {
            margin: 0 5px;
        }

        .search-box {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-box input {
            padding: 8px;
            width: 40%;
            border-radius: 5px;
            border: none;
            font-size: 16px;
        }

        #loader {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            display: none;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loader = document.getElementById("loader");
            const table = document.getElementById("user-table");
            const search = document.getElementById("search");

            loader.style.display = "block";
            setTimeout(() => {
                loader.style.display = "none";
                table.style.display = "table";
            }, 500);

            // الاستماع لحدث الكتابة في مربع البحث
            search.addEventListener("keyup", function() {
                const filter = search.value.trim().toLowerCase();

                // تجاهل الكلمات القصيرة جدًا (مثل "ah" أو "so")
                if (filter.length < 3) {
                    return; // إذا كانت الكلمة أقل من 3 حروف، مش هنعمل شيء
                }

                if (filter.length === 0) {
                    const rows = table.querySelectorAll("tbody tr");
                    rows.forEach(row => row.style.display = "");
                    return;
                }

                // إرسال النص للتحقق من الأمان عبر PHP
                fetch("php/validate_search.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            text: filter
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        // إذا كان النص ضارًا، التوجيه إلى صفحة أخرى
                        if (data.prediction === 1) {
                            // إعادة التوجيه إلى صفحة الحظر
                            window.location.href = "blockpage.php";
                            return;
                        }

                        // فلترة الجدول بناءً على النص المدخل
                        const rows = table.querySelectorAll("tbody tr");
                        rows.forEach(row => {
                            const text = row.innerText.toLowerCase();
                            row.style.display = text.includes(filter) ? "" : "none";
                        });
                    })
                    .catch(err => {
                        console.error("حدث خطأ في التحقق:", err);
                    });
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h1>All Registered Users</h1>
        <p><a href="home.php" class="btn">Back to Dashboard</a></p>

        <div class="search-box">
            <input type="text" id="search" placeholder="Search users...">
        </div>

        <div id="loader">Loading...</div>

        <table id="user-table" style="display:none;">
            <thead>
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
            <tbody>
                <?php

                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['Age']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="actions">
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <?php if ($row['status'] === 'active') { ?>
                                <a href="block_user.php?id=<?php echo $row['id']; ?>" style="color:red;">Block</a>
                            <?php } else { ?>
                                <a href="unblock_user.php?id=<?php echo $row['id']; ?>" style="color:lightgreen;">Unblock</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>