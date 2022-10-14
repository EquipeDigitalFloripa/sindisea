<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Centro, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Marcio Figueredo
 *
 * @package Control
 *
 */
class Centro_Control extends Control {

    private $centro_dao;

    /**
     * Carrega o contrutor do pai.
     *
     * @author Marcio Figueredo
     * @param Array $post_request Parâmetros de _POST e _REQUEST
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       parent::__construct();
     *       $config = new Config();
     *       $this->centro_dao = $config->get_DAO("Centro");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->centro_dao = $this->config->get_DAO("Centro");
    }

    /**
     * Mostra a lista de Centros
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Gerencia() {

        /* CONFIGURE FILTRO DE PESQUISA */
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 0) ? " AND (status_centro = 'A' OR status_centro = 'I')" :
                ((isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 1) ? " AND status_centro = 'A'" :
                ((isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 2) ? " AND status_centro = 'I'" : " AND status_centro = 'A'"));
        $condicao .= isset($this->post_request['pesquisa']) ? ' AND (descricao LIKE "%' . $this->post_request['pesquisa'] . '%")' : '';

        $total_reg = $this->centro_dao->get_Total("$condicao");

        /* INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE */
        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }

        /* CONFIGURE O NUMERO DE REGISTROS POR PAGINA */
        $pag_views = 10;

        /* CALCULA OS PARAMETROS DE PAGINACAO */
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "descricao ASC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->centro_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->centro_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Centro_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a View de Inclusão de Centros
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Add_V() {

        /* PEGA DESCIÇÕES */
        $descricoes = $this->centro_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Centro_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui novo Pacienta
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Add() {


        /* CARREGA DAO, SETA DADOS e SALVA */
        $objeto = new Centro();
        $objeto->set_descricao($this->post_request['descricao']);
        $objeto->set_status_centro("A");

        $this->centro_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("7035", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Centro_Add_V();
    }

    /**
     * Chama a View de Alteração de dados de Centros
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Altera_V() {

        /* PEGA OBJETO */
        $objeto = $this->centro_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->centro_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Centro_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados de Centros
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Altera() {

        /* CARREGA DAO, SETA DADOS e SALVA */
        $objeto = $this->centro_dao->loadObjeto($this->post_request['id']);

        $objeto->set_descricao($this->post_request['descricao']);

        $this->centro_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("7036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Centro_Gerencia();
    }

    /**
     * Ativa Centros
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Ativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->centro_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_centro("A");
        $this->centro_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("7037", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Centro_Gerencia();
    }

    /**
     * Desativa Centros
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Desativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->centro_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_centro("I");
        $this->centro_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("7037", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Centro_Gerencia();
    }

    /**
     * Deleta Centros
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Centro_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->centro_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_centro("D");
        $this->centro_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("7037", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Centro_Gerencia();
    }

    /**
     * Retorna dados de um Centro
     * 
     * @author Marcio Figueredo
     * @return array 
     */
    public function Pega_Centro($id_procedimento) {

        $objeto = $this->centro_dao->loadObjeto($id_procedimento);

        return $objeto->get_all_dados();
    }

    public function Listar_Centros($condicao) {

        $objetos = $this->centro_dao->get_Objs($condicao, "id_centro", 0, 999999);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {

            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return ($objetos != NULL) ? $dados : NULL;
    }

}

?>
