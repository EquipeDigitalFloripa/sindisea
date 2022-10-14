<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Usuario, filho de Control
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package Control
 *
 */
class Usuario_Control extends Control {

    private $usuario_dao;

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
     *       $this->usuario_dao = $config->get_DAO("Usuario");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->usuario_dao = $this->config->get_DAO("Usuario");
    }

    /**
     *
     * Mostra a lista de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Gerencia() {
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $pesquisa = $this->post_request['pesquisa'];
        if ($pesquisa != "") {
            $condicao .= " and (status_usuario = \"A\" or status_usuario = \"I\") and nome_usuario LIKE '%$pesquisa%' ";
        } else {
            $condicao .= " and (status_usuario = \"A\" or status_usuario = \"I\")";
        }

        $total_reg = $this->usuario_dao->get_Total("$condicao");
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************FIM
         */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 15; // número de registros por página
        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************FIM
         */

        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "nome_usuario";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->usuario_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->usuario_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

// fim do Usuario_Gerencia

    /**
     *
     * Mostra a lista de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Ger_Solicitante_V() {
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $pesquisa = $this->post_request['pesquisa'];
        if ($pesquisa != "") {
            $condicao .= " and status_usuario = \"P\" and nome_usuario LIKE '%$pesquisa%' ";
        } else {
            $condicao .= " and status_usuario = \"P\"";
        }

        $total_reg = $this->usuario_dao->get_Total("$condicao");
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************FIM
         */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 15; // número de registros por página
        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************FIM
         */

        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "data_cadastro";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->usuario_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->usuario_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Ger_Solicitante_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

// fim

    /**
     *
     * Desativa Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_usuario("I");
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(11, $this->post_request['id_sessao'], $this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Usuario_Gerencia();
    }

    /**
     *
     * Ativa Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_usuario("A");
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(10, $this->post_request['id_sessao'], $this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Usuario_Gerencia();
    }

    /**
     *
     * Deleta Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_usuario("D");
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(10, $this->post_request['id_sessao'], $this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Usuario_Gerencia();
    }

    /**
     *
     * Deleta Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Apaga_Solicitacao() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_usuario("D");
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(10, $this->post_request['id_sessao'], $this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2047", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Usuario_Ger_Solicitante_V();
    }

    /**
     *
     * Altera senha de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Pass() {

        // CARREGA DAO, SETA SENHA e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $enc = new Encripta();
        $senha = $enc->pw_encode($this->post_request['senha1']);
        $objeto->set_senha_usuario("$senha");
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(15, $this->post_request['id_sessao'], $this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2021", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Usuario_Gerencia();
    }

    /**
     *
     * Chama a View de Alteração de senha de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Pass_V() {

        // PEGA OBJETO
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Pass_View($this->post_request, $objeto);
        $vw->showView();
    }

    /**
     *
     * Altera dados de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Altera() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_nome_usuario($this->post_request['nome_usuario']);
        $objeto->set_perm_usuario($this->post_request['perm_usuario']);
        $objeto->set_login_usuario($this->post_request['login_usuario']);
        $objeto->set_email_usuario($this->post_request['email_usuario']);
        $objeto->set_endereco_usuario($this->post_request['endereco_usuario']);
        $objeto->set_bairro_usuario($this->post_request['bairro_usuario']);
        $objeto->set_complemento_end_usuario($this->post_request['complemento_end_usuario']);
        $objeto->set_cep_usuario($this->post_request['cep_usuario']);
        $objeto->set_cidade_usuario($this->post_request['cidade_usuario']);
        $objeto->set_pais_residencia_usuario($this->post_request['pais_residencia_usuario']);
        $objeto->set_telefone_usuario($this->post_request['telefone_usuario']);
        $objeto->set_website_usuario($this->post_request['website_usuario']);
        $objeto->set_nacionalidade_usuario($this->post_request['nacionalidade_usuario']);
        $objeto->set_naturalidade_usuario($this->post_request['naturalidade_usuario']);
        $objeto->set_instituicao_usuario($this->post_request['instituicao_usuario']);
        $objeto->set_local_instituicao_usuario($this->post_request['local_instituicao_usuario']);
        $objeto->set_areas_interesse_usuario($this->post_request['areas_interesse_usuario']);
        $objeto->set_areas_especialidade_usuario($this->post_request['areas_especialidade_usuario']);
        if ($this->post_request['autoriza_public_email'] == "S") {
            $aut = "S";
        } else {
            $aut = "N";
        }
        $objeto->set_autoriza_public_email("$aut");
        $objeto->set_outros_dados_usuario($this->post_request['outros_dados_usuario']);
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(14, $this->post_request['id_sessao'], $this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2022", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Usuario_Gerencia();
    }

    /**
     *
     * Chama a View de Alteração de dados de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Altera_V() {

        // PEGA OBJETO
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->usuario_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     *
     * Chama a View de Análise Solicitação de Adesão
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Analisa_V() {

        // PEGA OBJETO
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->usuario_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Analisa_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     *
     * Chama a View de Inclusão de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Add_V() {

        // Pega as descrições
        $descricoes = $this->usuario_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     *
     * Inclui novo Usuário
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Usuario();
        $objeto->set_nome_usuario($this->post_request['nome_usuario']);
        $objeto->set_perm_usuario($this->post_request['perm_usuario']);
        $objeto->set_login_usuario($this->post_request['login_usuario']);
        $objeto->set_email_usuario($this->post_request['email_usuario']);
        $objeto->set_endereco_usuario($this->post_request['endereco_usuario']);
        $objeto->set_bairro_usuario($this->post_request['bairro_usuario']);
        $objeto->set_complemento_end_usuario($this->post_request['complemento_end_usuario']);
        $objeto->set_cep_usuario($this->post_request['cep_usuario']);
        $objeto->set_cidade_usuario($this->post_request['cidade_usuario']);
        $objeto->set_pais_residencia_usuario($this->post_request['pais_residencia_usuario']);
        $objeto->set_telefone_usuario($this->post_request['telefone_usuario']);
        $objeto->set_website_usuario($this->post_request['website_usuario']);
        $objeto->set_nacionalidade_usuario($this->post_request['nacionalidade_usuario']);
        $objeto->set_naturalidade_usuario($this->post_request['naturalidade_usuario']);
        $objeto->set_instituicao_usuario($this->post_request['instituicao_usuario']);
        $objeto->set_local_instituicao_usuario($this->post_request['local_instituicao_usuario']);
        $objeto->set_areas_interesse_usuario($this->post_request['areas_interesse_usuario']);
        $objeto->set_areas_especialidade_usuario($this->post_request['areas_especialidade_usuario']);
        if ($this->post_request['autoriza_public_email'] == "S") {
            $aut = "S";
        } else {
            $aut = "N";
        }
        $objeto->set_autoriza_public_email("$aut");
        $objeto->set_outros_dados_usuario($this->post_request['outros_dados_usuario']);

        $enc = new Encripta();
        $senha = $enc->pw_encode($this->post_request['senha_usuario']);
        $objeto->set_senha_usuario("$senha");

        $objeto->set_status_usuario("A");
        $objeto->set_data_cadastro($this->data->get_dataFormat("NOW", "", "BD"));

        $id_usuario_new = $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(13, $this->post_request['id_sessao'], $id_usuario_new);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2024", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Usuario_Add_V();
    }

    /**
     *
     * Altera senha do Usuário Corrente
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Mypass() {

        // CARREGA DAO, SETA SENHA e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $enc = new Encripta();

        if ($enc->pw_check($this->post_request['senha_atual'], $objeto->get_senha_usuario())) {

            $senha = $enc->pw_encode($this->post_request['senha1']);
            $objeto->set_senha_usuario("$senha");
            $this->usuario_dao->Save($objeto);

            // GRAVA LOG
            $this->log->gravaLog(3, $this->post_request['id_sessao'], $this->post_request['id']);

            // CONFIGURA MENSAGEM DE SUCESSO
            $this->traducao->loadTraducao("2025", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            // CONFIGURA MENSAGEM DE ERRO
            $this->traducao->loadTraducao("2025", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        }

        $this->Usuario_Mypass_V();
    }

    /**
     *
     * Chama a View de Alteração de senha do Usuário Corrente
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Mypass_V() {

        // PEGA OBJETO
        $id_usuario = $this->sessao->get_id_usuario();
        $objeto = $this->usuario_dao->loadObjeto($id_usuario);
        $this->post_request['id'] = $id_usuario;

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Mypass_View($this->post_request, $objeto);
        $vw->showView();
    }

    /**
     *
     * Altera dados do Usuário Corrente
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Mydata() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_nome_usuario($this->post_request['nome_usuario']);
        $objeto->set_perm_usuario($this->post_request['perm_usuario']);
        $objeto->set_login_usuario($this->post_request['login_usuario']);
        $objeto->set_email_usuario($this->post_request['email_usuario']);
        $objeto->set_endereco_usuario($this->post_request['endereco_usuario']);
        $objeto->set_bairro_usuario($this->post_request['bairro_usuario']);
        $objeto->set_complemento_end_usuario($this->post_request['complemento_end_usuario']);
        $objeto->set_cep_usuario($this->post_request['cep_usuario']);
        $objeto->set_cidade_usuario($this->post_request['cidade_usuario']);
        $objeto->set_pais_residencia_usuario($this->post_request['pais_residencia_usuario']);
        $objeto->set_telefone_usuario($this->post_request['telefone_usuario']);
        $objeto->set_website_usuario($this->post_request['website_usuario']);
        $objeto->set_nacionalidade_usuario($this->post_request['nacionalidade_usuario']);
        $objeto->set_naturalidade_usuario($this->post_request['naturalidade_usuario']);
        $objeto->set_instituicao_usuario($this->post_request['instituicao_usuario']);
        $objeto->set_local_instituicao_usuario($this->post_request['local_instituicao_usuario']);
        $objeto->set_areas_interesse_usuario($this->post_request['areas_interesse_usuario']);
        $objeto->set_areas_especialidade_usuario($this->post_request['areas_especialidade_usuario']);
        if ($this->post_request['autoriza_public_email'] == "S") {
            $aut = "S";
        } else {
            $aut = "N";
        }
        $objeto->set_autoriza_public_email("$aut");
        $objeto->set_outros_dados_usuario($this->post_request['outros_dados_usuario']);
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        $this->log->gravaLog(2, $this->post_request['id_sessao'], $this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2022", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Usuario_Mydata_V();
    }

    /**
     *
     * Chama a View de Alteração de dados do Usuário Corrente
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Mydata_V() {

        // PEGA OBJETO
        $id_usuario = $this->sessao->get_id_usuario();
        $objeto = $this->usuario_dao->loadObjeto($id_usuario);
        $this->post_request['id'] = $id_usuario;
        $descricoes = $this->usuario_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Usuario_Mydata_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     *
     * Autoriza Solicitações
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Autoriza() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_usuario("A");
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        //$this->log->gravaLog(10,$this->post_request['id_sessao'],$this->post_request['id']);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2048", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Usuario_Ger_Solicitante_V();
    }

    /**
     *
     * Autoriza Solicitações
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Usuario_Nega() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->usuario_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_usuario("N");
        $this->usuario_dao->Save($objeto);

        // GRAVA LOG
        //$this->log->gravaLog(10,$this->post_request['id_sessao'],$this->post_request['id']);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2048", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Usuario_Ger_Solicitante_V();
    }

//---------------------------------------SITE


    public function loadUsuario($id_usuario) {
        $objeto[0] = $this->usuario_dao->loadObjeto($id_usuario);
        $objeto[1] = $this->usuario_dao->get_Descricao();
        return $objeto;
    }

    public function site_lista_autores($post_request) {
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */

        $condicao .= " and status_usuario = \"A\" and (perm_usuario = \"A\" or perm_usuario = \"D\" or perm_usuario = \"C\")";
        $condicao .= " and id_usuario in (select id_autor from tb_artigo)";

        $total_reg = $this->usuario_dao->get_Total($condicao);

        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************FIM
         */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($post_request['pagina'] == "") {
            $post_request['pagina'] = 1;
        }

        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 10; // número de registros por página
        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************FIM
         */

        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "nome_usuario";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->usuario_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->usuario_dao->get_Descricao();

        $retorno['objetos'] = $objetos;
        $retorno['descricoes'] = $descricoes;
        $retorno['total_reg'] = $total_reg;
        $retorno['pag_views'] = $pag_views;

        return $retorno;
    }

// fim

    public function site_pesquisa_usuarios($post_request) {
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $pesquisa = trim($this->post_request['pesquisa']);

        if ($pesquisa != "") {
            $condicao .= " and nome_usuario LIKE '%$pesquisa%'";
        }

        if ($pesquisa == "") {
            $condicao .= " and status_usuario = \"Z\""; // condição absurda pra nao voltar nenhum resuldado
        } else {
            $condicao .= " and status_usuario = \"A\" and (perm_usuario = \"A\" or perm_usuario = \"D\" or perm_usuario = \"C\")";
            $condicao .= " and id_usuario in (select id_autor from tb_artigo)";
        }


        $total_reg = $this->usuario_dao->get_Total($condicao);

        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************FIM
         */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($post_request['pagina'] == "") {
            $post_request['pagina'] = 1;
        }

        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 1; // número de registros por página
        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************FIM
         */

        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "nome_usuario";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->usuario_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->usuario_dao->get_Descricao();

        $retorno['objetos'] = $objetos;
        $retorno['descricoes'] = $descricoes;
        $retorno['total_reg'] = $total_reg;
        $retorno['pag_views'] = $pag_views;

        return $retorno;
    }

// fim
}

// fim da classe
?>
