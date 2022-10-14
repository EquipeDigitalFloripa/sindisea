<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Portfolio, filho de Control
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
class Portfolio_Control extends Control {

    private $portfolio_dao;

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
     *       $this->portfolio_dao = $config->get_DAO("Portfolio");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->portfolio_dao = $this->config->get_DAO("Portfolio");
    }

    /**
     * Mostra a lista de Imagens do Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Gerencia() {

        /* CONFIGURA FILTRO DE PESQUISA */
        $pesquisa = (isset($this->post_request['pesquisa'])) ? "AND nome_portfolio LIKE '%" . $this->post_request['pesquisa'] . "%'" : "";
        $condicao = " AND (status_portfolio = \"A\" OR status_portfolio = \"I\") $pesquisa";


        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->portfolio_dao->get_Total("$condicao");

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
        $ordem = "id_portfolio ASC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->portfolio_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->portfolio_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Portfolio_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de um novo Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Add_V() {

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Portfolio_Add_View($this->post_request, "", "");
        $vw->showView();
    }

    /**
     * Inclui um novo Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Add() {

        $this->traducao->loadTraducao("2061", $this->post_request['idioma']);

        $ext_img_portfolio = substr(strrchr(trim($this->post_request['imagem_portfolio']['name']), '.'), 1);
        if ($ext_img_portfolio <> 'jpg' && $ext_img_portfolio <> 'JPG' && $ext_img_portfolio <> 'png' && $ext_img_portfolio <> 'PNG' && $ext_img_portfolio <> 'jpeg' && $ext_img_portfolio <> 'JPEG') {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36()); //alterar            
            $this->Portfolio_Add_V();
        } else {
            $diretorio = "arquivos/img_portfolio/";

            $objeto = new Portfolio();
            $objeto->set_nome_portfolio($this->post_request['nome_portfolio']);
            $objeto->set_site_portfolio($this->post_request['site_portfolio']);
            $objeto->set_ext_img_portfolio($ext_img_portfolio);
            $objeto->set_status_portfolio("A");

            $new_id_cliente = $this->portfolio_dao->Save($objeto);

            $nome_atual = $new_id_cliente . "." . $ext_img_portfolio;
            if (!copy($this->post_request['imagem_portfolio']['tmp_name'], $diretorio . $nome_atual)) {

                //SE NÃO COPIAR IMAGEM, APAGA CLIENTE INSERIDO
                $obj = $this->portfolio_dao->loadObjeto($this->post_request['id']);
                $obj->set_status_portfolio("D");
                $this->portfolio_dao->Save($obj);

                $this->post_request['msg_tp'] = "erro";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
            } else {
                $this->image->resizeImage($diretorio, $nome_atual, 900);
                $this->post_request['msg_tp'] = "sucesso";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
            }
            $this->Portfolio_Gerencia();
        }
    }

    /**
     * Chama View para alteração de dados do Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Altera_V() {

        /* PEGA OBJTO E DESCRIÇÕES */
        $objeto = $this->portfolio_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->portfolio_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Portfolio_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados do Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Altera() {

        /* CARREGA DAO, SETA DADOS e SALVA */
        $objeto = $this->portfolio_dao->loadObjeto($this->post_request['id']);

        $objeto->set_nome_portfolio($this->post_request['nome_portfolio']);
        $objeto->set_site_portfolio($this->post_request['site_portfolio']);

        $this->portfolio_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("2062", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Portfolio_Gerencia();
    }

    /**
     * Chama View para alteração da Imagem do Produto
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Altera_Imagem_V() {

        /* PEGA OBJTO E DESCRIÇÕES */
        $objeto = $this->portfolio_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->portfolio_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Portfolio_Altera_Imagem_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera imagem do Produto
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Altera_Imagem() {

        $this->traducao->loadTraducao("2063", $this->post_request['idioma']);

        $ext_img_portfolio = substr(strrchr(trim($this->post_request['imagem_portfolio']['name']), '.'), 1);
        if ($ext_img_portfolio <> 'jpg' && $ext_img_portfolio <> 'JPG' && $ext_img_portfolio <> 'png' && $ext_img_portfolio <> 'PNG' && $ext_img_portfolio <> 'jpeg' && $ext_img_portfolio <> 'JPEG') {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36()); //alterar            
            $this->Portfolio_Add_V();
        } else {

            $diretorio = "arquivos/img_portfolio/";

            $objeto = $this->portfolio_dao->loadObjeto($this->post_request['id']);
            $objeto->set_ext_img($ext_img_portfolio);

            $this->portfolio_dao->Save($objeto);

            $nome_atual = $objeto->get_id_entregador() . "." . $ext_img_portfolio;
            if (!copy($this->post_request['imagem_portfolio']['tmp_name'], $diretorio . $nome_atual)) {
                $this->post_request['msg_tp'] = "erro";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
            } else {
                $this->image->resizeImage($diretorio, $nome_atual, 900);
                $this->post_request['msg_tp'] = "sucesso";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
            }
            $this->Portfolio_Gerencia();
        }
    }

    /**
     * Desativa um Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Desativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->portfolio_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_portfolio("I");

        $this->portfolio_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("2060", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Portfolio_Gerencia();
    }

    /**
     * Ativa um Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Ativa() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->portfolio_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_portfolio("A");
        $this->portfolio_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("2060", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Portfolio_Gerencia();
    }

    /**
     * Deleta um Portfolio
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Portfolio_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->portfolio_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_portfolio("D");
        $this->portfolio_dao->Save($objeto);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("2060", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Portfolio_Gerencia();
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */

    public function Lista_Imagens_Portfolio($condicao = "", $ordem = "id_portfolio ASC", $inicio = 0, $qtde = 100) {

        $objetos = $this->portfolio_dao->get_Objs("$condicao", "$ordem", $inicio, $qtde);

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
