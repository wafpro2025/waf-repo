<?php
include("validateURL.php");

header("Content-Type: application/json");

// قراءة البيانات من الطلب
$input = json_decode(file_get_contents("php://input"), true);
$text = $input['text'] ?? '';

if (empty($text)) {
    echo json_encode(["error" => "empty input"]);
    exit();
}

// فحص النص باستخدام الموديل
$prediction = validateURL($text);

echo json_encode(["prediction" => $prediction]);
