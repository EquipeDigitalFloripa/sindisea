<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$dados = NULL;

$ctr_associado = new Associado_Control($post_request);
if(isset($post_request['tela']) && $post_request['tela'] == 'login'){
    $retorno_login = $ctr_associado->Associado_Login($post_request['cpf_form'], $post_request['senha_form']);
}else {
    $retorno_login = $ctr_associado->Associado_Login($post_request['cpf'], $post_request['senha']);
}

if (isset($retorno_login['id_associado']) && $retorno_login['id_associado'] != NULL) {
    $dados['sucesso'] = 1;
    $dados['id_associado'] = $retorno_login['id_associado'];
    $_SESSION['id_associado'] = $retorno_login['id_associado'];
} else {
    $dados['sucesso'] = 0;
    $dados['msg'] = utf8_encode('CPF ou senha incorretos.');
}

echo json_encode($dados);
