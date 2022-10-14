<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Noticia, acessa todas as operações de banco de dados referentes ao Model Noticia
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
class Arquivo_DAO extends Generic_DAO {

    public $chave = 'id_arquivo';
    public $tabela = 'tb_arquivo';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {

        $desc = Array();
        $sql = "SELECT id_categoria,nome_categoria from tb_categoria_arquivo where status_categoria = \"A\"";
        $result = $this->conexao->consulta("$sql");
        $nome_categoria = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($nome_categoria)) {
            $desc_tipo_arquivo_compact[$nome_categoria[$i]['id_categoria']] = $nome_categoria[$i]['nome_categoria'];
            $i++;
        }
        
        $desc['categoria_arquivo'] = $desc_tipo_arquivo_compact;
        return $desc;
    }

}

?>
