<?php

namespace app\crosscuting;

// Carregar o autoloader do composer
require "../../vendor/autoload.php";

// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * classDescription="Classe responsável por enviar emails gerais" 
 */
class Email {

    static function enviarEmail($email, $nome, $token = "")
    {
        try
        {
            // Instância da classe
            $mail = new PHPMailer(true);

            // Configurações do servidor
            $mail->isSMTP();        //Devine o uso de SMTP no envio
            $mail->SMTPAuth = true; //Habilita a autenticação SMTP
            $mail->Username   = EMAIL_USERNAME;
            $mail->Password   = EMAIL_SENHA;
            // Criptografia do envio SSL também é aceito
            $mail->SMTPSecure = 'tls';
            // Informações específicadas pelo Google
            $mail->Host = EMAIL_SMTP;
            $mail->Port = EMAIL_PORT;
            // Define o remetente
            $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
            // Define o destinatário
            $mail->addAddress($email, $nome);

            // Conteúdo da mensagem
            $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
            $mail->Subject = 'Recuperação de senha';
            $mail->Body    = '<p>Olá <b>' . $nome . '!</b></p><p><a href="' . HOST . BASE . 'usuario/resetPassword/' . $token . '">Clique aqui</a> para redefinir sua senha.</p>';
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

    static function enviarEmailErro($email, $nome, $erro)
    {
        try
        {
            // Instância da classe
            $mail = new PHPMailer(true);

            // Configurações do servidor
            $mail->isSMTP();        //Devine o uso de SMTP no envio
            $mail->SMTPAuth = true; //Habilita a autenticação SMTP
            $mail->Username   = EMAIL_USERNAME;
            $mail->Password   = EMAIL_SENHA;
            // Criptografia do envio SSL também é aceito
            $mail->SMTPSecure = 'tls';
            // Informações específicadas pelo Google
            $mail->Host = EMAIL_SMTP;
            $mail->Port = EMAIL_PORT;
            // Define o remetente
            $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME_ERRO);
            // Define o destinatário
            $mail->addAddress($email, $nome);

            // Conteúdo da mensagem
            $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
            $mail->Subject = 'Problema no sistema';
            $mail->Body    = '<p>Vish <b>' . $nome . '!</b></p><p>' . $erro . '</p>';
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