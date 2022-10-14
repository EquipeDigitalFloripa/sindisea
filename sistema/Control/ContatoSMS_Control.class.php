<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Aviso, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2019-2022, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package Control
 */
class ContatoSMS_Control extends Control {

    private $contato_sms_dao;

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
     *       $this->contato_sms_dao = $config->get_DAO("Post");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);

        $this->contato_sms_dao = $this->config->get_DAO("ContatoSMS");
    }

    /**
     * Mostra a lista de Avisos
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Gerencia() {

        /* CONFIGURA FILTRO DE PESQUISA */
        $condicao = ' AND (status_contato = "A" OR status_contato = "I")';
        $condicao .= (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] > 0) ? ' AND id_grupo_sms = ' . $this->post_request['selecao01'] . '' : '';
        $condicao .= (isset($this->post_request['pesquisa']) && trim($this->post_request['pesquisa']) != "" && !is_numeric($this->post_request['pesquisa'])) ? ' AND nome_contato LIKE "%' . $this->post_request['pesquisa'] . '%"' : '';
        $condicao .= (isset($this->post_request['pesquisa']) && is_numeric($this->post_request['pesquisa'])) ? ' AND telefone_contato LIKE "%' . $this->post_request['pesquisa'] . '%"' : '';
        
        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->contato_sms_dao->get_Total("$condicao");

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
        $ordem = "data_cadastro DESC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->contato_sms_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->contato_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new ContatoSMS_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de uma novo Aviso
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Add_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->contato_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new ContatoSMS_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui uma nova Notícia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Add() {

        /* CRIA OBJETO E SALVA DADOS */
        $objeto = new ContatoSMS();

        $objeto->set_id_grupo_sms($this->post_request['id_grupo_sms']);
        $objeto->set_telefone_contato(preg_replace("/[^0-9]/", "", $this->post_request['telefone_contato']));        
        $objeto->set_nome_contato(isset($this->post_request['nome_contato']) ? $this->post_request['nome_contato'] : "Anonimo");
        $objeto->set_data_cadastro($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_contato('A');

        $this->contato_sms_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4006", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->ContatoSMS_Gerencia();
    }

    /**
     * Chama View para alteração de dados do Aviso
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Altera_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $objeto = $this->contato_sms_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->contato_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new ContatoSMS_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados do Aviso
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Altera() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->contato_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_id_grupo_sms($this->post_request['id_grupo_sms']);
        $objeto->set_telefone_contato(preg_replace("/[^0-9]/", "", $this->post_request['telefone_contato']));        
        $objeto->set_nome_contato(isset($this->post_request['nome_contato']) ? $this->post_request['nome_contato'] : "Anonimo");

        $this->contato_sms_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("4007", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->ContatoSMS_Gerencia();
    }

    /**
     * Ativa um Aviso
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Ativa() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->contato_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_contato("A");

        $this->contato_sms_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("4005", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->ContatoSMS_Gerencia();
    }

    /**
     * Desativa um Aviso
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Desativa() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->contato_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_contato("I");

        $this->contato_sms_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("4005", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->ContatoSMS_Gerencia();
    }

    /**
     * Apaga um Aviso
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function ContatoSMS_Apaga() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->contato_sms_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_contato("D");

        $this->contato_sms_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("4005", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->ContatoSMS_Gerencia();
    }

}

?>
