<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Mailing, filho de Control
 *
 * @author Marcio Figueredo
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 25/03/2015
 *
 */
class Video_Control extends Control {

    private $video_dao;

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
     *       $this->video_dao = $config->get_DAO("Depoimento");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->video_dao = $this->config->get_DAO("Video");
    }

    /**
     * Mostra a lista de Videos
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Gerencia() {

        $total_reg = $this->video_dao->get_Total("$condicao");

        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 15;

        $mat = $this->post_request['pagina'] - 1;
        $inicio = $mat * $pag_views;

        $ordem = "data_video DESC";

        $objetos = $this->video_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->video_dao->get_Descricao();

        $vw = new Video_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de um novo Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Add_V() {

        $descricoes = $this->video_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Video_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Inclui um novo Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Add() {

        $objeto = new Video();

        $objeto->set_titulo_video($this->post_request['titulo_video']);
        $objeto->set_texto_video($this->post_request['texto_video']);
        $objeto->set_iframe_video($this->post_request['iframe_video']);
        $objeto->set_data_video($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_video('A');

        $this->video_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("5006", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());

        $this->Video_Add_V();
    }

    /**
     * Chama View de alteração de dados do Vídeo
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Altera_V() {

        /* PEGA OBJTO E DESCRIÇÕES */
        $objeto = $this->video_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->video_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Video_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados do Vídeo
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Altera() {

        /* CARREGA DAO, SETA DADOS e SALVA */
        $objeto = $this->video_dao->loadObjeto($this->post_request['id']);

        $objeto->set_titulo_video($this->post_request['titulo_video']);
        $objeto->set_texto_video($this->post_request['texto_video']);
        $objeto->set_iframe_video($this->post_request['iframe_video']);

        $this->video_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("5006", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());

        $this->Video_Gerencia();
    }

    /**
     * Desativa um Vídeo
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Desativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->video_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_video("I");

        $this->video_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());

        $this->Video_Gerencia();
    }

    /**
     * Ativa um Video
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Ativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->video_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_video("A");
        $this->video_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());

        $this->Video_Gerencia();
    }

    /**
     * Deleta um Vídeo
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Video_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->video_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_video("D");
        $this->video_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg40());

        $this->Video_Gerencia();
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */

    public function Listar_Videos($condicao, $ordem, $inicio = 0, $qtde = 1) {

        $objetos = $this->video_dao->get_Objs("$condicao", "$ordem", $inicio, $qtde);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

    public function Pega_Iframe_Video($id_video) {
        $objeto = $this->video_dao->loadObjeto($id_video);
        return $objeto->get_iframe_video();
    }

}

?>
