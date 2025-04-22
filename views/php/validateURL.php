<?php

function validateURL($text_to_check)
{

    $api_url = 'http://127.0.0.1:5000/predict';
    $data = json_encode(["text" => $text_to_check]);
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    $responseData = json_decode($response, true);
    return $responseData["predictions"][0];
}
