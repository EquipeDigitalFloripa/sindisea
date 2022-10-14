<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Foto, 
 * acessa todas as operações de banco de dados referentes ao Model Foto
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
class FotoGaleria_DAO extends Generic_DAO {

    public $chave = 'id_foto';
    public $tabela = 'tb_foto_galeria';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricoes() {

        $desc = Array();

        $sql = "SELECT g.id_galeria, COUNT(f.id_foto) AS total FROM tb_galeria g LEFT JOIN tb_foto_galeria f ON g.id_galeria = f.id_galeria AND f.status_foto = \"A\" GROUP BY g.id_galeria";
        $result = $this->conexao->consulta("$sql");
        $desc_fotos_galeria = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($desc_fotos_galeria)) {
            $desc_fotos_galeria_compact[$desc_fotos_galeria[$i]['id_galeria']] = $desc_fotos_galeria[$i]['total'];
            $i++;
        }
        $desc['total_fotos'] = $desc_fotos_galeria_compact;

        //Nome da galeria
        $sql = "SELECT id_galeria, titulo FROM tb_galeria";
        $result = $this->conexao->consulta("$sql");
        $desc_galeria = $this->conexao->criaArray($result);
        $i = 0;

        while ($i < count($desc_galeria)) {
            $desc_galeria_compact[$desc_galeria[$i]['id_galeria']] = $desc_galeria[$i]['titulo'];
            $i++;
        }
        $desc['titulo'] = array_map("stripslashes", $desc_galeria_compact);
        return $desc;
    }

    public function move_Obj($id, $direcao) {
        //Carrega o objeto selecionado
        $objeto_selecionado = $this->loadObjeto($id);
        $galeria_obj_selecionado = $objeto_selecionado->get_id_galeria();
        $ordem_antiga_selecionado = $objeto_selecionado->get_ordem();
        //Carrega o próximo objeto
        if ($direcao == 'acima') {
            $sql = "SELECT id_foto, ordem FROM tb_foto_galeria WHERE ordem < " . $ordem_antiga_selecionado . " AND status_foto <> \"D\" AND id_galeria = " . $galeria_obj_selecionado . " ORDER BY ordem DESC LIMIT 1";
        } elseif ($direcao == 'abaixo') {
            $sql = "SELECT id_foto, ordem FROM tb_foto_galeria WHERE ordem > " . $ordem_antiga_selecionado . " AND status_foto <> \"D\" AND id_galeria = " . $galeria_obj_selecionado . " ORDER BY ordem ASC LIMIT 1";
        }

        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArray($result);

        $sql = "UPDATE tb_foto_galeria SET ordem = " . $ordem_antiga_selecionado . " WHERE id_foto = " . $ret[0]['id_foto'] . "";
        $result = $this->conexao->consulta("$sql");

        $sql2 = "UPDATE tb_foto_galeria SET ordem = " . $ret[0]['ordem'] . " WHERE id_foto = " . $id . "";
        $result2 = $this->conexao->consulta("$sql2");

        //$this->corrige_ordem_duplicada($id_galeria);
    }

    //Se houver dois registros com a mesma ordem_menu, modifica a ordem do segundo registro (ordenado pelo id_conteudo) para a última ordem.
    public function corrige_ordem_duplicada($id_galeria) {

        $sql = "SELECT ordem, COUNT( * ) AS ocorrencias FROM tb_foto_galeria GROUP BY ordem WHERE id_galeria = " . $id_galeria . "";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArray($result);

        foreach ($ordens as $reg) {
            if ($reg['ocorrencias'] > 1) {

                $sql1 = "SELECT id_foto FROM tb_foto_galeria WHERE ordem = " . $reg['ordem'] . " AND id_galeria = " . $id_galeria . " ORDER BY id_foto DESC LIMIT 1";
                $result = $this->conexao->consulta("$sql1");
                $ret1 = $this->conexao->criaArrayOnce($result);

                $nova_ordem = $this->proxima_ordem();

                $sql3 = "UPDATE tb_foto_galeria SET ordem = " . $nova_ordem . " WHERE id_foto = " . $ret1[0] . " AND id_galeria = " . $id_galeria . "";
                $result = $this->conexao->consulta("$sql3");
                break; //termina a execução
            }
        }
        $this->corrige_ordem_faltante($id_galeria);
    }

    //modifica a ordem de todos os registros, a partir do registro faltante.
    public function corrige_ordem_faltante($id_galeria) {

        $sql = "SELECT ordem FROM tb_foto_galeria WHERE id_galeria = " . $id_galeria . " ORDER BY ordem";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArrayOnce($result);

        $maior_ordem = end($ordens);

        for ($i = 1; $i <= $maior_ordem; $i++) {
            if (!in_array($i, $ordens)) {
                $sql = "UPDATE tb_foto_galeria SET ordem = ordem - 1 WHERE ordem > $i AND id_galeria = " . $id_galeria . "";
                $result = $this->conexao->consulta("$sql");
                break; //termina a execução
            }
        }
    }

    public function set_capa($id) {

        $obj = $this->loadObjeto($id);
        $id_galeria = $obj->get_id_galeria();
        $sql = "UPDATE tb_foto_galeria SET destaque = 0 WHERE id_galeria = $id_galeria";
        $this->conexao->consulta("$sql");
        $sql = "UPDATE tb_foto_galeria SET destaque = 1 WHERE id_foto = $id";
        $this->conexao->consulta("$sql");
    }

    public function set_capa_excluido($id) {

        $obj = $this->loadObjeto($id);
        $galeria = $obj->get_id_galeria();
        echo $galeria;
        $nova_capa = $this->get_Ids(" and id_galeria = " . $galeria . " and status_foto = \"A\"", "ordem", 0, 1);
        $idnc = $nova_capa[0];
        $sql = "UPDATE tb_foto_galeria SET destaque = 1 WHERE id_foto = $idnc";
        $this->conexao->consulta("$sql");
    }

    public function proxima_ordem($id_galeria) {
        $sql = "SELECT max(ordem) from tb_foto_galeria AND id_galeria = " . $id_galeria . "";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);
        return $ret[0] + 1;
    }

    public function ordene_foto($arr, $id_imoveis) {
        $sql = "UPDATE tb_foto_galeria SET ordem = 0 WHERE id_imoveis = $id_imoveis";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);
        foreach ($arr as $key => $value) {
            $ordem = $key;
            $id = $value;
            $sql = "UPDATE tb_foto_galeria SET ordem = $ordem WHERE id_foto = $id";
            $result = $this->conexao->consulta("$sql");
            $ret = $this->conexao->criaArrayOnce($result);
        }
    }

}

?>
