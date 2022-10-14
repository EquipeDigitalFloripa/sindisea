<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Gera Instância do banco de dados MySQL usando SINGLETON
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2029, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 20/08/2019 por Ricardo Ribeiro Assink
 *
 *
 * @package BD
 *
 */
class Mysql {

    private static $instance = null;
    private $con = null;

    /**
     *
     * Usar o SINGLETON para manter apenas uma instância do banco de dados ativa durante a execução 
     *
     * @author Ricardo Ribeiro Assink
     * @return Instância do Objeto
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *
     *  Mysql::getInstance();
     *
     * ?>
     * </code>
     *
     */
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Impedir a clonagem da classe 
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * Impedir o wakeup 
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    /**
     * Efetua a conexão com o MySQL.
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     * @Exemplo
     * <code>
     *
     *   private function __construct() {
     *
     *       $config    = new Config();
     *       $this->con = mysql_connect($config->get_Mysql_host() , $config->get_Mysql_user(), $config->get_Mysql_pass())
     *       or die ("Could not connect to db: " . mysql_error());
     *
     *       mysql_select_db($config->get_Mysql_db(), $this->con)
     *       or die ("Could not select db: " . mysql_error());
     *
     *   }
     *
     * </code>
     *
     */
    private function __construct() {

        $config = new Config();
        $this->con = mysqli_connect($config->get_Mysql_host(), $config->get_Mysql_user(), $config->get_Mysql_pass()) or die("Could not connect to db: " . mysqli_error());

        mysqli_select_db($this->con, $config->get_Mysql_db()) or die("Could not select db: " . mysqli_error());
        mysqli_set_charset($this->con, 'latin1');
    }

    // depois usar o DAObase.php do diretorio producao para incrementar a forma do query
    // dessa forma resolve e a aplicação fica independente de BANCO.
    // pois é só usar abstract factory para gatilhar.

    /**
     *
     * Executar a instrução passada no parâmetro <br>
     *
     * @author Ricardo Ribeiro Assink
     * @param String $query Instrução para o banco de dados
     * @return result Resultado da execução da instrução de banco de dados
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *  $result = $objeto->consulta("SELECT nome_usuario FROM tb_usuario");
     *
     * ?>
     * </code>
     *
     */
    public function consulta($query) {
        $result = mysqli_query($this->con, "$query");

        return (@mysqli_num_rows($result) > 0) ? $result : NULL;
    }

    /**
     *
     * Transformar o result vindo do banco de dados em um Array com as chaves com o nome de cada campo respectivo
     *
     * @author Ricardo Ribeiro Assink
     * @param result $result Resultado da query
     * @return Array Array com as chaves com o nome de cada campo respectivo
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *  $array = Array();
     *  $array = objeto->criaArray($result);
     *
     *  // exemplo
     *  echo $array["id_usuario"];
     *  echo "<br>";
     *  echo $array["nome_usuario"];
     *
     * // imprime:  2 <br> Ricardo
     *
     *
     * ?>
     * </code>
     *
     */
    public function criaArray($result, $numass = MYSQLI_BOTH) {
        $got = array();
        if (@mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, $numass)) {
                array_push($got, $row);
            }
            return $got;
        }
    }

    /**
     *
     * Transformar o result vindo do banco de dados em um Array Simples
     *
     * @author Ricardo Ribeiro Assink
     * @param result $result Resultado da query
     * @return Array Array simples
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *  $array = Array();
     *  $array = objeto->criaArray($result);
     *
     *  // exemplo
     *  echo $array[0];
     *  echo "<br>";
     *  echo $array[1];
     *
     * // imprime:  111 <br> 222
     *
     *
     * ?>
     * </code>
     *
     */
    public function criaArrayOnce($result, $numass = MYSQLI_BOTH) {
        $got = array();
        if (@mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, $numass)) {
                array_push($got, $row[0]);
            }
            return $got;
        }
    }
    
    
    
    public function criaArrayOnceSameKey($result, $numass = MYSQLI_BOTH) {
        $got = array();
        if (@mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, $numass)) {
                $got[$row[0]] = $row[0];
            }
            return $got;
        }
    }    

    public function __destruct() {
        mysqli_close($this->con);
    }

}

?>
