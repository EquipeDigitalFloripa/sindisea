<?php

    $prefixo_gear     = trim($_REQUEST["prefixo_gear"]);
    $sufixo_gear      = trim($_REQUEST["sufixo_gear"]);
    $tabela_gear      = trim($_REQUEST["tabela_gear"]);
    
    require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

    /**
     * AJAX_GEAR
     *
     * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
     * @copyright Copyright (c) 2019-2029, EquipeDigital.com
     * @link http://www.equipedigital.com
     * @license Comercial
     *
     * @Data_Criacao 20/08/2019
     * @Ultima_Modif 20/08/2019 por Ricardo Ribeiro Assink
     *
     *
     * @package sys
     *
     */

    $config        = new Config();
    $factory       = $config->get_banco();
    $banco         = new $factory();
    $conexao       = $banco->getInstance();



        $sql        = "DESCRIBE $tabela_gear";
        $result     = $conexao->consulta("$sql");
        $row        = $conexao->criaArrayOnce($result);
        
        foreach ($row as $value) {
          echo $prefixo_gear.$value.$sufixo_gear."\n";
        }
        
        
?>
