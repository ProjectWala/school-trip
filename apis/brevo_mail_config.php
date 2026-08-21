<?php
/**
 * Brevo Mail Configuration (Importable)
 * ------------------------------------
 * Usage:
 * require_once 'brevo_mail_config.php';
 * 
 * $brevo = new BrevoMailer();
 * 
 * $response = $brevo->sendMail(
 *     'recipient@example.com',
 *     'Recipient Name',
 *     'Test Subject',
 *     '<h1>Hello from Brevo</h1><p>This is a test email.</p>'
 * );
 * 
 * print_r($response);
 */

class BrevoMailer
{
    private $apiKey = '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';
    private $senderEmail ='schooltrp3@gmail.com';
    private $senderName = 'Transport & Tracking';

    public function __construct()
    {       
    }

    public function sendMail($toEmail, $toName, $subject, $htmlContent)
    {
        $data = [
            'sender' => [
                'name' => $this->senderName,
                'email' => $this->senderEmail
            ],
            'to' => [
                [
                    'email' => $toEmail,
                    'name' => $toName
                ]
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'api-key: ' . $this->apiKey,
            'content-type: application/json'
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return [
                'success' => false,
                'error' => curl_error($ch)
            ];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'success' => ($httpCode >= 200 && $httpCode < 300),
            'status_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }
}
?>
