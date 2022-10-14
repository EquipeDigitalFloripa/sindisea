<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Controlador PAI
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
 * @package Control
 *
 */
class Control {

    /**
     * @var Objeto Objeto da classe Data
     * @see Data
     */
    protected $data;

    /**
     * @var Objeto Objeto da classe Sessão
     * @see Sessao
     */
    protected $sessao;

    /**
     * @var Objeto Objeto da classe Log
     * @see Log
     */
    protected $log;

    /**
     * @var Array Array com o merge de _POST e _REQUEST
     */
    protected $post_request;

    /**
     * @var Objeto Objeto da classe Traducao
     */
    protected $traducao;

    /**
     * @var Objeto Objeto da classe Imagem
     */
    protected $image;
    protected $config;
    protected $string_helper;
    

    /**
     * Carrega outros objetos de manipulação
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       $config         = new Config();
     *       $factory        = $config->get_banco();
     *       $banco          = new $factory();
     *       $this->conexao  = $banco->getInstance();
     *
     *       $this->data     = new Data();
     *       $this->sessao   = new Sessao();
     *       $this->log      = new Log();
     *       $this->traducao = new Traducao();
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        $this->data = new Data();
        $this->sessao = new Sessao();
        $this->log = new Log();
        $this->traducao = new Traducao();
        $this->image = new Imagem();
        $this->config = new Config();
        $this->string_helper = new String_Helper();
        $this->post_request = $post_request;
    }

    public function __destruct() {
        
    }

    /**
     *
     * Cria um conjunto de execução para explodir um Array tornando a chave no nome da variavel. 
     * 
     * @author Ricardo Ribeiro Assink 
     * @param Array $array Array contendo dados 
     * @return String Sequencia de comandos do tipo $nome_da_chave = $valor; 
     * @Exemplo 
     * <code> 
     * 
     * <?php 
     * 
     * $array = Array('nome' => 'Ricardo', 'ID' => '22');
     * $exec  = parent::explodeArray($array);
     * eval($exec);
     * 
     * // executa: $nome = 'Ricardo'; $ID = '22'; 
     * 
     * ?> 
     * </code> 
     * 
     */
    public function explodeArray($array) {

        foreach ($array as $chave => $valor) {
            $exec .= "$" . $chave . " = \"" . $valor . "\";";
        }
        return $exec;
    }

    /**
     *
     * Redireciona página para a URL passada como parâmetro.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $url URL de destino
     * @return void
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * parent::redirect("../index.php");
     * 
     * ?>
     * </code>
     *
     */
    public function redirect($url) {

        echo "<script type='text/javascript'>location.href='" . $url . "'; </script>";
    }

    /**
     *
     * Formata String para transporte por URL.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $msg Mensagem que deve ser formatada.
     * @return String Mensagem formatada.
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * $msg = parent::preparaTransporte("Cliente cadastrado com sucesso.");
     * 
     * ?>
     * </code>
     *
     */
    public function preparaTransporte($msg) {
        return rawurlencode(base64_encode($msg));
    }

    /**
     * @return Objeto Objeto da classe Data.
     */
    public function get_data() {
        return $this->data;
    }

    /*
      public function set_data($data) {
      $this->data = $data;
      }
     */

    /**
     * @return Objeto Objeto da classe Sessao.
     */
    public function get_sessao() {
        return $this->sessao;
    }

    /*
      public function set_sessao($sessao) {
      $this->sessao = $sessao;
      }
     */

    /**
     * @return Objeto Objeto da classe Log.
     */
    public function get_log() {
        return $this->log;
    }

    /*
      public function set_log($log) {
      $this->log = $log;
      }
     */

    public function get_post_request() {
        return $this->post_request;
    }

    public function set_post_request($post_request) {
        $this->post_request = $post_request;
    }

    public function get_config() {
        return $this->config;
    }

    public function set_config($config) {
        $this->config = $config;
    }

}

// TESTE
/*
  class Teste extends Control {

  public function __construct() {
  parent::__construct();


  echo $this->data->get_dataFormat("NOW","","PADRAO");

  }

  }// fim da classe

  $objeto = new Teste();

 */
?>
