<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Contato, acessa todas as operações de banco de dados referentes ao Model Contato
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2017-2020, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 04/07/2017
 * @package DAO
 */
class Contato_DAO extends Generic_DAO {

    public $chave = 'id_contato';
    public $tabela = 'tb_contato';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {
        
    }

    public function get_Dados($sql) {

        $dados = Array();

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        $i = 0;
        while ($i < count($row)) {

            $dados[$i]['qtde'] = $row[$i]['qtde'];
            $dados[$i]['var'] = $row[$i]['var'];

            $i++;
        }
        return $dados;
    }

    public function get_Array_Filtro() {

        $dados = array();

        /* MONTA ARRAY POR ANO */
        $sql = "SELECT DATE_FORMAT(data_contato, '%Y') AS ano
                FROM tb_contato
                GROUP BY ano        
                ORDER BY ano ASC";

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($row)) {
            $dados['ano'][$row[$i]['ano']] = $row[$i]['ano'];
            $i++;
        }

        /* MONTA ARRAY POR ASSUNTO */
        $sql = "SELECT assunto
                FROM tb_contato
                GROUP BY assunto        
                ORDER BY assunto ASC";

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($row)) {
            $dados['assunto'][$row[$i]['assunto']] = $row[$i]['assunto'];
            $i++;
        }

        /* MONTA ARRAY POR ONDE CONHECEU */
        $sql = "SELECT onde_conheceu
                FROM tb_contato
                GROUP BY onde_conheceu
                ORDER BY onde_conheceu ASC";

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($row)) {
            $dados['onde_conheceu'][$row[$i]['onde_conheceu']] = $row[$i]['onde_conheceu'];
            $i++;
        }



        return $dados;
    }

}

?>
