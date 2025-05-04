<?php

namespace App\Core;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer{

    private static $hostname;
    private static $username;
    private static $password;
    private static $portnumber;
    private static $sendername;

    public function __construct(){
        self::$hostname = Environment::env("mailer_hostname");
        self::$username = Environment::env("mailer_username");
        self::$password = Environment::env("mailer_password");
        self::$portnumber = Environment::env("mailer_portnumber");
        self::$sendername = Environment::env("mailer_sendername");
    }

    public static function send(string $recepient, string $subject, string $message){

        $mail = new PHPMailer(true);

        try{
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = self::$hostname;
            $mail->SMTPAuth   = true;
            $mail->Username   = self::$username;
            $mail->Password   = self::$password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = self::$portnumber;
            
            $mail->setFrom(self::$username,self::$sendername);
            $mail->addAddress($recepient);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
        
            return $mail->send();
        }
        catch(Exception $error){            
            Logging::record("error",$error,self::class);
            return false;
        }
    }
}