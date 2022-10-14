<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Grava logs de operação do sistema
 * 
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 21/09/2009
 * @Ultima_Modif 21/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package Libs
 *
 */
class Log {

    private $conexao;

    /**
     * Carrega a conexão com o banco de dados.
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       $config        = new Config();
     *       $factory       = $config->get_banco();
     *       $banco         = new $factory();
     *       $this->conexao = $banco->getInstance();
     *   }
     *
     * </code>
     *
     */
    public function __construct() {
        // pega conexao
        $config = new Config();
        $factory = $config->get_banco();
        $banco = new $factory();
        $this->conexao = $banco->getInstance();
    }

    /**
     *
     * Grava logs de operação do sistema.
     *
     * @author Ricardo Ribeiro Assink
     * @param int $log ID do log de operação
     * @param String $id_sessao ID da sessão encriptado
     * @param int $quem ID do registro modificado
     * @return void
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Log.class.php");
     *
     *  $objeto = new Log();
     *  $objeto->gravaLog(1,"u71_WsOieyVSh18AAqILeQ4dS1-asXaTPE5lf5sTrvU=",2);
     *
     * ?>
     * </code>
     *
     */
    public function gravaLog($log, $id_sessao, $quem) {

        $dat = new Data();
        $data_atual = $dat->get_dataFormat("NOW", "", "BD");

        $sess = new Sessao();
        $sess->loadSessao($id_sessao);
        $id_sess = $sess->get_id_sessao();
        $id_usuario = $sess->get_id_usuario();

        $sql_log = "INSERT into tb_log_operacao values($log,$id_usuario,\"$data_atual\",$quem,$id_sess)";
        //echo $sql_log;
        $result = $this->conexao->consulta("$sql_log");
    }

}

// TESTES
/*
  $objeto = new Log();
  $objeto->gravaLog(1, "u71_WsOieyVSh18AAqILeQ4dS1-asXaTPE5lf5sTrvU=", 2);
 */
?>
