<?php
session_start();  // بدء الجلسة لتمكين الوصول إلى البيانات المخزنة في الجلسة
include("php/config.php");  // تضمين ملف الاتصال بقاعدة البيانات
// التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
if (!isset($_SESSION['id'])) {  // إذا لم يكن معرف المستخدم موجودًا في الجلسة
    header("Location: index.php");  // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
    exit();  // إنهاء تنفيذ السكربت
}
// التحقق من حالة المستخدم
// استعلام لجلب حالة المستخدم من قاعدة البيانات
$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT status FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($query);

if ($row['status'] !== 'active') {
    // المستخدم محظور
    session_destroy(); // انهي الجلسة
    header("Location: index.php?blocked=true");
    exit();
}

if (isset($_POST['post_comment'])) {
    $comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);
    $blog_id = intval($_POST['blog_id']);
    $user_id = $_SESSION['id'];

    $insert = mysqli_query($con, "INSERT INTO comments (user_id, blog_id, comment_text) VALUES ($user_id, $blog_id, '$comment_text')");

    if ($insert) {
        $ip = $_SERVER['REMOTE_ADDR'];
        mysqli_query($con, "INSERT INTO logs (user_id, activity, ip_address) VALUES ($user_id, 'Posted a comment', '$ip')");

        // ✅ إعادة توجيه لمنع التكرار
        header("Location: user_profile.php");
        exit();
    } else {
        echo "<script>alert('Failed to post comment');</script>";
    }
}
$id = $_SESSION['id'];  // الحصول على معرف المستخدم من الجلسة
$query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");  // استعلام لجلب بيانات المستخدم من قاعدة البيانات باستخدام معرّف المستخدم
$result = mysqli_fetch_assoc($query);  // تحويل النتيجة إلى مصفوفة
$res_Uname = $result['username'];  // تخزين اسم المستخدم في متغير
$res_email = $result['email'];  // تخزين البريد الإلكتروني في متغير
$res_Age = $result['Age'];  // تخزين العمر في متغير

$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($con, $_POST['search']);
    $blog_query = mysqli_query($con, "SELECT * FROM blogs WHERE title LIKE '%$searchTerm%' OR content LIKE '%$searchTerm%' ORDER BY created_at DESC");
} else {
    $blog_query = mysqli_query($con, "SELECT * FROM blogs ORDER BY created_at DESC");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap-dark.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/pro_Style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <!-- ✅ شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_profile.php" title="go to main profile">Logo</a>
            <div class="d-flex align-items-center">
                <a href="Change_Profile.php" class="btn btn-danger me-2"
                    title="go to edit your name, age and email if you want">Edit Profile</a>
                <!-- ✅ الزر الجديد لتغيير صورة البروفايل -->
                <a href="upload_profile_pic.php"><button class="btn btn-danger me-2"
                        title="go to change profile pic ">Change
                        Picture</button></a>
                <a href="php/logout.php" class="btn btn-danger" title="Good-Bye for a second session">Log Out</a>
            </div>
        </div>
    </nav>

    <!-- ✅ قسم الملف الشخصي -->
    <main class="container my-4">
        <div class="card p-4 shadow-sm border-0">
            <header class="profile-header">
                <h2>Welcome, <?php echo htmlspecialchars($res_Uname); ?></h2>
            </header>

            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <!-- ✅ صورة الملف الشخصي -->
                    <div class="profile-picture">
                        <img src="<?php echo $result['profile_pic'] ? $result['profile_pic'] : 'uploads/default.jpg'; ?>"
                            width="150" height="150" style="border-radius: 50%; object-fit: cover; " />
                    </div>
                </div>

                <!-- ✅ معلومات المستخدم -->
                <div class="col-md-8">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($res_email); ?>
                        </li>
                        <li class="list-group-item"><strong>Age:</strong> <?php echo htmlspecialchars($res_Age); ?></li>
                    </ul>
                </div>
            </div>

            <!-- ✅ أزرار الإجراءات -->
            <!-- <div class="text-end mt-3">
                <a href="Change_Profile.php" class="btn btn-outline-primary w-100"
                    title="go to edit your name, age and email if you want">Edit Profile</a>
                //✅ الزر الجديد لتغيير صورة البروفايل 
                <a href="upload_profile_pic.php"><button class="btn btn-outline-primary w-100"
                        title="go to change profile pic ">Change
                        Picture</button></a>
            </div>  -->
        </div>

        <!-- ✅ End of User Profile Section -->

        <section class="container my-5">
            <h2>Security Reports and Importance of WAF</h2>
            <p>Welcome to our blog section! Here, we share insights and reports on the importance of Web Application
                Firewalls (WAF) and other security measures.</p>
            <p>Feel free to explore our latest posts and share your thoughts!</p>
            <p>We encourage you to leave comments and engage with our content.</p>
            <p>Use the search bar below to find specific topics or articles.</p>
            <p>We value your feedback and look forward to hearing from you!</p>
            <p>Happy reading!</p>
            <br>


            <div id="blogResults">
                <form method="GET" action="user_profile.php" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search blog titles or content..."
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-outline-primary" type="submit"
                        title="search about any thing inside the blogs content"><i
                            class="bi bi-search"></i>Search</button>
                </form>

                <?php

                if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                    $search = mysqli_real_escape_string($con, $_GET['search']);
                    $blog_query = mysqli_query($con, "SELECT * FROM blogs WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY created_at DESC");
                } else {
                    $blog_query = mysqli_query($con, "SELECT * FROM blogs ORDER BY created_at DESC");
                }
                if (mysqli_num_rows($blog_query) > 0) {
                    while ($blog = mysqli_fetch_assoc($blog_query)) {
                        echo '<div class="card mb-4 p-3 blog shadow-sm border-0">';
                        echo '<h3>' . htmlspecialchars($blog['title']) . '</h3>';
                        echo '<p>' . nl2br(htmlspecialchars($blog['content'])) . '</p>';
                        echo '<small class="text-muted">🕒 Posted on: ' . $blog['created_at'] . '</small>';
                        // 👇 هتحط الكود الجديد هنا 👇
                
                        $blog_id = $blog['id'];

                        // عرض التعليقات
                        $comment_query = mysqli_query($con, "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE blog_id = $blog_id ORDER BY created_at DESC");

                        echo '<div class="comment-section mt-4">';
                        echo '<h5 class="mb-3">Comments:</h5>';

                        // Comments list
                        echo '<ul class="list-group mb-3">';
                        while ($comment = mysqli_fetch_assoc($comment_query)) {
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start">';
                            echo '<div>';
                            echo '<strong>' . htmlspecialchars($comment['username']) . ':</strong> ';
                            echo '<span>' . htmlspecialchars($comment['comment_text']) . '</span>';
                            echo '<br><small class="text-muted">' . $comment['created_at'] . '</small>';
                            echo '</div>';

                            // ✅ إظهار زر الحذف لو المستخدم هو صاحب التعليق أو أدمن
                            if ($comment['user_id'] == $_SESSION['id'] || $_SESSION['role'] === 'admin') {
                                echo '<form action="delete_comment.php" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this comment?\');">';
                                echo '<input type="hidden" name="comment_id" value="' . $comment['id'] . '">';
                                echo '<button type="submit" class="btn btn-sm btn-danger ms-3">Delete</button>';
                                echo '</form>';
                            }

                            echo '</li>';
                        }
                        echo '</ul>';

                        // نموذج كتابة تعليق
                        echo '<form method="POST" class="comment-form mb-5">';
                        echo '  <input type="hidden" name="blog_id" value="' . $blog_id . '">';
                        echo '  <div class="input-group">';
                        echo '    <input type="text" name="comment_text" class="form-control" placeholder="Write a comment..." required>';
                        echo '    <button type="submit" name="post_comment" class="btn btn-primary" title="you can post your comment for all users with your name">Post</button>';
                        echo '  </div>';
                        echo '</form>';
                        echo '</div>';

                        echo '</div>';
                    }
                } else {
                    echo "<p>No blogs available yet.</p>";
                }
                ?>

            </div>

        </section>
    </main>

    <style>
        .comment-section {
            margin-top: 1rem;
        }

        body.dark-theme {
            background-color: #121212;
            color: #ffffff;
        }

        body.dark-theme .navbar {
            background-color: #222 !important;
            /* لون داكن مختلف عن الخلفية */
        }

        body.dark-theme .navbar .navbar-brand {
            color: #ffffff !important;
            /* لون النص داخل الـ navbar */
        }

        body.dark-theme .navbar .btn {
            background-color: #444 !important;
            /* لون الأزرار */
            color: white !important;
        }

        body.dark-theme .navbar .btn:hover {
            background-color: #555 !important;
        }

        body.dark-theme .card {
            background-color: #333 !important;
            /* لون البطاقات */
            color: #fff !important;
        }

        body.dark-theme .btn {
            background-color: #555 !important;
            color: white !important;
        }

        body.dark-theme .btn:hover {
            background-color: #444 !important;
        }

        body.dark-theme .profile-img {
            border: 3px solid #ffffff !important;
            /* لون الإطار حول الصورة */
        }


        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }


        .upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .upload-btn:hover {
            background-color: #0056b3;
        }

        .blogs-container {
            margin-top: 40px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            color: #333;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);


        }

        .search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .blog {
            background-color: #fff;
            padding: 30px 25px;
            margin-bottom: 35px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            color: #333;
            font-size: 17px;
            line-height: 1.8;
            transition: transform 0.3s ease;
        }

        .blog:hover {
            transform: translateY(-5px);
        }

        .blog h3 {
            font-size: 22px;
            color: #007bff;
            margin-bottom: 15px;
        }

        .comment {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .comment strong {
            color: #007bff;
        }

        .comment-text {
            font-size: 16px;
            line-height: 1.6;
        }

        body.dark-theme .comment-text {
            color: rgb(79, 42, 42) !important;
            /* تغيير اللون ليكون أكثر وضوحًا في الوضع الداكن */
        }

        .comment-form {
            margin-top: 20px;
        }

        .comment-input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .comment-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .comment-btn:hover {
            background-color: #218838;
        }

        .comment-form {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .comment-input {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .comment-btn {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .comment-btn:hover {
            background-color: #218838;
        }
    </style>


    <script>
        document.getElementById('searchForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting normally

            const formData = new FormData(this);

            fetch('user_profile.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(html => {
                    // Extract the blogResults section from the returned HTML
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newResults = doc.getElementById('blogResults');
                    if (newResults) {
                        document.getElementById('blogResults').innerHTML = newResults.innerHTML;
                    }
                });
        });


        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.comment-form');

            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // 👈 لازم السطر ده لمنع الإرسال العادي

                    const commentText = form.querySelector('[name="comment_text"]').value.trim();
                    const blogId = form.querySelector('[name="blog_id"]').value;
                    const commentList = form.previousElementSibling;

                    if (!commentText) return;

                    fetch('php/add_comment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'comment_text=' + encodeURIComponent(commentText) + '&blog_id=' + encodeURIComponent(blogId)
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const commentEl = document.createElement('li');
                                commentEl.className = 'list-group-item';
                                commentEl.innerHTML = `<strong>${data.username}:</strong> ${data.text}<br><small class="text-muted">${data.created_at}</small>`;
                                commentList.insertBefore(commentEl, commentList.firstChild);
                                form.reset();
                            } else {
                                alert("Error saving comment!");
                            }
                        })
                        .catch(error => {
                            console.error("AJAX error:", error);
                        });
                });
            });
        });
    </script>

</body>

</html>