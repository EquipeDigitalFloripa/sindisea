<?php

$id_sessao = trim($_REQUEST['id_sessao']);

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * LOGOUT
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
$config = new Config();
$factory = $config->get_banco();
$banco = new $factory();
$conexao = $banco->getInstance();

$enc = new Encripta();
$sesss = $enc->md5_decrypt($id_sessao);
$dat = new Data();
$data_atual = $dat->get_dataFormat("NOW", "", "BD");
$sql = "update tb_sessao set status_sessao = 'F',data_out = \"$data_atual\" where id_sessao = $sesss";
$result = $conexao->consulta("$sql");

header("Location: index.php");
?>
