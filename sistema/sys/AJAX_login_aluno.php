<?php

$texto = strtolower(trim($_REQUEST["login"]));
$id_membro = trim($_REQUEST["id_membro"]);

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * AJAX_LOGIN_EDIT
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


if ($texto != "" and strlen($texto) > 2) {
    $sql = "select id_aluno from tb_aluno where login_aluno = \"$texto\"";
    $result = $conexao->consulta("$sql");
    $row = $conexao->criaArray($result);
    if (count($row) > 0){
        $confere = $row[0][0];
    }else{
        $confere = NULL;
    }

    if ($confere == $id_membro or $confere == "") { // se o id retornado for igual ao meu id
        $contador = 0;
    } else {  // se o id retornado for diferente ou nulo
        $contador = 1;
    }
} else {

    $contador = 1;
}


if ($contador > 0) {
    echo true;
} else {
    echo false;
}
?>
