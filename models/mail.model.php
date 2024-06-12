<?php
//A mail model that sends an email
//iT uses PHPMailer
//It is a child class of the Database class
require_once 'models/database.model.php';
require 'vendor/autoload.php';


class Mail Extends Database {
    public $mail;
    public $token;
    public function __construct() {
        parent::__construct();
        $this->mail = new PHPMailer\PHPMailer\PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = getenv('MAIL_HOST');
        $this->mail->SMTPAuth = true;
        $this->mail->Username = getenv('MAIL_USER');
        $this->mail->Password = getenv('MAIL_PASS');
        $this->mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = getenv('MAIL_PORT');
    }

    public function send($email, $token,$mail,$hydrate=false) {
        $this->mail->clearAddresses();
        $this->mail->setFrom(''.getenv('MAIL_USER').'', 'Operis Mailer');
        $this->mail->addAddress($email);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Verification token';
        $this->mail->Body = $mail;
        //Replace the {token} placeholder with the actual token
        if($hydrate)
        {
            $this->hydrateMail($token);
        }
        if ($this->mail->send()) {
            return true;
        } else {
            //echo out any errors
            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            return false;
        }
    }

    public function hydrateMail($token)
    {
        //Replace the {token} placeholder with the actual token
        $this->mail->Body = str_replace('{token}',$token, $this->mail->Body);
    }
}

?>