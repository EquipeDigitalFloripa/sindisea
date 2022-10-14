<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Noticia, acessa todas as operações de banco de dados referentes ao Model Noticia que está em Libs
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
class Noticia_DAO extends Generic_DAO {

    public $chave = 'id_noticia';
    public $tabela = 'tb_noticia';

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
        $desc_destaque_compact = "";

        //$desc['tipo_noticia'] = parent::get_Descricoes('tb_tipo_noticia');
        $desc['categoria_noticia'] = parent::get_Descricoes('tb_categoria_noticia');
        $desc['paginas'] = parent::get_Descricoes('tb_conteudo', 0, 1, " AND id_conteudo != 1 AND id_conteudo != 11");

        //Pega a foto da capa
        $sql = "SELECT P.id_noticia, CONCAT(F.id_foto,'.',F.ext_foto) AS arquivo 
                FROM tb_noticia P LEFT JOIN tb_foto_notica F ON P.id_noticia = F.id_noticia AND F.destaque_foto = 1 AND F.status_foto = \"A\"";

        $result = $this->conexao->consulta("$sql");
        $desc_destaque = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($desc_destaque)) {
            $desc_destaque_compact[$desc_destaque[$i]['id_noticia']] = $desc_destaque[$i]['arquivo'];
            $i++;
        }
        $desc['foto_destaque'] = $desc_destaque_compact;

        return $desc;
    }

    public function Verificar($string) {

        $sql = "SELECT id_noticia FROM tb_noticia WHERE url_amigavel = '" . trim($string) . "'";        
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        
        return $row[0][0];
    }

    public function Importar($ac) {

        if ($ac == 'apagar') {

            $this->conexao->consulta("DELETE FROM tb_noticia");
            $this->conexao->consulta("DELETE FROM tb_foto_noticia");
        } else if ($ac == 'importar') {
            $sql = 'SELECT * FROM tb_noticia_BKP ORDER BY id_noticia ASC';
            $result = $this->conexao->consulta("$sql");
            $row = $this->conexao->criaArray($result);

//            print_r($row[0]['data_cadastro_noticia']);
//            die;

            $i = 0;
            while ($i < count($row)) {

                $sql_insert = 'INSERT INTO tb_noticia VALUES(
                    ' . $row[$i]['id_noticia'] . ', 
                    ' . $row[$i]['categoria'] . ', 
                    \'' . addslashes($row[$i]['titulo_noticia']) . '\', 
                    \'' . addslashes($row[$i]['description_noticia']) . '\', 
                    \'' . addslashes($row[$i]['texto_noticia']) . '\', 
                    \'' . $row[$i]['data_noticia'] . '\', 
                    \'' . $row[$i]['data_cadastro_noticia'] . '\', 
                    \'' . $row[$i]['data_noticia'] . '\', 
                    \'\', 
                    \'\',
                    0, 
                    \'' . $row[$i]['status_noticia'] . 's\'
                );';
                $this->conexao->consulta("$sql_insert");

                $sql_insert_img = 'INSERT INTO tb_foto_noticia VALUES(' . $row[$i]['id_noticia'] . ', ' . $row[$i]['id_noticia'] . ', "", "' . $row[$i]['ext_img_noticia'] . '", 1, 1, "A")';
                $this->conexao->consulta("$sql_insert_img");
                $i++;
            }
        }
        return TRUE;
    }

}

?>