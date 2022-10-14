<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$dados['sucesso'] = 0;

// Validação dos dados antes de preencher o email ------------------------------
if ($post_request['nome'] == '' && $post_request['telefone'] == '' && $post_request['email'] == '') {
    $dados['sucesso'] = 0;
    $dados['texto'] = utf8_encode('Preencha o formulário corretamente.');
    echo json_encode($dados);
    exit;
}

$config = new Config();
$email = $config->get_email();
$cliente = $config->get_cliente();
$dominio = $config->get_dominio();

$ctr_associado = new Associado_Control($post_request);


$total = $ctr_associado->Verifica_Cpf($post_request['cpf_form']);


if ($total > 0) {
    $dados['sucesso'] = 2;
} else {


    $ctr_associado->Associado_Solicita_Inclusao($post_request);


    /* CONFIGURA LISTA DE EMAIL PARA DESTINATÁRIO */
    $lista = array();
    $lista[0] = $email;
    $lista[1] = "felipe@equipedigital.com";


    /* CONFIGURA VARIÁVEIS RECEBIDA DO FROMULÁRIO VIA POST */


    /* CONFIGURA O ASSUNTO DO E-MAIL */
    $assunto = 'Nova solicitação de afiliado';


    /* CONFIGURA HTML DO CORPO DO E-MAIL */
    $msg = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>
    <body>
        <table width="700" border="0" bordercolor="#585858" align="center" cellpadding="7" cellspacing="1">            
            <tr>
                <td>
                Olá, o site possui uma nova solicitação de afiliado. Entre no sistema para avaliar! (' . $post_request['nome'] . ')
                </td>
            </tr>            
        </table>
    </body>
</html>
    ';


    //----------------------------- PHPMAILER --------------------------------------
    $obj_mail = new Email();

    if ($obj_mail->send_mail($cliente, $lista, $assunto, $msg, $email)) {
        $dados['sucesso'] = 1;
    } else {
        $dados['sucesso'] = 0;
    }
    //----------------------------- PHPMAILER --------------------------------------
}

echo json_encode($dados);
