<?php
require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");;

/**
 * DAO da entidade Mailing, acessa todas as operações de banco de dados referentes ao Model Mailing
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 13/10/2009
 * @Ultima_Modif 13/10/2009 por Marcela Santana
 *
 *
 * @package DAO
 *
 */
class VotoEleicao_DAO extends Generic_DAO {

    public $chave = 'id_voto_eleicao';
    public $tabela = 'tb_voto_eleicao';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }
    public function get_Descricao(){

        $desc = Array();
        return $desc;

    }

}
?>
