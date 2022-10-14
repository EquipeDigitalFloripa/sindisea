<?php

/**
 * Gerencia a descrição da língua dependendo idioma que é solicitado
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
     * Carrega as descrições
     *
     * @author Ricardo Ribeiro Assink
     * @param String $idioma Idioma das descrições
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
     *           $this->set_desc_lingua_pt("Português");
     *           $this->set_desc_lingua_en("Inglês");
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

            $this->set_desc_lingua_pt("Português");
            $this->set_desc_lingua_en("Inglês");
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
     * Retorna a descrição da língua segundo um idioma passado, é necessário carregar o idioma na instanciação.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $idioma Idioma
     * @return String Descrição da língua
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Lingua.class.php");
     *
     *  $objeto = new Lingua("PT");
     *  echo $objeto->get_desc_lingua("PT"); // imprime: Português
     *  echo $objeto->get_desc_lingua("EN"); // imprime: Inglês
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
  echo $objeto->get_desc_lingua("PT"); // imprime: Português
  echo "\n";
  echo $objeto->get_desc_lingua("EN"); // imprime: Inglês

  echo "\n";echo "\n";

  $objeto = new Lingua("EN");
  echo $objeto->get_desc_lingua("PT"); // imprime: Portuguese
  echo "\n";
  echo $objeto->get_desc_lingua("EN"); // imprime: English

 */
?>