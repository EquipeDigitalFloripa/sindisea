<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Aviso, acessa todas as operações de banco de dados referentes ao Model Aviso que está em Libs
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2019-2022, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package DAO
 */
class EnvioSMS_DAO extends Generic_DAO {

    public $chave = 'id_envio';
    public $tabela = 'tb_envio_sms';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {

        $desc = Array();
        
        $desc['desc_grupo_sms'] = parent::get_Descricoes('tb_grupo_sms');

        return $desc;
    }

    public function get_Contatos_Grupo($id_grupo_sms) {
        $sql = 'SELECT * FROM tb_contato_sms WHERE status_contato = "A" AND id_grupo_sms = ' . $id_grupo_sms . '';
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        return $row;
    }

    public function get_Regiao($nome_regiao){
        $sql = 'SELECT id_regiao FROM tb_regiao WHERE status_regiao = "A" AND desc_regiao = "'.$nome_regiao.'" GROUP BY desc_regiao LIMIT 1';
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        return $row[0]['id_regiao'];
    }

    public function get_Contatos_Regiao($id_regiao) {
        $sql = 'SELECT * FROM tb_cadastro_sms WHERE status_cadastro = "A" AND id_regiao = ' . $id_regiao . '';
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        return $row;
    }

}

?>