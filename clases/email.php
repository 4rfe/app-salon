<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) 
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_host"];
        $mail->SMTPAuth = $_ENV["EMAIL_SMTPAuth"];
        $mail->Port = $_ENV["EMAIL_Port"];
        $mail->Username = $_ENV["EMAIL_Username"];
        $mail->Password = $_ENV["EMAIL_Password"];

        $mail->setFrom("cuentas@appsalon.com");
        $mail->addAddress("$this->email");
        $mail->Subject = "Confirma tu cuenta";

        //Set HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        
        $contenido = "<html>"; 
        $contenido .= "<p><strong>Hola " . $this->nombre ." </strong> Has creado tu cuenta en Appsalon, 
        solo debes de confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='". $_ENV["APP_URL"] ."/confirmar-cuenta?token=".$this->token."'>Confirmar cuenta </a> </p>";
        $contenido .= "<p>Si no solicitaste crear esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_host"];
        $mail->SMTPAuth = $_ENV["EMAIL_SMTPAuth"];
        $mail->Port = $_ENV["EMAIL_Port"];
        $mail->Username = $_ENV["EMAIL_Username"];
        $mail->Password = $_ENV["EMAIL_Password"];

        $mail->setFrom("cuentas@appsalon.com");
        $mail->addAddress("$this->email");
        $mail->Subject = "Reestablece tu password";

        //Set HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        
        $contenido = "<html>"; 
        $contenido .= "<p>Hola<strong> " . $this->nombre ." </strong> Has solicitado reestablecer tu password en Appsalon, 
        solo debes de confirmarlo presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='". $_ENV["APP_URL"] ."/recuperar?token=".$this->token."'>Reestablecer password </a> </p>";
        $contenido .= "<p>Si no solicitaste este cambio en tu cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }
}