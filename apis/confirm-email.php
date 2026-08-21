<?php

if (!isset($_GET['code']) || empty($_GET['code'])) {
    http_response_code(400);
    echo "Missing code parameter";
    exit;
}

$code = urlencode($_GET['code']);

$url = "https://mchfbsmlsgadpoawzwkk.supabase.co/functions/v1/confirm-student-email?student_id={$code}";

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 30,
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($statusCode);
echo $response;