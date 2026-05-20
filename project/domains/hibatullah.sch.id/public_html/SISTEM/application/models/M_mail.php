<?php
class M_mail extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        require APPPATH . 'libraries/PHPMailer/src/Exception.php';
        require APPPATH . 'libraries/PHPMailer/src/PHPMailer.php';
        require APPPATH . 'libraries/PHPMailer/src/SMTP.php';
    }
    function SendMail($email_to, $subject, $mailContent)
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->isSMTP();
        $mail->Host     = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ppdb@hibatullah.sch.id';
        $mail->Password = 'Hibatullah@2023';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->setFrom('ppdb@hibatullah.sch.id', 'PPDB SISTEM');
        // $mail->addReplyTo('officialsiata@gmail.com', '');
        // $mail->AddCC('apollogical@gmail.com', 'Admin Test');
        $mail->addAddress((implode(',', $email_to)));
        $mail->Subject = $subject;

        $mail->isHTML(true);
        $mail->Body = $mailContent;

        if (!$mail->send()) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return 'Message has been sent';
        }
    }
}
