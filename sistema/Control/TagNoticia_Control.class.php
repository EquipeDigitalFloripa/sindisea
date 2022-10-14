<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade TagNoticia, filho de Control
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
class TagNoticia_Control extends Control {

    private $tag_noticia_dao;
    private $ctrl_tag;

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
     *       $this->tag_noticia_dao = $config->get_DAO("TagNoticia");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->tag_noticia_dao = $this->config->get_DAO("TagNoticia");
        $this->ctrl_tag = new Tags_Control($this->post_request);
    }

    /**
     * Chama View de inclusão de Tags do Post
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function TagNoticia_Add_V($id_noticia) {
        $this->post_request['co'] = base64_encode("TagNoticia_Control");
        $this->post_request['id'] = $id_noticia;

        $descricoes = $this->tag_noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new TagNoticia_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui uma Tags do Post
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function TagNoticia_Add($id_noticia) {

        if ($this->post_request['desc_tag'] != NULL) {

            if (!$this->ctrl_tag->Tags_Existe($this->post_request['desc_tag'])) {
                $this->ctrl_tag->Tags_Add();
            }
            $retorno = FALSE;
        }

        if (isset($this->post_request['tag_noticia']) && $this->post_request['tag_noticia'] != NULL) {

            //Remover Tags da Notícia
            $this->tag_noticia_dao->removeTags($id_noticia);

            //Cadastra Tags da Notícia
            for ($i = 0; $i < count($this->post_request['tag_noticia']); $i++) {
                $objeto = new TagNoticia();

                $objeto->set_id_noticia($id_noticia);
                $objeto->set_id_tag($this->post_request['tag_noticia'][$i]);
                $objeto->set_status_tag_noticia("A");

                $this->tag_noticia_dao->Save($objeto);
            }
            $retorno = TRUE;
        }
        return $retorno;
    }

    /**
     * Retorna os objetos referente ao ID do Post
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Pega_Objets($id_noticia) {
        $condicao = " AND status_tag_noticia = \"A\" AND id_noticia = $id_noticia";

        $ordem = "desc_tag_noticias ASC";

        $objetos = $this->tag_noticia_dao->get_Objs($condicao, $ordem, 0, 100000);
        return $objetos;
    }

    /**
     * Solicita ao Controlado Tags_Control a lista de Tags
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Solicita_Lista_Tags() {
        return $this->ctrl_tag->Lista_Tags();
    }

    public function Pega_Tags_Noticia($id_noticia) {
        $condicao = " AND id_noticia = $id_noticia AND status_tag_noticia = \"A\"";
        $objetos = $this->tag_noticia_dao->get_Objs("$condicao", "id_tag_noticia", 0, 10000);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_id_tag();
            $i++;
        }
        return $dados;
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */

    public function Lista_Tags_Noticia($id_noticia) {

        $condicao = " AND id_noticia = $id_noticia AND status_tag_noticia = \"A\"";
        $objetos = $this->tag_noticia_dao->get_Objs("$condicao", "id_tag_noticia", 0, 10000);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }
    
    public function Lista_Noticias_Tag($id_tag) {

        $condicao = " AND id_tag = $id_tag AND status_tag_noticia = \"A\"";
        $objetos = $this->tag_noticia_dao->get_Objs("$condicao", "id_tag_noticia", 0, 10000);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

}

?>