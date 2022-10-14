<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Slider, 
 * acessa todas as operações de banco de dados referentes ao Model Slider
 *
 * @author Marcio Figueredo
 * @copyright Copyright (c) 2015, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/04/2015
 * 
 * @package DAO
 *
 */
class Slider_DAO extends Generic_DAO {

    public $chave = 'id_slider';
    public $tabela = 'tb_slider';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {

        $desc = array();

        return $desc;
    }

}
