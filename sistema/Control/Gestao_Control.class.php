<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Gestao, filho de Control
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
class Gestao_Control extends Control {

    private $gestao_dao;

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
     *       $this->gestao_dao = $config->get_DAO("Gestao");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->gestao_dao = $this->config->get_DAO("Gestao");
    }

    /**
     *
     * Mostra a lista de Categoria de Noticia
     *
     * @author Marcio Figueredo
     * @return void
     *
     */
    public function Gestao_Gerencia() {


        /* CONFIGURA FILTROS DE PESQUISA */
        $pesquisa = $this->post_request['pesquisa'];
        
        switch ($this->post_request['selecao02']) {
            case 1: $condicao .= " AND status_gestao = \"A\"";
                break;
            case 2: $condicao .= " AND status_gestao = \"I\"";
                break;
            default: $condicao .= " AND (status_gestao = \"A\" OR status_gestao = \"I\")";
        }

        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->gestao_dao->get_Total("$condicao");

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
        $ordem = "desc_gestao";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->gestao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->gestao_dao->get_Descricao();


        /* CARREGA A VIEW E MOSTRA */
        $vw = new Gestao_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de uma nova Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Gestao_Add_V() {

        $descricoes = $this->gestao_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Gestao_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui uma nova Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Gestao_Add() {

        $objeto = new Gestao();
        
        $objeto->set_desc_gestao($this->post_request['desc_gestao']);
        $objeto->set_data_cadastro_gestao($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_gestao("A");
        $objeto->set_destaque_gestao(0);
        
        $this->gestao_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("5051", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Gestao_Gerencia();
    }

    /**
     * Chama View de alteração de uma Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Gestao_Altera_V() {

        /* PEGA OBJTO E DESCRIÇÕES */
        $objeto = $this->gestao_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->gestao_dao->get_Descricao();


        /* CARREGA A VIEW E MOSTRA */
        $vw = new Gestao_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados de uma Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Gestao_Altera() {

        /* CARREGA DAO, SETA DADOS e SALVA */
        $objeto = $this->gestao_dao->loadObjeto($this->post_request['id']);

        $objeto->set_desc_gestao($this->post_request['desc_gestao']);

        $this->gestao_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("5053", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Gestao_Gerencia();
    }

    /**
     * Desativa uma Categoria de Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Gestao_Desativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->gestao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_gestao("I");

        $this->gestao_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("5052", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Gestao_Gerencia();
    }

    /**
     * Ativa uma Categoria de Notícias
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Gestao_Ativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->gestao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_gestao("A");
        $this->gestao_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("5052", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Gestao_Gerencia();
    }

    /**
     * Deleta uma Categoria de Notícias
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Gestao_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->gestao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_gestao("D");
        $this->gestao_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("5052", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Gestao_Gerencia();
    }
    

    public function Gestao_Destaque() {

        $this->traducao->loadTraducao("5052", $this->post_request['idioma']);

        $objeto = $this->gestao_dao->loadObjeto($this->post_request['id']);
        $destacadas = $this->gestao_dao->get_Total("AND status_gestao = 'A' and destaque_gestao = 1");
        if ($destacadas == $this->config->get_gestao_destaque()) {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg41());
        } else {
            $objeto->set_destaque_gestao(1);
            $this->gestao_dao->Save($objeto);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        }
        $this->Gestao_Gerencia();
    }

    public function Gestao_Reverter_Destaque() {
        $this->traducao->loadTraducao("5052", $this->post_request['idioma']);
        $objeto = $this->gestao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_destaque_gestao(0);
        $this->gestao_dao->Save($objeto);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg40());
        $this->Gestao_Gerencia();
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */
    
    
    public function Lista_Gestoes($qtde, $inicio, $ordem, $condicao = "") {

        $objetos = $this->gestao_dao->get_Objs(" AND status_gestao = 'A' $condicao", $ordem, $inicio, $qtde);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }
    
    
    
    public function Pega_Gestao_Destaque() {

        $objetos = $this->gestao_dao->get_Objs(" AND destaque_gestao = 1 AND status_gestao = 'A'", 'id_gestao DESC', 0, 1);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados[0];
    }
    
}

?>
