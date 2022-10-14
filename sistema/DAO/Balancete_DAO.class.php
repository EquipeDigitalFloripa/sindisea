<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Balancete, acessa todas as operações de banco de dados referentes ao Model Balancete que está em Libs
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
class Balancete_DAO extends Generic_DAO {

    public $chave = 'id_balancete';
    public $tabela = 'tb_balancete';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }
    
    public function get_max_id()
    {
        $sql = "SELECT MAX($this->chave) FROM $this->tabela";

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        return $row[0][0];
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


        return $desc;
    }

}

?>
