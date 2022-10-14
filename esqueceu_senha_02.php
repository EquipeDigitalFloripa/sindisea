<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$dados['sucesso'] = 0;

// Validação dos dados antes de preencher o email ------------------------------
if ($post_request['cpf_form'] == '') {
    $dados['sucesso'] = 0;
    $dados['texto'] = utf8_encode('Preencha o formulário corretamente.');
    echo json_encode($dados);
    exit;
}

$config = new Config();
$cliente = $config->get_cliente();
$dominio = $config->get_dominio();


$ctr_associado = new Associado_Control($post_request);


$total = $ctr_associado->Verifica_Cpf($post_request['cpf_form']);

if ($total == 0) {
    $dados['sucesso'] = 0;
} else {

    $associado = $ctr_associado->Pega_Associado_Condicao(" AND status_associado='A' AND cpf = '" . $post_request['cpf_form'] . "'");

    if ($associado['email_pessoal'] != "") {
        $email = $associado['email_pessoal'];
    } else {
        if ($associado['email_trabalho'] != "") {
            $email = $associado['email_trabalho'];
        } else {
            $dados['sucesso'] = 0;
            $dados['texto'] = utf8_encode('Ocorreu um erro, por favor entre em contato com o administrador.');
            echo json_encode($dados);
            exit;
        }
    }

    $token = $ctr_associado->Associado_Esqueceu_Senha($associado['id_associado']);


    /* CONFIGURA LISTA DE EMAIL PARA DESTINATÁRIO */
    $lista = array();
    $lista[0] = $email;

    /* CONFIGURA VARIÁVEIS RECEBIDA DO FROMULÁRIO VIA POST */


    /* CONFIGURA O ASSUNTO DO E-MAIL */
    $assunto = 'Redefinição de senha SINDIASEA';


    /* CONFIGURA HTML DO CORPO DO E-MAIL */
    $mesg = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>
    <body>
        <table width="700" border="0" bordercolor="#585858" align="center" cellpadding="7" cellspacing="1">            
            <tr>
                <td>
                Olá, para redefinir a sua senha, acesse o endereço: <a href="' . $dominio . '/redefinir-senha?token=' . $token . '">' . $dominio . '/redefinir-senha?token=' . $token . '</a>
                </td>
            </tr>            
        </table>
    </body>
</html>
    ';


//----------------------------- PHPMAILER --------------------------------------
    $obj_mail = new Email();
    if ($obj_mail->send_mail($cliente, $lista, $assunto, $mesg, $email)) {
        $dados['sucesso'] = 1;
    } else {
        $dados['sucesso'] = 0;
    }
//----------------------------- PHPMAILER --------------------------------------
}

echo json_encode($dados);
