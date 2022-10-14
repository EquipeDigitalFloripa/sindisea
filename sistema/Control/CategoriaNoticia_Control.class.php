<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade CategoriaNoticia, filho de Control
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
class CategoriaNoticia_Control extends Control {

    private $categoria_noticia_dao;

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
     *       $this->categoria_noticia_dao = $config->get_DAO("CategoriaNoticia");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->categoria_noticia_dao = $this->config->get_DAO("CategoriaNoticia");
    }

    /**
     *
     * Mostra a lista de Categoria de Noticia
     *
     * @author Marcio Figueredo
     * @return void
     *
     */
    public function CategoriaNoticia_Gerencia() {


        /* CONFIGURA FILTROS DE PESQUISA */
        $pesquisa = $this->post_request['pesquisa'];
        if ($pesquisa != "") {
            $condicao .= " AND desc_categoria_noticia LIKE '%$pesquisa%'";
        } else {
            $condicao .= " AND (status_categoria_noticia = \"A\" OR status_categoria_noticia = \"I\")";
        }
        if ($this->post_request['selecao01'] > 0) {
            $condicao .= " AND id_tipo_noticia = " . $this->post_request['selecao01'] . "";
        }
        switch ($this->post_request['selecao02']) {
            case 1: $condicao .= " AND status_categoria_noticia = \"A\"";
                break;
            case 2: $condicao .= " AND status_categoria_noticia = \"I\"";
                break;
            default: $condicao .= " AND (status_categoria_noticia = \"A\" OR status_categoria_noticia = \"I\")";
        }

        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->categoria_noticia_dao->get_Total("$condicao");

        /* INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA - NAO MODIFIQUE */
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /* CONFIGURE O NUMERO DE REGISTROS POR PAGINA */
        $pag_views = 50; // número de registros por página

        /* CALCULA OS PARAMETROS DE PAGINACAO */
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "desc_categoria_noticia";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->categoria_noticia_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->categoria_noticia_dao->get_Descricao();


        /* CARREGA A VIEW E MOSTRA */
        $vw = new CategoriaNoticia_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de uma nova Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function CategoriaNoticia_Add_V() {

        $descricoes = $this->categoria_noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new CategoriaNoticia_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui uma nova Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function CategoriaNoticia_Add() {

        $objeto = new CategoriaNoticia();
        
        $objeto->set_desc_categoria_noticia($this->post_request['desc_categoria_noticia']);
        $objeto->set_data_cadastro_categoria_noticia($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_categoria_noticia("A");
        
        $this->categoria_noticia_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4035", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->CategoriaNoticia_Gerencia();
    }

    /**
     * Chama View de alteração de uma Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function CategoriaNoticia_Altera_V() {

        /* PEGA OBJTO E DESCRIÇÕES */
        $objeto = $this->categoria_noticia_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->categoria_noticia_dao->get_Descricao();


        /* CARREGA A VIEW E MOSTRA */
        $vw = new CategoriaNoticia_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados de uma Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function CategoriaNoticia_Altera() {

        /* CARREGA DAO, SETA DADOS e SALVA */
        $objeto = $this->categoria_noticia_dao->loadObjeto($this->post_request['id']);

        $objeto->set_desc_categoria_noticia($this->post_request['desc_categoria_noticia']);

        $this->categoria_noticia_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4033", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->CategoriaNoticia_Gerencia();
    }

    /**
     * Desativa uma Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function CategoriaNoticia_Desativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->categoria_noticia_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria_noticia("I");

        $this->categoria_noticia_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        $this->CategoriaNoticia_Gerencia();
    }

    /**
     * Ativa uma Categoria de Notícias
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function CategoriaNoticia_Ativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->categoria_noticia_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria_noticia("A");
        $this->categoria_noticia_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->CategoriaNoticia_Gerencia();
    }

    /**
     * Deleta uma Categoria de Notícias
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function CategoriaNoticia_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->categoria_noticia_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria_noticia("D");
        $this->categoria_noticia_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg40());
        $this->CategoriaNoticia_Gerencia();
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */
}

?>
