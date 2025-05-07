<?php
include_once("config.php");
include("validateURL.php");

function smartSecurityCheck($input)
{
    global $con;
    if ($con->connect_error) {
        die("connect_error: " . $con->connect_error);
    }

    $current_time = new DateTime();

    if (isset($_SESSION['user_id'])) {
        // ✅ الحالة 1: المستخدم مسجل دخول
        $user_id = $_SESSION['user_id'];

        $stmt = $con->prepare("SELECT failed_attempts, blocked_until, status FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user['status'] === 'blocked' && $user['blocked_until'] !== null) {
            $blocked_until = new DateTime($user['blocked_until']);
            if ($current_time < $blocked_until) {
                header("Location: ../views/blockpage.php");
                exit();
            } else {
                // فك الحظر
                $stmt = $con->prepare("UPDATE users SET status = 'active', blocked_until = NULL, failed_attempts = 0 WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
            }
        }

        $prediction = validateURL($input);

        if ($prediction == 1) {
            $new_attempts = $user['failed_attempts'] + 1;

            if ($new_attempts >= 3) {
                $blocked_until = $current_time->add(new DateInterval('PT3M'))->format('Y-m-d H:i:s');
                $stmt = $con->prepare("UPDATE users SET failed_attempts = 0, status = 'blocked', blocked_until = ? WHERE id = ?");
                $stmt->bind_param("si", $blocked_until, $user_id);
                $stmt->execute();
                header("Location: ../views/blockpage.php");
                exit();
            } else {
                $stmt = $con->prepare("UPDATE users SET failed_attempts = ? WHERE id = ?");
                $stmt->bind_param("ii", $new_attempts, $user_id);
                $stmt->execute();
                die("the number of attempts : " . $new_attempts);
            }
        } else {
            $stmt = $con->prepare("UPDATE users SET failed_attempts = 0, blocked_until = NULL WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        }
    } else {
        // ✅ الحالة 2: المستخدم غير مسجل دخول → استخدم IP
        $ip = $_SERVER['REMOTE_ADDR'];

        $stmt = $con->prepare("SELECT failed_attempts, blocked_until FROM ip_block_list WHERE ip_address = ?");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $ip_data = $result->fetch_assoc();

        if ($ip_data && $ip_data['blocked_until'] !== null) {
            $blocked_until = new DateTime($ip_data['blocked_until']);
            if ($current_time < $blocked_until) {
                header("Location: ../views/blockpage.php");
                exit();
            } else {
                $stmt = $con->prepare("UPDATE ip_block_list SET failed_attempts = 0, blocked_until = NULL WHERE ip_address = ?");
                $stmt->bind_param("s", $ip);
                $stmt->execute();
            }
        }

        $prediction = validateURL($input);

        if ($prediction == 1) {
            if ($ip_data) {
                $new_attempts = $ip_data['failed_attempts'] + 1;

                if ($new_attempts >= 3) {
                    $blocked_until = $current_time->add(new DateInterval('PT3M'))->format('Y-m-d H:i:s');
                    $stmt = $con->prepare("UPDATE ip_block_list SET failed_attempts = 0, blocked_until = ? WHERE ip_address = ?");
                    $stmt->bind_param("ss", $blocked_until, $ip);
                    $stmt->execute();
                    header("Location: ../views/blockpage.php");
                    exit();
                } else {
                    $stmt = $con->prepare("UPDATE ip_block_list SET failed_attempts = ? WHERE ip_address = ?");
                    $stmt->bind_param("is", $new_attempts, $ip);
                    $stmt->execute();
                    die("the number of attempts : " . $new_attempts);
                }
            } else {
                $stmt = $con->prepare("INSERT INTO ip_block_list (ip_address, failed_attempts) VALUES (?, 1)");
                $stmt->bind_param("s", $ip);
                $stmt->execute();
                die("⚠️  (1 من 3).");
            }
        }

        // لا يوجد تهديد: لا تفعل شيء
    }

    // $con->close();
}
