<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/libs/PHPMailer/src/SMTP.php';



class Mailer
{

    private static string $host = 'smtp.gmail.com';
    private static string $username = 'mohit.xxx@gmail.com';
    private static string $password = 'uxvp cocd vdue jrnr';
    private static string $fromEmail = 'mohit.xxx@gmail.com';
    private static string $fromName = 'Mohit Sharma';



    /**

     * Send raw HTML email

     */

    public static function sendMail(string $to, string $subject, string $body): array
    {



        try {

            $mail = self::getMailer();
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->SMTPDebug = 2; // or SMTP::DEBUG_SERVER
            $mail->Debugoutput = 'html';

            $mail->send();
            return [

                'status' => true,
                'message' => 'Email sent successfully',
                'to' => $to
            ];



        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];

        }

    }



    /**

     * Send email using template

     */

    public static function sendTemplateMail(string $to, string $templateName, array $params = []): array
    {

        $templateFile = __DIR__ . "/templates/{$templateName}.html";

        if (!file_exists($templateFile)) {

            return [

                'status' => false,
                'message' => "Template not found: {$templateName}"
            ];
        }


        $html = file_get_contents($templateFile);

        foreach ($params as $key => $value) {
            $html = str_replace(
                '{{' . $key . '}}',
                htmlspecialchars((string) $value),
                $html
            );

        }

        $subject = $params['subject'] ?? ucfirst(str_replace('_', ' ', $templateName));

        return self::sendMail($to, $subject, $html);

    }



    /**

     * PHPMailer factory

     */

    private static function getMailer(): PHPMailer
    {

        $mail = new PHPMailer(true);


        $mail->isSMTP();
        $mail->Host = self::$host;
        $mail->SMTPAuth = true;
        $mail->Username = self::$username;
        $mail->Password = self::$password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom(self::$fromEmail, self::$fromName);

        $mail->isHTML(true);

        return $mail;

    }

}

?>