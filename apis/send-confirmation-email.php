<?php



header('Content-Type: application/json');

require_once __DIR__ . '/email-helper.php';




if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);
    echo json_encode([
        'status' => false,
        'message' => 'Only POST requests are allowed'
    ]);
    exit;
}



// Accept JSON payload

$data = json_decode(file_get_contents('php://input'), true);

//print_r($data);return;  

$emailId = trim($data['emailId'] ?? '');

$guid = trim($data['guid'] ?? '');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$domain = $protocol . '://' . $_SERVER['HTTP_HOST'];

$link = $domain . '/tnt/email-confirmation.php?code=' . urlencode($guid);


if (empty($emailId) || empty($guid)) {

    echo json_encode([

        'status' => false,

        'message' => 'emailId and guid are required'

    ]);

    exit;

}



$subject = 'Transport & Tracking - Email Confirmation';



$body = "<html>
<head>
    <title>Transport & Tracking</title>
</head>
<body>
    <h2>Email confirmation required !</h2>
    <p>Please click the libk below to confirm you account.</p>
    <p>{$link}</p>
</body>
</html>
";



$result = Mailer::sendMail($emailId, $subject, $body);



echo json_encode($result);

?>