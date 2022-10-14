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

class Banner_Control extends Control {


    private $banner_dao;

    /**
     * Carrega o contrutor do pai.
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $post_request Par�metros de _POST e _REQUEST
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
        $this->banner_dao = $this->config->get_DAO("Banner");

    }

    /**
     * Mostra a lista de usu�rios, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */

    public function Banner_Gerencia() {
        /**************************************************************************************
        * CONFIGURE FILTRO DE PESQUISA
        ****************INICIO
        */
        $pesquisa  = $this->post_request['pesquisa'];
        if($pesquisa != "") {
            $condicao   = " and regiao <> 0 and nome LIKE '%$pesquisa%' ";
        }else {
            $condicao   = " and regiao <> 0 ";
        }
        $total_reg = $this->banner_dao->get_Total("$condicao");

        /*
        *****************************************************************************************
        * CONFIGURE FILTRO DE PESQUISA
        ****************FIM
        */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
        *******************************************************************************************
        * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
        ****************INICIO
        */
        $pag_views  = 15;// n�mero de registros por p�gina
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
        $ordem = "id_banner";
        /*
        *******************************************************************************************
        * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
        ****************FIM
        */        

        // PEGA OBJETOS E DESCRICOES
        $objetos    = $this->banner_dao->get_Objs($condicao,$ordem,$inicio,$pag_views);
        $descricoes = $this->banner_dao->get_Descricao();
        //print_r($descricoes);

        //CARREGA A VIEW E MOSTRA
        $vw         = new Banner_Gerencia_View($this->post_request,$objetos,$descricoes,$total_reg,$pag_views);
        $vw->showView();

    }// fim do Usuario_Gerencia

    /**
     *
     * Deleta E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Banner_Apaga() {

    // CARREGA DAO, SETA STATUS e SALVA
        $diretorio = "arquivos/imagens/";
        $objeto = $this->banner_dao->loadObjeto($this->post_request['id']);
        $ext = $objeto->get_ext();
        $nome = $this->post_request['id'].".".$ext;
        unlink($diretorio.$nome);
        $objeto->set_status_banner("D");
        $this->banner_dao->Save($objeto);
        $this->atualizaListaImagens();

        // GRAVA LOG
        //$this->log->gravaLog(10,$this->post_request['id_sessao'],$this->post_request['id']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3022", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Banner_Gerencia();

    }

    /**
     *
     * Chama a View de Inclus�o de E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Banner_Add_V() {

    // Pega as descri��es
        $descricoes = $this->banner_dao->get_Descricao();
        //CARREGA A VIEW E MOSTRA
        $vw         = new Banner_Add_View($this->post_request,$objeto,$descricoes);
        $vw->showView();
    }

    public function Banner_Altera_Img_V(){

        $objeto     = $this->banner_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->banner_dao->get_Descricao();
        $vw         = new Banner_Altera_Img_View($this->post_request,$objeto,$descricoes);
        $vw->showView();

    }

    public function Banner_Altera_Img(){

        $largura = 300;
        $altura = 57;
        $objeto = $this->banner_dao->loadObjeto($this->post_request['id']);
        $diretorio = "arquivos/banners/";
        $ext        = trim(strtolower(substr($this->post_request['imagem']['name'],-3)));
        $this->traducao->loadTraducao("3014", $this->post_request['idioma']);
        if ($ext <> 'jpg' && $ext <> 'gif' && $ext <> 'png') {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());//alterar
            $this->Banner_Altera_Img_V();
        } else {
            $objeto->set_ext($ext);
            $id_banner = $objeto->get_id_banner();
            $nome_atual = "$id_banner".".".$ext;
            if (!copy($this->post_request['imagem']['tmp_name'],$diretorio.$nome_atual)) {
                $this->post_request['msg_tp'] = "erro";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
            } else {

                //$red = $this->image->forceResize($diretorio,$nome_atual,$largura,$altura);
                $this->banner_dao->save($objeto);
                $this->post_request['msg_tp'] = "sucesso";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
            }
            $this->Banner_Gerencia();
        }
    }

    public function Banner_Altera_Link(){

        $objeto = $this->banner_dao->loadObjeto($this->post_request['id']);
        $objeto->set_link($this->post_request['link']);
        $this->banner_dao->Save($objeto);
        $this->traducao->loadTraducao("3062", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Banner_Gerencia();
    }

    public function Banner_Altera_Link_V(){

        $objeto     = $this->banner_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->banner_dao->get_Descricao();
        $vw         = new Banner_Altera_Link_View($this->post_request,$objeto,$descricoes);
        $vw->showView();
    }

    public function Banner_Publicar(){

        $objeto = $this->banner_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_banner("A");
        $this->banner_dao->Save($objeto);
        $this->traducao->loadTraducao("3060", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Banner_Gerencia();
    }

    public function Banner_Despublicar(){

        $objeto = $this->banner_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_banner("I");
        $this->banner_dao->Save($objeto);
        $this->traducao->loadTraducao("3060", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Banner_Gerencia();
    }

    /**
     *
     * Inclui novo e-mail
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Banner_Add() {


    // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Banner();

        $diretorio = "arquivos/imagens/";
        $ext        = trim(strtolower(substr($this->post_request['banner']['name'],-3)));

        $this->traducao->loadTraducao("3021", $this->post_request['idioma']);

        if ($ext <> 'jpg' && $ext <> 'gif' && $ext <> 'png') {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            $this->Banner_Add_V();
        } else {
            $objeto->set_nome($this->post_request['nome']);
            $objeto->set_ext($ext);
            $objeto->set_status_banner('A');
            $id_banner_item_new = $this->banner_dao->Save($objeto);
            $nome_atual = "$id_banner_item_new".".".$ext;
            if (!copy($this->post_request['banner']['tmp_name'],$diretorio.$nome_atual)) {
                $this->post_request['msg_tp'] = "erro";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
                $this->banner_dao->Delete($id_banner_item_new);
            } else {
                //$red = $this->image->resizeImage($diretorio,$nome_atual,$this->post_request['tamanho']);
                $this->post_request['msg_tp'] = "sucesso";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
            }
            // GRAVA LOG
            //$this->log->gravaLog(13,$this->post_request['id_sessao'],$id_usuario_new);

            // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
            $this->Banner_Add_V();
        }
    }

    //------------------------------- Site --------------------------------------------------

    public function Pega_Banner($regiao){
            $banner = $this->banner_dao->get_Objs(" and regiao = \"$regiao\"","id_banner",0,1);
            $dados = $banner[0]->get_all_dados();
            return $dados;
    }

}// fim da classe

?>
