<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$dados['sucesso'] = 0;


// Validação dos dados antes de preencher o email ------------------------------
if ($post_request['nome'] == '' && $post_request['telefone'] == '' && $post_request['email'] == '' && $post_request['mensagem'] == '') {
    $dados['sucesso'] = 0;
    $dados['texto'] = utf8_encode('Preencha o formulário corretamente.');
    echo json_encode($dados);
    exit;
}

$config = new Config();
$email = $config->get_email();
$cliente = $config->get_cliente();
$dominio = $config->get_dominio();


/* CONFIGURA LISTA DE EMAIL PARA DESTINATÁRIO */
$lista = array();
$lista[0] = $email;
$lista[1] = "felipe@equipedigital.com";

/* CONFIGURA VARIÁVEIS RECEBIDA DO FROMULÁRIO VIA POST */


$form_nome = utf8_decode($post_request['nome']);
$form_email = $post_request['email'];
$form_telefone = $post_request['telefone'];
$form_mensagem = utf8_decode($post_request['mensagem']);

/* CONFIGURA O ASSUNTO DO E-MAIL */
$assunto = 'Contato Site - ' . $form_nome;


/* CONFIGURA HTML DO CORPO DO E-MAIL */
$mesg = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>
    <body>
        <table width="700" border="0" bordercolor="#585858" align="center" cellpadding="7" cellspacing="1">            
            <tr>
                <td>
                    <br/><br/>
                    <font color="#585858">Olá, você recebeu uma mensagem de contato através do Site ' . $cliente . '</font>
                    
                    <br/>
                    <br/>
                    <font color="#585858"><strong>Nome: </strong> ' . $form_nome . '</font><br/>
                    <font color="#585858"><strong>E-mail: </strong> ' . $form_email . '</font><br/>
                    <font color="#585858"><strong>Telefone: </strong> ' . $form_telefone . '</font><br/>
                    <br/>
                    <br/>
                    <font color="#585858"><strong>Mensagem: </strong> ' . $form_mensagem . '</font><br/><br/>
                    <br/><br/>
                </td>
            </tr>            
        </table>
    </body>
</html>
    ';


/**
 * CADASTRA NOVO CONTATO
 */
$detect = new Mobile_Detect();
$dispositivo = ($detect->isMobile() && !$detect->isTablet()) ? 'Mobile' : 'Desktop';

$ctr_contato = new Contato_Control($post_request);
$ctr_contato->Contato_Add($dispositivo);

//----------------------------- PHPMAILER --------------------------------------
$obj_mail = new Email();
if ($obj_mail->send_mail($cliente, $lista, $assunto, $mesg, $form_email)) {

    $dados['sucesso'] = 1;
    $dados['texto'] = utf8_encode('Sua mensagem foi enviada com sucesso.');
} else {
    $dados['sucesso'] = 0;
    $dados['texto'] = utf8_encode('Ocorreu um erro no envio do e-mail, tente novamente mais tarde.');
}
//----------------------------- PHPMAILER --------------------------------------

echo json_encode($dados);
