<?php

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Mailing, filho de Control
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

class CategoriaMailing_Control extends Control{


    private $categoria_mailing_dao;

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
     *       $this->mailing_dao = $config->get_DAO("Mailing");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->categoria_mailing_dao = $this->config->get_DAO("CategoriaMailing");


    }

    /**
     * Mostra a lista de usuários, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */

   public function CategoriaMailing_Add_V(){


        $vw         = new CategoriaMailing_Add_View($this->post_request,$objeto,$descricoes);
        $vw->showView();
    }

    public function CategoriaMailing_Add(){

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new CategoriaMailing();

          $this->traducao->loadTraducao("3005", $this->post_request['idioma']);
          $objeto->set_desc_tipo_mailing($this->post_request['categoria']);
          $objeto->set_status_tipo_mailing('A');
          $this->post_request['msg_tp'] = "sucesso";
          $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
          $this->categoria_mailing_dao->Save($objeto);
          $this->CategoriaMailing_Add_V();

            // GRAVA LOG
            //$this->log->gravaLog(13,$this->post_request['id_sessao'],$id_usuario_new);
    }

    public function CategoriaMailing_Gerencia(){
        /**************************************************************************************
        * CONFIGURE FILTRO DE PESQUISA
        ****************INICIO
        */
        $condicao   .= " and (status_tipo_mailing = \"A\" or status_tipo_mailing = \"I\")";
        $total_reg = $this->categoria_mailing_dao->get_Total("$condicao");
        /*
        *****************************************************************************************
        * CONFIGURE FILTRO DE PESQUISA
        ****************FIM
        */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if($this->post_request['pagina'] == ""){
            $this->post_request['pagina'] = 1;
        }

        /*
        *******************************************************************************************
        * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
        ****************INICIO
        */
        $pag_views  = 20;// número de registros por página
        /*
        *******************************************************************************************
        * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
        ****************FIM
        */

        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat        = $this->post_request['pagina'] -1; // NAO MODIFIQUE ESTA LINHA
        $inicio     = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
        *******************************************************************************************
        * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
        ****************INICIO
        */
        $ordem = "desc_tipo_mailing";
        /*
        *******************************************************************************************
        * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
        ****************FIM
        */

        // PEGA OBJETOS E DESCRICOES
        $objetos    = $this->categoria_mailing_dao->get_Objs($condicao,$ordem,$inicio,$pag_views);
        $descricoes = $this->categoria_mailing_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw         = new CategoriaMailing_Gerencia_View($this->post_request,$objetos,$descricoes,$total_reg,$pag_views);
        $vw->showView();

    }// fim do Usuario_Gerencia

    public function CategoriaMailing_Apaga(){

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_mailing_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_tipo_mailing("D");
        $this->categoria_mailing_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3006", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->CategoriaMailing_Gerencia();

    }

    /**
     *
     * Desativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function CategoriaMailing_Desativa(){

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_mailing_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_tipo_mailing("I");
        $this->categoria_mailing_dao->Save($objeto);
        $this->traducao->loadTraducao("3006", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->CategoriaMailing_Gerencia();
    }

    /**
     *
     * Ativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function CategoriaMailing_Ativa(){

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_mailing_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_tipo_mailing("A");
        $this->categoria_mailing_dao->Save($objeto);
        $this->traducao->loadTraducao("3006", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->CategoriaMailing_Gerencia();
    }

    /**
     *
     * Altera dados de e-mail
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function CategoriaMailing_Altera(){

        $objeto = $this->categoria_mailing_dao->loadObjeto($this->post_request['id']);
        $objeto->set_desc_tipo_mailing($this->post_request['desc_tipo_mailing']);
        $this->categoria_mailing_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3007", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->CategoriaMailing_Gerencia();

    }

    public function CategoriaMailing_Altera_V(){

        $objeto     = $this->categoria_mailing_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->categoria_mailing_dao->get_Descricao();
        $vw         = new CategoriaMailing_Altera_View($this->post_request,$objeto,$descricoes);
        $vw->showView();
    }

}// fim da classe

?>
