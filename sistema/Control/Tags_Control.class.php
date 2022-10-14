<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Tags, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 11/07/2016
 * @package Control
 *
 */
class Tags_Control extends Control {

    private $tag_dao;

    /**
     * Carrega o contrutor do pai.
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $post_request Parâmetros de _POST e _REQUEST
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       parent::__construct();
     *       $config = new Config();
     *       $this->tag_dao = $config->get_DAO("Tags");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->tag_dao = $this->config->get_DAO("Tags");
    }

    /**
     * Inclui um novo Tags
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Tags_Add() {

        $objeto = new Tags();

        $objeto->set_desc_tag($this->post_request['desc_tag']);
        $objeto->set_data_cadastro_tag($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_tag("A");

        return $this->tag_dao->Save($objeto);
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */

    /**
     * Verifica se já exite Tag cadastrada
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Tags_Existe($desc_tag) {
        return $this->tag_dao->tag_Existe($desc_tag);
    }

    /**
     * Retorna uma array com todas as Tags cadastradas
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Lista_Tags() {

        $objetos = $this->tag_dao->get_Objs(" AND status_tag = \"A\"", "desc_tag ASC", 0, 100000);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }

    public function Pega_Tag($id_tag) {

        $post = $this->tag_dao->loadObjeto($id_tag);
        return $post->get_desc_tag();
    }

    public function Pega_Id_Tag($desc_tag) {

        $post = $this->tag_dao->loadObjeto_Id($desc_tag);
        $id_tag = $post[0][0];
        return $id_tag;
    }

}

?>
