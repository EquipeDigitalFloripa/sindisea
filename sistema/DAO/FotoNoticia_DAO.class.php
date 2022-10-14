<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade FotoNoticia, acessa todas as operações de banco de dados referentes ao Model FotoNoticia que está em Libs
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
class FotoNoticia_DAO extends Generic_DAO {

    public $chave = 'id_foto';
    public $tabela = 'tb_foto_noticia';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {

        $desc = Array();

        $sql = "SELECT g.id_noticia, COUNT(f.id_foto) AS total FROM tb_noticia g LEFT JOIN tb_foto_noticia f ON g.id_noticia = f.id_noticia AND f.status_foto = \"A\" GROUP BY g.id_noticia";
        $result = $this->conexao->consulta("$sql");
        $desc_fotos_notica = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($desc_fotos_notica)) {
            $desc_fotos_notica_compact[$desc_fotos_notica[$i]['id_noticia']] = $desc_fotos_notica[$i]['total'];
            $i++;
        }
        $desc['total_fotos'] = $desc_fotos_notica_compact;

        //Nome da post
        $sql = "SELECT id_noticia, titulo FROM tb_noticia";
        $result = $this->conexao->consulta("$sql");
        $desc_noticia = $this->conexao->criaArray($result);

        $desc['titulo_noticia'] = parent::get_Descricoes('tb_noticia');


//        while ($i < count($desc_noticia)) {
//            $desc_noticia_compact[$desc_noticia[$i]['id_noticia']] = $desc_noticia[$i]['nome'];
//            $i++;
//        }        
//        $desc['nome'] = array_map("stripslashes", $desc_noticia_compact);        
        return $desc;
    }

    public function move_Obj($id, $direcao) {
        //Carrega o objeto selecionado
        $objeto_selecionado = $this->loadObjeto($id);
        $noticia_obj_selecionado = $objeto_selecionado->get_id_noticia();
        $ordem_antiga_selecionado = $objeto_selecionado->get_ordem();
        //Carrega o próximo objeto
        if ($direcao == 'acima') {
            $sql = "SELECT id_foto, ordem_foto FROM tb_foto_noticia WHERE ordem_foto < " . $ordem_antiga_selecionado . " AND status_foto <> \"D\" AND id_noticia = " . $noticia_obj_selecionado . " ORDER BY ordem_foto DESC LIMIT 1";
        } elseif ($direcao == 'abaixo') {
            $sql = "SELECT id_foto, ordem_foto FROM tb_foto_noticia WHERE ordem_foto > " . $ordem_antiga_selecionado . " AND status_foto <> \"D\" AND id_noticia = " . $noticia_obj_selecionado . " ORDER BY ordem_foto ASC LIMIT 1";
        }

        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArray($result);

        $sql = "UPDATE tb_foto_noticia SET ordem_foto = " . $ordem_antiga_selecionado . " WHERE id_foto = " . $ret[0]['id_foto'] . "";
        $result = $this->conexao->consulta("$sql");

        $sql2 = "UPDATE tb_foto_noticia SET ordem_foto = " . $ret[0]['ordem'] . " WHERE id_foto = " . $id . "";
        $result2 = $this->conexao->consulta("$sql2");

        //$this->corrige_ordem_duplicada($id_noticia);
    }

    //Se houver dois registros com a mesma ordem_menu, modifica a ordem_foto do segundo registro (ordenado pelo id_conteudo) para a última ordem.
    public function corrige_ordem_duplicada($id_noticia) {

        $sql = "SELECT ordem_foto, COUNT( * ) AS ocorrencias FROM tb_foto_noticia GROUP BY ordem_foto WHERE id_noticia = " . $id_noticia . "";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArray($result);

        foreach ($ordens as $reg) {
            if ($reg['ocorrencias'] > 1) {

                $sql1 = "SELECT id_foto FROM tb_foto_noticia WHERE ordem_foto = " . $reg['ordem_foto'] . " AND id_noticia = " . $id_noticia . " ORDER BY id_foto DESC LIMIT 1";
                $result = $this->conexao->consulta("$sql1");
                $ret1 = $this->conexao->criaArrayOnce($result);

                $nova_ordem = $this->proxima_ordem();

                $sql3 = "UPDATE tb_foto_noticia SET ordem_foto = " . $nova_ordem . " WHERE id_foto = " . $ret1[0] . " AND id_noticia = " . $id_noticia . "";
                $result = $this->conexao->consulta("$sql3");
                break; //termina a execução
            }
        }
        $this->corrige_ordem_faltante($id_noticia);
    }

    //modifica a ordem_foto de todos os registros, a partir do registro faltante.
    public function corrige_ordem_faltante($id_noticia) {

        $sql = "SELECT ordem_foto FROM tb_foto_noticia WHERE id_noticia = " . $id_noticia . " ORDER BY ordem_foto";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArrayOnce($result);

        $maior_ordem = end($ordens);

        for ($i = 1; $i <= $maior_ordem; $i++) {
            if (!in_array($i, $ordens)) {
                $sql = "UPDATE tb_foto_noticia SET ordem_foto = ordem_foto - 1 WHERE ordem_foto > $i AND id_noticia = " . $id_noticia . "";
                $result = $this->conexao->consulta("$sql");
                break; //termina a execução
            }
        }
    }

    public function set_capa($id) {
        $obj = $this->loadObjeto($id);
        $id_noticia = $obj->get_id_noticia();

        $sql = "UPDATE tb_foto_noticia SET destaque_foto = 0 WHERE id_noticia = $id_noticia";
        $this->conexao->consulta("$sql");

        $sql2 = "UPDATE tb_foto_noticia SET destaque_foto = 1 WHERE id_foto = $id";
        $this->conexao->consulta("$sql2");
    }

    public function set_capa_excluido($id) {

        $obj = $this->loadObjeto($id);
        $id_noticia = $obj->get_id_noticia();
        $nova_capa = $this->get_Ids(" and id_noticia = " . $id_noticia . " and status_foto = \"A\"", "ordem", 0, 1);
        $idnc = $nova_capa[0];
        $sql = "UPDATE tb_foto_noticia SET destaque_foto = 1 WHERE id_foto = $idnc";
        $this->conexao->consulta("$sql");
    }

    public function proxima_ordem($id_noticia) {
        $sql = "SELECT max(ordem) from tb_foto_noticia AND id_noticia = " . $id_noticia . "";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);
        return $ret[0] + 1;
    }

    public function ordene_foto($arr, $id_noticia) {
        $sql = "UPDATE tb_foto_noticia SET ordem_foto = 0 WHERE id_noticia = $id_noticia";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);

        foreach ($arr as $key => $value) {
            $ordem_foto = $key + 1;
            $id = $value;
            $sql = "UPDATE tb_foto_noticia SET ordem_foto = $ordem_foto WHERE id_foto = $id";
            $result = $this->conexao->consulta("$sql");
            $ret = $this->conexao->criaArrayOnce($result);
        }
    }

    public function saveDefault($id_noticia) {

        $sql = "SELECT max(id_foto) id_foto FROM tb_foto_noticia";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArrayOnce($result);
        $id_foto = $row[0];
        $id_foto++;

        $diretorio = "../sys/arquivos/img_noticias/";
        if (!copy($diretorio . "default.jpg", $diretorio . "$id_foto.$ext_foto")) {
            print_r('ERRO');
        } else {
            $objImage = new Imagem();
            $img = $objImage->resizeImage($diretorio, "$id_foto.$ext_foto", 1000);

            copy($diretorio . "default.jpg", $diretorio . "orig_$id_foto.$ext_foto");
            $img2 = $objImage->resizeMinImage($diretorio, "orig_$id_foto.$ext_foto", 665);

            $sql = "INSERT INTO tb_foto_noticia VALUES($id_foto, $id_noticia, \"\", \"jpg\", 1, 1, \"A\")";
            $result = $this->conexao->consulta("$sql");
        }
    }

    public function get_Foto_Destaque($id_noticia){
        
        $sql = 'SELECT * FROM tb_foto_noticia WHERE id_noticia = '.$id_noticia.' AND destaque_foto = 1';        
        
        $result = $this->conexao->consulta("$sql");                
        $row = $this->conexao->criaArray($result);
        
        return $row;
    }
}

?>
