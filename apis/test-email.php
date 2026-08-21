<?php
require_once __DIR__ . '/email-helper.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || empty($data['email'])) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

$to = $data['email'];
$subject = "Test Email from School Trip";
$body = "<h2>Hello!</h2><p>This is a test email sent from the School Trip login page.</p>";

ob_start();
$result = Mailer::sendMail($to, $subject, $body);
$debug_output = ob_get_clean();

if ($result['status']) {
    echo json_encode(['success' => true, 'message' => 'Test email sent successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send email: ' . $result['message'], 'debug' => $debug_output]);
}
?>
