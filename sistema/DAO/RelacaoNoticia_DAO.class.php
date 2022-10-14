<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade RelacaoNoticia, acessa todas as operações de banco de dados referentes ao Model RelacaoNoticia que está em Libs
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
class RelacaoNoticia_DAO extends Generic_DAO {

    public $chave = 'id_relacao';
    public $tabela = 'tb_relacao_noticia';

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

    public function Verifica_Relacao($id_noticia, $id_noticia_relacionado) {

        $sql = "SELECT id_relacao FROM tb_relacao_noticia WHERE status_relacao = 'A' AND id_noticia=$id_noticia AND id_noticia_relacionado=$id_noticia_relacionado";

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        return ($row[0][0] != NULL) ? TRUE : FALSE;
    }

}

?>
