<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade arquivo, filho de Control
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Marcela Santana
 *
 *
 * @package Control
 *
 */
class TipoMovimentacao_Control extends Control {

    private $tipo_movimentacao_dao;

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
     *       $this->arquivo_dao = $config->get_DAO("arquivo");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->tipo_movimentacao_dao = $this->config->get_DAO("TipoMovimentacao");
    }

    /**
     * Mostra a lista de usuários, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function TipoMovimentacao_Add_V() {


        $vw = new TipoMovimentacao_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function TipoMovimentacao_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new TipoMovimentacao();

        $this->traducao->loadTraducao("5086", $this->post_request['idioma']);
        $objeto->set_descricao($this->post_request['descricao']);
//        $objeto->set_rd($this->post_request['rd']);
        $objeto->set_status_tipo_movimentacao('A');

        $this->tipo_movimentacao_dao->Save($objeto);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->TipoMovimentacao_Add_V();
    }

    public function TipoMovimentacao_Gerencia() {
        /*         * ************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 0) ? " AND (status_tipo_movimentacao = 'A' OR status_tipo_movimentacao = 'I')" :
                ((isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 1) ? " AND status_tipo_movimentacao = 'A'" :
                ((isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 2) ? " AND status_tipo_movimentacao = 'I'" : " AND status_tipo_movimentacao = 'A'"));
        
//        $condicao .= (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 'r') ? " AND (rd = 'r')" : "";
//        $condicao .= (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 'd') ? " AND (rd = 'd')" : "";
        
        $condicao .= isset($this->post_request['pesquisa']) ? ' AND (descricao LIKE "%' . $this->post_request['pesquisa'] . '%")' : '';
        
        $total_reg = $this->tipo_movimentacao_dao->get_Total("$condicao");
        /*
         * ****************************************************************************************
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
        $pag_views = 20; // número de registros por página
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
        $ordem = "descricao";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->tipo_movimentacao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
//        print_r($objetos); die;
        $descricoes = $this->tipo_movimentacao_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new TipoMovimentacao_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

// fim do Usuario_Gerencia

    public function TipoMovimentacao_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->tipo_movimentacao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_tipo_movimentacao("D");
        $this->tipo_movimentacao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5087", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->TipoMovimentacao_Gerencia();
    }

    /**
     *
     * Desativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function TipoMovimentacao_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->tipo_movimentacao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_tipo_movimentacao("I");
        $this->tipo_movimentacao_dao->Save($objeto);
        $this->traducao->loadTraducao("5087", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->TipoMovimentacao_Gerencia();
    }

    /**
     *
     * Ativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function TipoMovimentacao_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->tipo_movimentacao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_tipo_movimentacao("A");
        $this->tipo_movimentacao_dao->Save($objeto);
        $this->traducao->loadTraducao("5087", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->TipoMovimentacao_Gerencia();
    }

    /**
     *
     * Altera dados de e-mail
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function TipoMovimentacao_Altera() {

        $objeto = $this->tipo_movimentacao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_descricao($this->post_request['descricao']);
//        $objeto->set_rd($this->post_request['rd']);
        $this->tipo_movimentacao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5088", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->TipoMovimentacao_Gerencia();
    }

    public function TipoMovimentacao_Altera_V() {

        $objeto = $this->tipo_movimentacao_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->tipo_movimentacao_dao->get_Descricao();
        $vw = new TipoMovimentacao_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Lista_TipoMovimentacoes($qtde = 999, $inicio = 0, $ordem = 'descricao ASC') {

        $objetos = $this->tipo_movimentacao_dao->get_Objs(" AND status_tipo_movimentacao = 'A'", $ordem, $inicio, $qtde);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }

    public function Pega_TipoMovimentacao($id_tipo_movimentacao, $descricao = "") {

        if ($id_tipo_movimentacao != 0) {
            $condicao = "AND id_tipo_movimentacao = $id_tipo_movimentacao";
        } else {
            $condicao = "AND descricao = '$descricao'";
        }

        $objetos = $this->tipo_movimentacao_dao->get_Objs(" AND status_tipo_movimentacao = 'A' $condicao", 'id_tipo_movimentacao DESC', 0, 1);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados[0];
    }

}

// fim da classe
?>
