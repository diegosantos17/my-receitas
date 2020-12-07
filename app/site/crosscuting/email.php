<?php

namespace app\site\crosscuting;

// Carregar o autoloader do composer
require "../../vendor/autoload.php";

// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require "../../vendor/phpmailer/phpmailer/src/Exception.php";
// require "../../vendor/phpmailer/phpmailer/src/PHPMailer.php";
// require "../../vendor/phpmailer/phpmailer/src/SMTP.php";

class Email {

    static function enviarEmail()
    {
        try
        {
            // Instância da classe
            $mail = new PHPMailer(true);

            // Configurações do servidor
            $mail->isSMTP();        //Devine o uso de SMTP no envio
            $mail->SMTPAuth = true; //Habilita a autenticação SMTP
            $mail->Username   = 'diegosr.trainning@gmail.com';
            $mail->Password   = 'SENHA';
            // Criptografia do envio SSL também é aceito
            $mail->SMTPSecure = 'tls';
            // Informações específicadas pelo Google
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            // Define o remetente
            $mail->setFrom('diegosantos17@gmail.com', 'Diego Trainning');
            // Define o destinatário
            $mail->addAddress('diegosantos17@gmail.com', 'Diego Rodrigues');

            // Conteúdo da mensagem
            $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
            $mail->Subject = 'Recuperação de senha';
            $mail->Body    = 'Este é o corpo da mensagem <b>Olá em negrito!</b>';
            $mail->AltBody = 'Este é o cortpo da mensagem para clientes de e-mail que não reconhecem HTML';

            // Enviar
            $mail->send();
            return true;
        }
        catch (Exception $e)
        {
            Log::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}