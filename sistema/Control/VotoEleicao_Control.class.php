<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade VotoEleicao, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2017-2020, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 04/07/2017
 * @package Control
 */
class VotoEleicao_Control extends Control {

    private $voto_eleicao_dao;

    public function __construct($post_request) {
        parent::__construct($post_request);
        $this->voto_eleicao_dao = $this->config->get_DAO("VotoEleicao");
    }

    /**
     * Inclui novo VotoEleicao
     * @author Marcio Figueredo
     * @return void
     */
    public function Guarda_Codigo($id_associado, $id_eleicao, $codigo) {

        $objeto = new VotoEleicao();

        $objeto->set_id_associado($id_associado);
        $objeto->set_id_eleicao($id_eleicao);
        $objeto->set_codigo($codigo);
        $objeto->set_status_voto_eleicao('E');

        return $this->voto_eleicao_dao->Save($objeto);
    }

    public function Verifica_Voto($id_associado, $id_eleicao, $codigo = -1) {
        $condicao = "AND id_associado = $id_associado AND id_eleicao = $id_eleicao AND (status_voto_eleicao = 'A' OR status_voto_eleicao = 'E')";
        if ($codigo != -1) {
            $condicao .= " AND codigo = $codigo";
        }
        $objeto = $this->voto_eleicao_dao->get_Objs("$condicao", "id_eleicao desc", 0, 1);
        if (isset($objeto[0])) {
            return $objeto[0]->get_all_dados();
        } else {
            return NULL;
        }
    }

    public function Atualiza_Codigo($id_voto, $codigo) {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->voto_eleicao_dao->loadObjeto($id_voto);

        $objeto->set_codigo($codigo);

        $this->voto_eleicao_dao->Save($objeto);
    }

    public function Votar($id_voto, $id_chapa) {
        $objeto = $this->voto_eleicao_dao->loadObjeto($id_voto);

        $objeto->set_id_chapa($id_chapa);
        $objeto->set_data_voto($this->data->get_dataFormat("NOW", "", "BD"));
        
        $this->voto_eleicao_dao->Save($objeto);
    }
    
    public function Finaliza_Voto($id_voto){
        $objeto = $this->voto_eleicao_dao->loadObjeto($id_voto);

        $objeto->set_status_voto_eleicao('A');
        
        $this->voto_eleicao_dao->Save($objeto);
    }

    public function Carrega_Dados($sql) {
        return $this->voto_eleicao_dao->get_Dados($sql);
    }

    public function Lista_Array_Filtro() {
        return $this->voto_eleicao_dao->get_Array_Filtro();
    }
    
    public function Conta_Votos($id_eleicao, $id_chapa){
        $condicao = "AND id_eleicao = $id_eleicao AND id_chapa = $id_chapa AND (status_voto_eleicao = 'A')";
        return $total_reg = $this->voto_eleicao_dao->get_Total("$condicao");
    }

}

?>
