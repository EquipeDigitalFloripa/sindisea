<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Tags, acessa todas as operações de banco de dados referentes ao Model Tags que está em Libs
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 06/07/2016
 * @package DAO
 *
 */
class Tags_DAO extends Generic_DAO {

    public $chave = 'id_tag';
    public $tabela = 'tb_tags';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    /**
     * Retorna a descrição de uma tabela, campo retornado deve ser informado
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return Array Array com as descrições de campos
     */
    public function get_Descricao() {

        $desc = Array();

//        $desc['nome_entregador'] = parent::get_Descricoes('tb_entregador');
//        return $desc;
    }

    /**
     * Verifica se já exite Tag retorna TRUE ou FALSE
     *
     * @author Marcio Figueredo
     * @return boolean
     */
    public function tag_Existe($desc_tag) {

        $sql = "SELECT id_tag FROM tb_tags WHERE desc_tag = '$desc_tag' AND status_tag = 'A'";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        
        if($row[0][0] > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
   
    
        public function loadObjeto_Id($desc_tag) {

        $sql = "SELECT id_tag FROM tb_tags WHERE desc_tag = '$desc_tag' AND status_tag = 'A'";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        
        if($row[0][0] > 0){
            return $row;
        }else{
            return FALSE;
        }
    }

}

?>
