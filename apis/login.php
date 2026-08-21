<?php
session_start();

header("Content-Type: application/json");

// Allow CORS (optional)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit;
}

// Read input JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['email']) || !isset($input['password'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Email and password are required"
    ]);
    exit;
}

$email = $input['email'];
$password = $input['password'];

// Supabase Edge Function URL
$url = "https://mchfbsmlsgadpoawzwkk.supabase.co/functions/v1/login";

// Payload
$payload = json_encode([
    "email" => $email,
    "password" => $password
]);

// cURL request
$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
    CURLOPT_POSTFIELDS => $payload
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "cURL Error: " . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Decode Supabase response
$data = json_decode($response, true);

// Validate response
if ($httpCode === 200 && isset($data['success']) && $data['success'] === true) {

    // Store in session
    $_SESSION['token'] = $data['token'] ?? null;
    $_SESSION['user'] = $data['data'] ?? null;
    $_SESSION['is_logged_in'] = true;

    echo json_encode([
        "success" => true,
        "message" => $data['message'] ?? "Login successful",
        "data" => $data['data'],
        "token" => $data['token']
    ]);

} 
else
{

    // Send email if account is pending confirmation
    if (isset($data['profileStatus']) && $data['profileStatus'] === 'PENDING_CONFIRMATION') {
        require_once 'email-helper.php';

        $id = $data['id'];
        $subject = 'Account Confirmation Required';
        $body = '
            <h1>Account Pending Confirmation</h1>
            <p>Your account is currently pending confirmation.</p>
            <p>Please complete the verification process to activate your account.</p>
            <p>Activation Link: https://mchfbsmlsgadpoawzwkk.supabase.co/functions/v1/confirm-student-email?student_id='.$id.'</p>';

        $mailResponse = Mailer::sendMail(
            $email, // Send to user's email
            $subject,
            $body
        );
    }

    // Failure case
    http_response_code($httpCode ?: 400);

    echo json_encode([
        "success" => false,
        "message" => $data['message'] ?? "Login failed",
        "profileStatus" => $data['profileStatus'] ?? null
    ]);
}