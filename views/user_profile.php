<?php
session_start();
include("php/config.php");

$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");
$result = mysqli_fetch_assoc($query);
$res_Uname = $result['username'];
$res_email = $result['email'];
$res_Age = $result['Age'];
if (isset($_POST['post_comment'])) {
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $user_id = $_SESSION['id'];
    $blog_id = 1; // لو عندك نظام مقالات فعلية خليه ديناميكي

    $insert = mysqli_query($con, "INSERT INTO comments (user_id, blog_id, comment_text) VALUES ($user_id, $blog_id, '$comment')");
    if (!$insert) {
        die("MySQL Error: " . mysqli_error($con));
    }
    if ($insert) {
        // ✅ تسجيل في اللوج
        $ip = $_SERVER['REMOTE_ADDR'];
        $log = "INSERT INTO logs (user_id, action, ip_address) VALUES ($user_id, 'Posted a comment', '$ip')";
        mysqli_query($con, $log);
    } else {
        echo "<script>Swal.fire('Error!', 'Failed to post comment.', 'error');</script>";
    }
}
$res_profile_pic = !empty($result['profile_pic']) ? htmlspecialchars($result['profile_pic']) : "uploads/default-avatar.png"; // صورة افتراضية

// ✅ التعامل مع رفع صورة الملف الشخصي
if (isset($_POST['upload_pic'])) {
    $target_dir = "";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ✅ التحقق من أن الملف صورة
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>Swal.fire('message error!', 'File is not an image.', 'error');</script>";
        $uploadOk = 0;
    }

    // ✅ السماح فقط بـ JPG و JPEG و PNG
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        echo "<script>Swal.fire('Only JPG, JPEG, and PNG files are allowed.', 'error');</script>";
        $uploadOk = 0;
    }

    // ✅ نقل الملف المرفوع وتحديث قاعدة البيانات
    if ($uploadOk && move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        mysqli_query($con, "UPDATE users SET profile_pic='$target_file' WHERE id=$id");
        $_SESSION['profile_pic'] = $target_file;
        echo "<script>Swal.fire( 'Profile picture updated successfully!'.', 'success').then(() => location.reload());</script>";
    } else {
        echo "<script>Swal.fire('There was an error uploading your file.', 'error');</script>";
    }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/pro_Style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const toggleTheme = () => {
            const currentTheme = localStorage.getItem('theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', newTheme);
            document.body.classList.toggle('dark-theme', newTheme === 'dark');
        };

        const currentTheme = localStorage.getItem('theme') || 'light';
        document.body.classList.toggle('dark-theme', currentTheme === 'dark');
    </script>

</head>

<body>
    <!-- ✅ شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_profile.php">Logo</a>
            <div class="d-flex align-items-center">
                <button class="btn btn-secondary me-2" onclick="toggleTheme()">Toggle Theme</button>
                <a href="Change_Profile.php" class="btn btn-light me-2">Change Profile</a>
                <a href="php/logout.php" class="btn btn-danger">Log Out</a>
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
                        <img src="<?php echo $res_profile_pic; ?>" class="profile-img">
                        <form action="" method="post" enctype="multipart/form-data" class="mt-2">
                            <input type="file" name="profile_pic" class="form-control mb-2" required>
                            <button type="submit" name="upload_pic" class="btn btn-primary w-100">Upload New
                                Picture</button>
                        </form>
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
            <div class="text-end mt-3">
                <a href="Change_Profile.php" class="btn btn-outline-primary w-100">Edit Profile</a>
            </div>
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


            <input type="text" id="searchBar" placeholder="Search blogs..." onkeyup="filterBlogs()" class="search-bar">

            <div id="blogs">
                <?php
                $comments = mysqli_query($con, "SELECT users.username, comment_text, created_at FROM comments JOIN users ON comments.user_id = users.id WHERE blog_id = 1 ORDER BY created_at DESC");

                while ($row = mysqli_fetch_assoc($comments)) {
                    echo "<div class='comment'><strong>{$row['username']}:</strong><p class='comment-text'>{$row['comment_text']}</p></div>";
                }
                ?>
                <div class="card mb-4 p-3 blog shadow-sm border-0">
                    <h3>🔒 What is a Web Application Firewall (WAF)?</h3>
                    <p>Hello Readers,</p>
                    <p>A Web Application Firewall (WAF) protects web applications by filtering and monitoring HTTP
                        traffic between a web application and the Internet.</p>
                    <p>It helps prevent attacks such as SQL injection, cross-site scripting (XSS), and other
                        vulnerabilities.</p>
                    <p>WAFs are essential for ensuring the security of any online service or website.</p>
                </div>

                <div class="card mb-4 p-3 blog">
                    <h3>⚡ Why WAFs are Crucial in 2025</h3>
                    <p>With the increasing sophistication of cyber threats, having a WAF is no longer optional.</p>
                    <p>It acts as the first line of defense against many types of attacks targeting application
                        vulnerabilities.</p>
                    <p>The role of WAFs is critical especially as more businesses shift their operations online,
                        making
                        them prime targets for attackers.</p>
                </div>

                <div class="card mb-4 p-3 blog">
                    <h3>🛡️ Best Practices for Web Application Security</h3>
                    <p>Besides using a WAF, it's crucial to perform regular security updates, patch known
                        vulnerabilities, conduct security audits, and follow secure coding practices.</p>
                    <p>Layered security measures provide stronger protection for web applications and help maintain the
                        trust of users and clients.</p>

                    <div class="comment-section mt-4">
                        <div class="comment">
                            <strong>User1:</strong>
                            <p class="comment-text">Great article! Very informative.</p>
                        </div>
                        <form id="commentForm">
                            <div class="input-group">
                                <textarea class="form-control" id="commentInput" placeholder="Write your comment..."
                                    required></textarea>
                                <button type="submit" class="btn btn-success">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Contact -->
            <div class="card mb-4 p-3">
                <h2>Contact</h2>
                <p>If you have any questions or feedback, feel free to reach out!</p>
                <i class="fa fa-phone" style="width:30px"></i> Phone: +00 151515<br>
                <i class="fa fa-envelope" style="width:30px"> </i> Email: mail@mail.com<br>
                <form class="mt-4">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Name" required name="Name">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Message" required name="Message">
                    </div>
                    <button type="submit" class="btn btn-dark">SEND MESSAGE</button>
                </form>
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

        .profile-picture {
            text-align: center;
            margin-bottom: 15px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            background-color: #f1f1f1;
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
        function filterBlogs() {
            var input, filter, blogs, blog, h3, p, i, txtValue;
            input = document.getElementById('searchBar');
            filter = input.value.toLowerCase();
            blogs = document.getElementById("blogs");
            blog = blogs.getElementsByClassName('blog');

            for (i = 0; i < blog.length; i++) {
                h3 = blog[i].getElementsByTagName("h3")[0];
                p = blog[i].getElementsByTagName("p")[0];
                txtValue = h3.textContent + " " + p.textContent;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    blog[i].style.display = "";
                } else {
                    blog[i].style.display = "none";
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.comment-form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // e.preventDefault();

                    const commentText = form.querySelector('.comment-input').value;
                    const commentSection = form.previousElementSibling;

                    const newComment = document.createElement('div');
                    newComment.classList.add('comment');
                    newComment.innerHTML = `<strong>You:</strong> <p class="comment-text">${commentText}</p>`;

                    commentSection.appendChild(newComment);
                    form.reset();
                });
            });
        });
    </script>
    <script>
        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const commentText = document.getElementById('commentInput').value.trim();
            if (!commentText) return;

            fetch('views/save_comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'comment=' + encodeURIComponent(commentText)
                })
                .then(response => response.text())
                .then(result => {
                    if (result === 'success') {
                        const newComment = document.createElement('div');
                        newComment.className = 'comment';
                        newComment.innerHTML = `<strong>You:</strong><p class="comment-text">${commentText}</p>`;
                        document.getElementById('commentSection').prepend(newComment);
                        document.getElementById('commentInput').value = '';
                    }
                });
        });
    </script>

</body>

</html>