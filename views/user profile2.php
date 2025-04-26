<?php
session_start();
include("php/config.php");

$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");
$result = mysqli_fetch_assoc($query);
$res_Uname = $result['username'];
$res_email = $result['email'];
$res_Age = $result['Age'];
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
    <link rel="stylesheet" href="css/pro_Style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <!-- ✅ شريط التنقل -->
    <nav class="navbar">
        <div class="logo">
            <a href="user_profile.php">Logo</a>
        </div>
        <div class="nav-links">
            <a href="Change_Profile.php">Change Profile</a>
            <a href="php/logout.php"><button class="btn logout-btn">Log Out</button></a>
        </div>
    </nav>

    <!-- ✅ قسم الملف الشخصي -->
    <main class="profile-container">
        <section class="profile-card">
            <header class="profile-header">
                <h2>Welcome, <?php echo htmlspecialchars($res_Uname); ?></h2>
            </header>

            <div class="profile-content">
                <!-- ✅ صورة الملف الشخصي -->
                <div class="profile-picture">
                    <img src="<?php echo $res_profile_pic; ?>" alt="Profile Picture" class="profile-img">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="profile_pic" required>
                        <button type="submit" name="upload_pic" class="btn upload-btn">Upload New Picture</button>
                    </form>
                </div>

                <!-- ✅ معلومات المستخدم -->
                <div class="user-info">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($res_email); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($res_Age); ?></p>
                </div>
            </div>

            <!-- ✅ أزرار الإجراءات -->
            <div class="profile-actions">
                <a href="Change_Profile.php"><button class="btn">Edit Profile</button></a>
            </div>
        </section>

        <!-- ✅ End of User Profile Section -->

        <section class="blogs-container">
            <h2>Security Reports and Importance of WAF</h2>

            <input type="text" id="searchBar" placeholder="Search blogs..." onkeyup="searchBlogs()" class="search-bar">

            <div id="blogs">
                <div class="blog">
                    <h3>🔒 What is a Web Application Firewall (WAF)?</h3>
                    <p>Hello Readers,</p>
                    <p>A Web Application Firewall (WAF) protects web applications by filtering and monitoring HTTP
                        traffic between a web application and the Internet.</p>
                    <p>It helps prevent attacks such as SQL injection, cross-site scripting (XSS), and other
                        vulnerabilities.</p>
                    <p>WAFs are essential for ensuring the security of any online service or website.</p>
                </div>

                <div class="blog">
                    <h3>⚡ Why WAFs are Crucial in 2025</h3>
                    <p>With the increasing sophistication of cyber threats, having a WAF is no longer optional.</p>
                    <p>It acts as the first line of defense against many types of attacks targeting application
                        vulnerabilities.</p>
                    <p>The role of WAFs is critical especially as more businesses shift their operations online, making
                        them prime targets for attackers.</p>
                </div>

                <div class="blog">
                    <h3>🛡️ Best Practices for Web Application Security</h3>
                    <p>Besides using a WAF, it's crucial to perform regular security updates, patch known
                        vulnerabilities, conduct security audits, and follow secure coding practices.</p>
                    <p>Layered security measures provide stronger protection for web applications and help maintain the
                        trust of users and clients.</p>
                </div>
            </div>
        </section>
    </main>

    <style>
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
        function searchBlogs() {
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
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.ajax-comment-form');

            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    formData.append('submit_comment_ajax', '1');

                    fetch('php/handle_comment.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const commentSection = form.previousElementSibling;
                                const newComment = document.createElement('div');
                                newComment.classList.add('comment');
                                newComment.innerHTML = `<strong>${data.username}:</strong> ${data.comment_text}`;
                                commentSection.appendChild(newComment);
                                form.reset();
                            } else {
                                alert(data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>

</body>

</html>