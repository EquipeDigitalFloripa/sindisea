<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Galeria, 
 * acessa todas as operações de banco de dados referentes ao Model Galeria
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 13/10/2009
 * @Ultima_Modif 13/10/2009 por Marcela Santana
 *
 * @package DAO
 *
 */
class Galeria_DAO extends Generic_DAO {

    public $chave = 'id_galeria';
    public $tabela = 'tb_galeria';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function set_destaque($id) {

        $obj = $this->loadObjeto($id);
        
        $categoria = $obj->get_categoria();
        
        $sql = "UPDATE tb_galeria SET destaque = 0 WHERE categoria = $categoria";
        $this->conexao->consulta($sql);
        
        $sql2 = "UPDATE tb_galeria SET destaque = 1 WHERE id_galeria = $id";
        $this->conexao->consulta($sql2);
    }

    public function get_Descricoes($pag_views = 0, $inicio = 0, $ordem = NULL, $id_categoria = 0, $retira = 0) {

        // Where
        $where = $id_categoria > 0 ? " AND p.id_categoria_galeria = $id_categoria" : "";
        $where .= $retira != 0 ? " AND p.id_galeria <> $retira" : "";

        // Order By
        $order_by = $ordem != NULL ? "ORDER BY $ordem" : "";

        // Limit
        $limite = $pag_views != NULL ? "LIMIT $inicio, $pag_views" : "";

        $desc = array();

        // total de fotos por galeria
        $sql = "
            SELECT
                p.id_galeria,
                COUNT(f.id_foto) AS total
              FROM tb_galeria p
              LEFT JOIN tb_foto_galeria f
                ON p.id_galeria = f.id_galeria AND f.status_foto = 'A'
             WHERE status_galeria = 'A' $where
             GROUP BY p.id_galeria
             $order_by
             $limite
        ";
        $result = $this->conexao->consulta($sql);
        $desc_fotos_produto = $this->conexao->criaArray($result);

        $i = 0;
        while ($i < count($desc_fotos_produto)) {
            $desc_fotos_produto_compact[$desc_fotos_produto[$i]['id_galeria']] = $desc_fotos_produto[$i]['total'];
            $i++;
        }
        $desc['total_fotos'] = $desc_fotos_produto_compact;

        // Pega a foto da capa
        $sql2 = "
            SELECT p.id_galeria,
                CONCAT(f.id_foto,'.',f.ext_img) AS arquivo
              FROM tb_galeria p
              LEFT JOIN tb_foto_galeria f
                ON p.id_galeria = f.id_galeria AND f.destaque = 1 AND f.status_foto = \"A\"
             WHERE status_galeria = 'A' $where
             $order_by
             $limite
        ";
        $result2 = $this->conexao->consulta($sql2);
        $desc_destaque = $this->conexao->criaArray($result2);

        $j = 0;
        while ($j < count($desc_destaque)) {
            $desc_dest_arquivo[$desc_destaque[$j]['id_galeria']] = $desc_destaque[$j]['arquivo'];
            $desc_dest_legenda[$desc_destaque[$j]['id_galeria']] = $desc_destaque[$j]['legenda'];
            $j++;
        }
        $desc['foto_destaque'] = $desc_dest_arquivo;
        $desc['foto_legenda'] = $desc_dest_legenda;

        // Pega nome das categorias
        $desc['nome_categoria'] = parent::get_Descricoes('tb_categoria_galeria', 0, 'nome_categoria', "ORDER BY nome_categoria ASC");
        $desc['slug_categoria'] = parent::get_Descricoes('tb_categoria_galeria', 0, 'slug', "ORDER BY nome_categoria ASC");

        return $desc;
    }


}
