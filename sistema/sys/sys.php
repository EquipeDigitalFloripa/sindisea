<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DISPATCHER
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package sys
 *
 */
$post_request = array_merge($_POST, $_REQUEST, $_FILES);
$id_sessao = $post_request['id_sessao'];
$co = base64_decode($post_request['co']);
$ac = base64_decode($post_request['ac']);

$objeto = new $co($post_request);
$sessao = $objeto->get_sessao();

if (!$sessao->verificaSessao("$id_sessao")) {
    $msg = $objeto->preparaTransporte("Erro no carregamento de sessão");
    $objeto->redirect("index.php?msg_tp=erro&msg=$msg");
}

//echo $co . "&nbsp>&nbsp" . $ac . "<br>\n";


call_user_func(Array($objeto, $ac), $post_request);
?>
