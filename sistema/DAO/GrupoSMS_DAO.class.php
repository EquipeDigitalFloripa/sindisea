<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade GrupoSMS, acessa todas as operações de banco de dados referentes ao Model GrupoSMS que está em Libs
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2019-2022, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package DAO
 */
class GrupoSMS_DAO extends Generic_DAO {

    public $chave = 'id_grupo_sms';
    public $tabela = 'tb_grupo_sms';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {

        $desc = Array();

        //$desc['desc_grupo_sms'] = parent::get_Descricoes('tb_grupo_sms');

        return $desc;
    }


}

?>