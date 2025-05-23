<?php
include_once("config.php");
include("validateURL.php");

function getClientSignature()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';


    return hash('sha256', $ip . $user_agent);
}

function smartSecurityCheck($input)
{
    global $con;
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $client_signature = getClientSignature();
    $current_time = new DateTime();


    $stmt = $con->prepare("SELECT failed_attempts, blocked_until FROM client_fingerprint_block_list WHERE client_signature = ?");
    $stmt->bind_param("s", $client_signature);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    if ($client && $client['blocked_until'] !== null) {
        $blocked_until = new DateTime($client['blocked_until']);
        if ($current_time < $blocked_until) {
            header("Location: ../views/blockpage.php");
            exit();
        } else {
            $stmt = $con->prepare("UPDATE client_fingerprint_block_list SET failed_attempts = 0, blocked_until = NULL WHERE client_signature = ?");
            $stmt->bind_param("s", $client_signature);
            $stmt->execute();
        }
    }

    $prediction = validateURL($input);

    if ($prediction == 1) {
        if ($client) {
            $new_attempts = $client['failed_attempts'] + 1;

            if ($new_attempts >= 3) {
                $blocked_until = $current_time->add(new DateInterval('PT1M'))->format('Y-m-d H:i:s');
                $stmt = $con->prepare("UPDATE client_fingerprint_block_list SET failed_attempts = 0, blocked_until = ?, last_attempt_time = NOW() WHERE client_signature = ?");
                $stmt->bind_param("ss", $blocked_until, $client_signature);
                $stmt->execute();
                header("Location: ../views/blockpage.php");
                exit();
            } else {
                $stmt = $con->prepare("UPDATE client_fingerprint_block_list SET failed_attempts = ?, last_attempt_time = NOW() WHERE client_signature = ?");
                $stmt->bind_param("is", $new_attempts, $client_signature);
                $stmt->execute();
                $_SESSION['warning_message'] = "🚫 You have Entered $new_attempts please Enter valid inputs or You Will Be Blocked";
                header("Location: ../views/alert.php");
                exit();
            }
        } else {
            // أول محاولة فاشلة
            $stmt = $con->prepare("INSERT INTO client_fingerprint_block_list (client_signature, failed_attempts) VALUES (?, 1)");
            $stmt->bind_param("s", $client_signature);
            $stmt->execute();
            $_SESSION['warning_message'] = "⚠️You have Entered Illegal input please Enter valid inputs ";
            header("Location: ../views/alert.php");
            exit();
        }
    }

    // في حالة عدم وجود تهديد، لا تفعل شيئًا.
}
