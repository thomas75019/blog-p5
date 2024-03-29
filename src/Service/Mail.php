<?php

namespace Blog\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Blog\Config\MailConfig;

/**
 * Class Mail
 *
 * Send a contact email with gmail
 *
 * @package Blog\Service
 */
class Mail
{
    /**
     * Send an email with Gmail
     *
     * @param string $message
     * @param string $contactEmail
     *
     * @return bool|string
     *
     * @throws Exception
     */
    public function sendSmtp($message, $contactEmail)
    {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = MailConfig::$_mail;
        $mail->Password = MailConfig::$_password;

        $mail->setFrom($contactEmail);
        $mail->Subject = 'Nouvelle demande de contact';
        $mail->addAddress(MailConfig::$_mail, 'Your Name');
        $mail->msgHTML($message);

        if (!$mail->Send()) {
            return 'Mail error: '.$mail->ErrorInfo;
        }

        return true;
    }
}
