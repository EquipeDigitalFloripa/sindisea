<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade GrupoSMS, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2019-2022, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package Control
 */
class GrupoSMS_Control extends Control {

    private $grupo_sms_dao;

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
     *       $this->grupo_sms_dao = $config->get_DAO("Post");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);

        $this->grupo_sms_dao = $this->config->get_DAO("GrupoSMS");
    }

    /**
     * Mostra a lista de GrupoSMSs
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Gerencia() {

        /* CONFIGURA FILTRO DE PESQUISA */
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 1) ? ' AND status_grupo_sms = "A"' : ((isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 2) ? ' AND status_grupo_sms = "I"' : 'AND (status_grupo_sms = "A" OR status_grupo_sms = "I")');



        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->grupo_sms_dao->get_Total("$condicao");

        /* INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA - NAO MODIFIQUE */
        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }

        /* CONFIGURE O NUMERO DE REGISTROS POR PAGINA */
        $pag_views = 100; // número de registros por página

        /* CALCULA OS PARAMETROS DE PAGINACAO */
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "descricao_grupo_sms ASC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->grupo_sms_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->grupo_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new GrupoSMS_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de uma novo GrupoSMS
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Add_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->grupo_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new GrupoSMS_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui uma nova Notícia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Add() {

        /* CRIA OBJETO E SALVA DADOS */
        $objeto = new GrupoSMS();

        $objeto->set_descricao_grupo_sms($this->post_request['descricao_grupo_sms']);
        $objeto->set_data_cadastro($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_grupo_sms('A');

        $this->grupo_sms_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4011", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->GrupoSMS_Gerencia();
    }

    /**
     * Chama View para alteração de dados do GrupoSMS
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Altera_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $objeto = $this->grupo_sms_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->grupo_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new GrupoSMS_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados do GrupoSMS
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Altera() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->grupo_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_descricao_grupo_sms($this->post_request['descricao_grupo_sms']);

        $this->grupo_sms_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4012", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->GrupoSMS_Gerencia();
    }

    /**
     * Ativa um GrupoSMS
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Ativa() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->grupo_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_grupo_sms("A");

        $this->grupo_sms_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("4010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->GrupoSMS_Gerencia();
    }

    /**
     * Desativa um GrupoSMS
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Desativa() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->grupo_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_grupo_sms("I");

        $this->grupo_sms_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("4010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->GrupoSMS_Gerencia();
    }

    /**
     * Apaga um GrupoSMS
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function GrupoSMS_Apaga() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->grupo_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_grupo_sms("D");

        $this->grupo_sms_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("4010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->GrupoSMS_Gerencia();
    }

}

?>
