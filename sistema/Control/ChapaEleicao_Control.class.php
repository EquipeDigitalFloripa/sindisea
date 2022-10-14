<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

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
class ChapaEleicao_Control extends Control
{

    private $chapa_eleicao_dao;

    /**
     * Carrega o contrutor do pai.
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $post_request
     *            Parâmetros de _POST e _REQUEST
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
    public function __construct($post_request)
    {
        parent::__construct($post_request);
        $this->chapa_eleicao_dao = $this->config->get_DAO("ChapaEleicao");
    }

    /**
     * Mostra a lista de usuários, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function ChapaEleicao_Add_V()
    {
        $descricoes = $this->chapa_eleicao_dao->get_Descricao();
        $vw = new ChapaEleicao_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function ChapaEleicao_Add()
    {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new ChapaEleicao();

        $this->traducao->loadTraducao("3035", $this->post_request['idioma']);
        $objeto->set_nome($this->post_request['nome']);
        $objeto->set_id_eleicao($this->post_request['id_eleicao']);
        $objeto->set_status_chapa_eleicao('A');
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->chapa_eleicao_dao->Save($objeto);
        $this->ChapaEleicao_Add_V();
    }

    public function ChapaEleicao_Gerencia()
    {
        /*
         * ************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $condicao .= " and (status_chapa_eleicao = \"A\" or status_chapa_eleicao = \"I\")";
        $total_reg = $this->chapa_eleicao_dao->get_Total("$condicao");
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
        $ordem = "nome";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->chapa_eleicao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->chapa_eleicao_dao->get_Descricao();

        // CARREGA A VIEW E MOSTRA
        $vw = new ChapaEleicao_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    // fim do Usuario_Gerencia
    public function ChapaEleicao_Apaga()
    {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->chapa_eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_chapa_eleicao("D");
        $this->chapa_eleicao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->ChapaEleicao_Gerencia();
    }

    /**
     *
     * Desativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function ChapaEleicao_Desativa()
    {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->chapa_eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_chapa_eleicao("I");
        $this->chapa_eleicao_dao->Save($objeto);
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->ChapaEleicao_Gerencia();
    }

    /**
     *
     * Ativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function ChapaEleicao_Ativa()
    {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->chapa_eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_chapa_eleicao("A");
        $this->chapa_eleicao_dao->Save($objeto);
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->ChapaEleicao_Gerencia();
    }

    /**
     *
     * Altera dados de e-mail
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function ChapaEleicao_Altera()
    {
        $objeto = $this->chapa_eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_nome($this->post_request['nome']);
        $objeto->set_id_eleicao($this->post_request['id_eleicao']);
        $this->chapa_eleicao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3037", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->ChapaEleicao_Gerencia();
    }

    public function ChapaEleicao_Altera_V()
    {
        $objeto = $this->chapa_eleicao_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->chapa_eleicao_dao->get_Descricao();
        $vw = new ChapaEleicao_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Lista_Chapas($eleicao = "", $qtde = 999, $inicio = 0, $ordem = 'nome ASC')
    {
        if ($eleicao == "") {
            $objetos = $this->chapa_eleicao_dao->get_Objs(" AND status_chapa_eleicao = 'A'", $ordem, $inicio, $qtde);
        } else {
            $objetos = $this->chapa_eleicao_dao->get_Objs(" AND status_chapa_eleicao = 'A' AND id_eleicao = $eleicao", $ordem, $inicio, $qtde);
        }
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i ++;
        }

        return $dados;
    }

    public function Pega_Chapa($id_chapa)
    {
        $condicao = "AND id_chapa_eleicao = $id_chapa";

        $objetos = $this->chapa_eleicao_dao->get_Objs(" AND status_chapa_eleicao = 'A' $condicao", 'id_chapa_eleicao DESC', 0, 1);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i ++;
        }

        return $dados[0];
    }
}

// fim da classe
?>
