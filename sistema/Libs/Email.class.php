<?php

class Email
{

    private $remetente;
    private $assinatura;

    public function __construct()
    {

        $config = new Config();
        $this->remetente = $config->get_email();
        $this->assinatura = $config->get_assinatura_mailing();
    }

    public function get_assinatura()
    {
        return $this->assinatura;
    }

    public function set_assinatura($assinatura)
    {
        $this->assinatura = $assinatura;
    }

    public function get_remetente()
    {
        return $this->remetente;
    }

    public function set_remetente($remetente)
    {
        $this->remetente = $remetente;
    }

    public function send($assunto, $texto, $lista)
    {
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= "From: $this->remetente\n";
        $headers .= "Return-Path: $this->remetente\n";
        $i = 0;
        $msg = "<html>
                      <body>

					     $texto
                                             <br/>
                         $this->assinatura
                      </body>
                </html>
        ";

        foreach ($lista as $email) {
            if (mail($email, "$assunto", $msg, "$headers")) {
                $i++;
            }
        }
        return $i;
    }

    /**
     * Envia e-mail utilizando a classe PHPMailer (Desing Pattern Adapter)
     *
     * @param String $cliente Nome do Cliente
     * @param Array $lista Define os destinatários
     * @param String $assunto Assunto do E-mail
     * @param String $texto Texto em formato HTML da mensagem
     * @param String $replyto Email de resposta.
     * @param Array $anexo Anexos da mensagem. (opcional)
     * @return boolean
     */
    public function send_mail($cliente, $lista, $assunto, $texto, $replyto, $anexo = NULL)
    {

        require_once 'phpmailer/PHPMailerAutoload.php';

        $config = new Config();

        $mail = new PHPMailer();
        $mail->SMTPDebug = false;

        $mail->setLanguage('pt');

        /* Define os dados do servidor e tipo de conexão */
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = $config->get_email_host();
        $mail->Username = $config->get_email_username();
        $mail->Password = $config->get_email_password();
        $mail->Port = $config->get_email_port();
        $mail->SMTPSecure = $config->get_email_secure();

        /* Define o remetente */
        $mail->Sender = $config->get_email_username();
        $mail->From = $config->get_email_username();
        $mail->FromName = $cliente;

        /* Define o reply-to */
        if ($replyto) {
            $mail->AddReplyTo($replyto, "");
        }

        /* Define o(s) destinatário(s) */
        foreach ($lista as $email) {
            $mail->AddAddress("$email", "$cliente");
        }

        /* Define os dados técnicos da Mensagem */
        $mail->IsHTML(true);
        $mail->CharSet = 'iso-8859-1';

        /* Define a mensagem (Texto e Assunto) */
        $mail->Subject = "$assunto";
        $mail->Body = $texto;
        $mail->AltBody = "";

        /* Define o(s) anexo(s) */
        if (is_array($anexo)) {
            if (count($anexo) > 0) {
                for ($i = 0; $i < count($anexo); $i++) {
                    $arquivo = $anexo[$i]['arquivo'];
                    $nome = $anexo[$i]['nome'];
                    $mail->AddAttachment($arquivo, $nome);
                }
            }
        }

        /* Envia o e-mail */
        $enviar = $mail->Send();

        /* Limpa os destinatários e os anexos */
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();

        /* Exibe uma mensagem de resultado */

        if ($enviar) {
            return TRUE;
        } else {
            return $mail->ErrorInfo;
            return FALSE;
        }
    }
}

/*
  $ob = new Email();
  $destino = Array();
  $destino[0] = 'marcela@equipedigital.com';
  $ob->send('uygckjsdhch0', "sdjkhfksdhflkdhflkhdlkghdlkghelkhflekh", $destino);
 */
