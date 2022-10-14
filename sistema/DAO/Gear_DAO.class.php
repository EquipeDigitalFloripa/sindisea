<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Gear, acessa todas as operações de banco de dados referentes ao Model Gear que está em Libs
 *
 * @author Ricardo Ribeiro Assink<ricardo@equipedigital.com>
 * @copyright Copyright (c) 2019-2022, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package DAO
 */
class Gear_DAO extends Generic_DAO {

    public $chave = 'id_noticia';
    public $tabela = 'tb_noticia';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {

        $desc = Array();
//        $desc['desc_tabelas'] = parent::get_Descricoes('tb_categoria_noticia');
        
        
        
        //Cria um array ($tables) com todas as tabelas presentes no banco de dados
        $sql = "SHOW TABLES";
        $result = $this->conexao->consulta("$sql");

        $desc['desc_tabelas'] = $this->conexao->criaArrayOnceSameKey($result); 

        return $desc;
    }



}

?>
