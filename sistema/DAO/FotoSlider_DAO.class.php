<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade FotoSlider, 
 * acessa todas as operações de banco de dados referentes ao Model FotoSlider
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2015-2018, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/04/2015
 * 
 * @package DAO
 *
 */
class FotoSlider_DAO extends Generic_DAO {

    public $chave = 'id_foto';
    public $tabela = 'tb_slider_foto';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {

        $desc = Array();

        $sql = "SELECT g.id_slider, COUNT(f.id_foto) AS total 
                FROM tb_slider g LEFT JOIN " . $this->tabela . " f ON g.id_slider = f.id_slider AND f.status_foto = 'A'
                GROUP BY g.id_slider";
        
        $result = $this->conexao->consulta("$sql");
        $desc_fotos_galeria = $this->conexao->criaArray($result);

        $i = 0;
        while ($i < count($desc_fotos_galeria)) {
            $desc_fotos_galeria_compact[$desc_fotos_galeria[$i]['id_slider']] = $desc_fotos_galeria[$i]['total'];
            $i++;
        }
        $desc['total_fotos'] = $desc_fotos_galeria_compact;

        return $desc;
    }

    public function move_Obj($id, $direcao) {
        //Carrega o objeto selecionado
        $objeto_selecionado = $this->loadObjeto($id);
        $slider_obj_selecionado = $objeto_selecionado->get_id_slider();
        $ordem_antiga_selecionado = $objeto_selecionado->get_ordem();
        //Carrega o próximo objeto
        if ($direcao == 'acima') {
            $sql = "SELECT id_foto, ordem_foto FROM " . $this->tabela . " WHERE ordem_foto < " . $ordem_antiga_selecionado . " AND status_foto <> \"D\" AND id_slider = " . $slider_obj_selecionado . " ORDER BY ordem_foto DESC LIMIT 1";
        } elseif ($direcao == 'abaixo') {
            $sql = "SELECT id_foto, ordem_foto FROM " . $this->tabela . " WHERE ordem_foto > " . $ordem_antiga_selecionado . " AND status_foto <> \"D\" AND id_slider = " . $slider_obj_selecionado . " ORDER BY ordem_foto ASC LIMIT 1";
        }

        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArray($result);

        $sql = "UPDATE " . $this->tabela . " SET ordem_foto = " . $ordem_antiga_selecionado . " WHERE id_foto = " . $ret[0]['id_foto'] . "";
        $result = $this->conexao->consulta("$sql");

        $sql2 = "UPDATE " . $this->tabela . " SET ordem_foto = " . $ret[0]['ordem_foto'] . " WHERE id_foto = " . $id . "";
        $result2 = $this->conexao->consulta("$sql2");

        //$this->corrige_ordem_duplicada($id_slider);
    }

    //Se houver dois registros com a mesma ordem_menu, modifica a ordem_foto do segundo registro (ordenado pelo id_conteudo) para a última ordem.
    public function corrige_ordem_duplicada($id_slider) {

        $sql = "SELECT ordem, COUNT(*) AS ocorrencias FROM " . $this->tabela . " GROUP BY ordem_foto WHERE id_slider = " . $id_slider . "";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArray($result);

        foreach ($ordens as $reg) {
            if ($reg['ocorrencias'] > 1) {

                $sql1 = "SELECT id_foto FROM " . $this->tabela . " WHERE ordem_foto = " . $reg['ordem_foto'] . " AND id_slider = " . $id_slider . " ORDER BY id_foto DESC LIMIT 1";
                $result = $this->conexao->consulta("$sql1");
                $ret1 = $this->conexao->criaArrayOnce($result);

                $nova_ordem_foto = $this->proxima_ordem();

                $sql3 = "UPDATE " . $this->tabela . " SET ordem_foto = " . $nova_ordem_foto . " WHERE id_foto = " . $ret1[0] . " AND id_slider = " . $id_slider . "";
                $result = $this->conexao->consulta("$sql3");
                break; //termina a execução
            }
        }
        $this->corrige_ordem_faltante($id_slider);
    }

    //modifica a ordem_foto de todos os registros, a partir do registro faltante.
    public function corrige_ordem_faltante($id_slider) {

        $sql = "SELECT ordem_foto FROM " . $this->tabela . " WHERE id_slider = " . $id_slider . " ORDER BY ordem_foto";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArrayOnce($result);

        $maior_ordem = end($ordens);

        for ($i = 1; $i <= $maior_ordem; $i++) {
            if (!in_array($i, $ordens)) {
                $sql = "UPDATE " . $this->tabela . " SET ordem_foto = ordem_foto - 1 WHERE ordem_foto > $i AND id_slider = " . $id_slider . "";
                $result = $this->conexao->consulta("$sql");
                break; //termina a execução
            }
        }
    }

    public function proxima_ordem($id_slider) {
        $sql = "SELECT max(ordem_foto) FROM " . $this->tabela . " AND id_slider = " . $id_slider . "";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);
        return $ret[0] + 1;
    }

    public function ordene_foto($arr, $id_slider) {
        $sql = "UPDATE " . $this->tabela . " SET ordem_foto = 0 WHERE id_slider = $id_slider";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);
        foreach ($arr as $key => $value) {
            $ordem_foto = $key;
            $id = $value;
            $sql = "UPDATE " . $this->tabela . " SET ordem_foto = $ordem_foto WHERE id_foto = $id";
            $result = $this->conexao->consulta("$sql");
            $ret = $this->conexao->criaArrayOnce($result);
        }
    }

}
