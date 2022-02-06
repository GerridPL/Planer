<?php

namespace App\Http\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class SendEmailService
{
    public static function sendEmailAddChecklist($emailAddress, $user, $checklist, $term)
    {
        $mail = new PHPMailer();

        try {

            (new self)->serverSettings($mail);
            $mail->addAddress($emailAddress);

            //Content
            $mail->isHTML(true);
            $mail->Subject = "Przypisana lista $checklist";
            $mail->Body    = "Użytkownik $user właśnie przypisał do Ciebie listę kontrolną '$checklist', którą powinieneś wykonać do końca dnia $term.";

            $mail->send();
            echo 'Wiadomość z potwierdzeniem została wysłana';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public static function sendEmailDeleteChecklist($emailAddress, $user, $checklist)
    {
        $mail = new PHPMailer();

        try {

            (new self)->serverSettings($mail);
            $mail->addAddress($emailAddress);

            //Content
            $mail->isHTML(true);
            $mail->Subject = "Usunięta lista $checklist";
            $mail->Body    = "Użytkownik $user właśnie usunął przypisaną do Ciebie listę '$checklist'.";

            $mail->send();
            echo 'Wiadomość z potwierdzeniem została wysłana';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public static function sendEmailEditChecklist($emailAddress, $user, $checklist, $term, $oldName, $oldTerm)
    {
        $mail = new PHPMailer();

        try {

            (new self)->serverSettings($mail);
            $mail->addAddress($emailAddress);

            //Content
            $mail->isHTML(true);
            $mail->Subject = "Przypisana lista $oldName została edytowana";
            $mail->Body    = "<p>Użytkownik $user właśnie edytował przypisaną do Ciebie listę.</p> <p>Wcześniejsza nazwa: $oldName</p>
             <p>Obecna nazwa: $checklist</p> <p>Wcześniejszy termin: $oldTerm</p> <p>Obecny termin: $term</p>";

            $mail->send();
            echo 'Wiadomość z potwierdzeniem została wysłana';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public static function sendEmail($emailAddress,$key)
    {
        $mail = new PHPMailer();

        try {
            (new self)->serverSettings($mail);
            $mail->addAddress($emailAddress);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Zaproszenie do planera';
            $mail->Body    = "Aby dokonać rejestracji proszę przejść na poniższą stronę <br> http://127.0.0.1:8000/register/$key";

            $mail->send();
            echo 'Wiadomość została wysłana';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public static function serverSettings($mail)
    {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = config('mail.mailers.smtp.host');
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = config('mail.mailers.smtp.encryption');
        $mail->Username   = config('mail.mailers.smtp.username');
        $mail->Password   = config('mail.mailers.smtp.password');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = config('mail.mailers.smtp.port');
        $mail->CharSet    = 'UTF-8';

        $emailFrom = config('mail.mailers.smtp.username');
        //Recipients
        $mail->setFrom($emailFrom, 'Planer procesów biznesowych');
    }
}
