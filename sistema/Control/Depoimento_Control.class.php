<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Depoimento, filho de Control
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
class Depoimento_Control extends Control {

    private $depoimento_dao;

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
     *       $this->depoimento_dao = $config->get_DAO("Depoimento");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->depoimento_dao = $this->config->get_DAO("Depoimento");
    }

    /**
     * Mostra a lista de Depoimentos
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Gerencia() {

        $condicao = "";

        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->depoimento_dao->get_Total("$condicao");

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
        $ordem = "data_depoimento DESC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->depoimento_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->depoimento_dao->get_Descricao();


        /* CARREGA A VIEW E MOSTRA */
        $vw = new Depoimento_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de um novo Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Add_V() {

        $descricoes = $this->depoimento_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Depoimento_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui um novo Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Add() {

        $objeto = new Depoimento();

        $objeto->set_nome_depoimento($this->post_request['nome_depoimento']);
        $objeto->set_texto_depoimento($this->post_request['texto_depoimento']);
        $objeto->set_data_depoimento($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_depoimento("A");

        $this->depoimento_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4061", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Depoimento_Gerencia();
    }

    /**
     * Chama View de alteração de um Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Altera_V() {

        /* PEGA OBJTO E DESCRIÇÕES */
        $objeto = $this->depoimento_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->depoimento_dao->get_Descricao();


        /* CARREGA A VIEW E MOSTRA */
        $vw = new Depoimento_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados de um Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Altera() {

        /* CARREGA DAO, SETA DADOS e SALVA */
        $objeto = $this->depoimento_dao->loadObjeto($this->post_request['id']);

        $objeto->set_nome_depoimento($this->post_request['nome_depoimento']);
        $objeto->set_texto_depoimento($this->post_request['texto_depoimento']);
        $objeto->set_data_depoimento($this->data->get_dataFormat("NOW", "", "BD"));
              
        $this->depoimento_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4063", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Depoimento_Gerencia();
    }

    /**
     * Desativa um Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Desativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->depoimento_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_depoimento("I");

        $this->depoimento_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4062", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Depoimento_Gerencia();
    }

    /**
     * Ativa um Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Ativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->depoimento_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_depoimento("A");
        $this->depoimento_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4062", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Depoimento_Gerencia();
    }

    /**
     * Deleta um Depoimento
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Depoimento_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->depoimento_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_depoimento("D");
        $this->depoimento_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4062", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Depoimento_Gerencia();
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */

    public function Lista_Depoimentos() {
        
        $objetos = $this->depoimento_dao->get_Objs(" AND status_depoimento = 'A'", "data_depoimento DESC", 0, "");

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
