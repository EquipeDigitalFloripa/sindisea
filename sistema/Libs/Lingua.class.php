<?php

/**
 * Gerencia a descri��o da l�ngua dependendo idioma que � solicitado
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
 * @package Libs
 *
 */
class Lingua {

    private $desc_lingua_en;
    private $desc_lingua_pt;

    /**
     *
     * Carrega as descri��es
     *
     * @author Ricardo Ribeiro Assink
     * @param String $idioma Idioma das descri��es
     * @return void
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *    public function __construct($idioma) {
     *
     *       if($idioma == "" or $idioma == "PT"){
     *
     *           $this->set_desc_lingua_pt("Portugu�s");
     *           $this->set_desc_lingua_en("Ingl�s");
     *
     *       }else{
     *           $this->set_desc_lingua_pt("Portuguese");
     *           $this->set_desc_lingua_en("English");
     *
     *       }
     *
     *   }
     *
     * ?>
     * </code>
     *
     */
    public function __construct($idioma) {

        if ($idioma == "" or $idioma == "PT") {

            $this->set_desc_lingua_pt("Portugu�s");
            $this->set_desc_lingua_en("Ingl�s");
        } else {
            $this->set_desc_lingua_pt("Portuguese");
            $this->set_desc_lingua_en("English");
        }
    }

    /**
     * @ignore
     */
    public function set_desc_lingua_pt($newVal) {
        $this->desc_lingua_pt = $newVal;
    }

    /**
     * @ignore
     */
    public function get_desc_lingua_pt() {
        return $this->desc_lingua_pt;
    }

    /**
     * @ignore
     */
    public function set_desc_lingua_en($newVal) {
        $this->desc_lingua_en = $newVal;
    }

    /**
     * @ignore
     */
    public function get_desc_lingua_en() {
        return $this->desc_lingua_en;
    }

    /**
     *
     * Retorna a descri��o da l�ngua segundo um idioma passado, � necess�rio carregar o idioma na instancia��o.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $idioma Idioma
     * @return String Descri��o da l�ngua
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Lingua.class.php");
     *
     *  $objeto = new Lingua("PT");
     *  echo $objeto->get_desc_lingua("PT"); // imprime: Portugu�s
     *  echo $objeto->get_desc_lingua("EN"); // imprime: Ingl�s
     *
     *
     *  $objeto = new Lingua("EN");
     *  echo $objeto->get_desc_lingua("PT"); // imprime: Portuguese
     *  echo $objeto->get_desc_lingua("EN"); // imprime: English
     *
     * ?>
     * </code>
     *
     */
    public function get_desc_lingua($lingua) {
        if ($lingua == "PT" or $lingua == "") {
            return $this->desc_lingua_pt;
        } else {
            return $this->desc_lingua_en;
        }
    }

}

// final da classe
// TESTES
/*
  $objeto = new Lingua("PT");
  echo $objeto->get_desc_lingua("PT"); // imprime: Portugu�s
  echo "\n";
  echo $objeto->get_desc_lingua("EN"); // imprime: Ingl�s

  echo "\n";echo "\n";

  $objeto = new Lingua("EN");
  echo $objeto->get_desc_lingua("PT"); // imprime: Portuguese
  echo "\n";
  echo $objeto->get_desc_lingua("EN"); // imprime: English

 */
?>