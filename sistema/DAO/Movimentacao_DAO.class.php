<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade CategoriaGaleria, 
 * acessa todas as operações de banco de dados referentes ao Model CategoriaGaleria
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 13/10/2009
 * @Ultima_Modif 13/10/2009 por Marcela Santana
 *
 * @package DAO
 *
 */
class Movimentacao_DAO extends Generic_DAO {

    public $chave = 'id_movimentacao';
    public $tabela = 'tb_movimentacao';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {        
        $desc = Array();
        $desc['tipo_movimentacao'] = parent::get_Descricoes('tb_tipo_movimentacao', 0, 1, "ORDER BY descricao ASC");
        
        $desc['centro'] = parent::get_Descricoes('tb_centro');
        return $desc;
    }

}
