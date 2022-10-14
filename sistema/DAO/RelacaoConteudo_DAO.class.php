<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade RelacaoConteudo, acessa todas as operações de banco de dados referentes ao Model RelacaoConteudo que está em Libs
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
class RelacaoConteudo_DAO extends Generic_DAO {

    public $chave = 'id_rel_conteudo';
    public $tabela = 'tb_relacao_conteudo';

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

    public function Existe_Relacao($id_noticia, $id_conteudo) {

        $sql = 'SELECT id_rel_conteudo FROM tb_relacao_conteudo WHERE (id_noticia = ' . $id_noticia . ' AND id_conteudo=' . $id_conteudo . ')';

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        return ($row[0][0] != NULL) ? TRUE : FALSE;
    }

    public function list_Pages() {
        $dados = array();

        $sql = "SELECT id_conteudo,nome_link FROM tb_conteudo WHERE status_conteudo = 'A' AND id_conteudo != 1 AND id_conteudo != 11";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        $i = 0;
        while ($i < count($row)) {
            $dados[$i]['id_conteudo'] = $row[$i]['id_conteudo'];
            $dados[$i]['nome_link'] = $row[$i]['nome_link'];
            $i++;
        }

        return $dados;
    }

    public function ger_Page($id_conteudo) {
        
        $sql = "SELECT nome_link FROM tb_conteudo WHERE status_conteudo = 'A' AND id_conteudo = $id_conteudo";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        
        return $row[0][0];
    }

}

?>
