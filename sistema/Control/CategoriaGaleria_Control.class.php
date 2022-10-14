<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade CategoriaGaleria
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Marcela Santana
 *
 * @package Control
 *
 */
class CategoriaGaleria_Control extends Control {

    private $categoria_galeria_dao;

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
        $this->categoria_galeria_dao = $this->config->get_DAO("CategoriaGaleria");
    }

    /**
     * Chama a view com a lista de Categorias a serem gerenciadas
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function CategoriaGaleria_Gerencia() {

        /**********************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $condicao .= " and (status_categoria = \"A\" or status_categoria = \"I\")";
        $total_reg = $this->categoria_galeria_dao->get_Total("$condicao");

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
         * *********************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 20; // número de registros por página
        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * *********************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "nome_categoria";


        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->categoria_galeria_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->categoria_galeria_dao->get_Descricoes();

        //CARREGA A VIEW E MOSTRA
        $vw = new CategoriaGaleria_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a view de inclusão de categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function CategoriaGaleria_Add_V() {

        $vw = new CategoriaGaleria_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa de inclusão da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function CategoriaGaleria_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new CategoriaGaleria();

        $this->traducao->loadTraducao("4035", $this->post_request['idioma']);
        $objeto->set_nome_categoria($this->post_request['categoria']);
        $objeto->set_status_categoria('A');

        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->categoria_galeria_dao->Save($objeto);
        $this->CategoriaGaleria_Add_V();
    }

    /**
     * Chama a view de alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function CategoriaGaleria_Altera_V() {

        $objeto = $this->categoria_galeria_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->categoria_galeria_dao->get_Descricoes();

        $vw = new CategoriaGaleria_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function CategoriaGaleria_Altera() {

        $objeto = $this->categoria_galeria_dao->loadObjeto($this->post_request['id']);

        $objeto->set_nome_categoria($this->post_request['nome_categoria']);

        $update = $this->categoria_galeria_dao->Save($objeto);

        $this->traducao->loadTraducao("4033", $this->post_request['idioma']);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        if ($update) {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        }
        $this->CategoriaGaleria_Gerencia();
    }

    /**
     * Executa a exclusão de uma categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function CategoriaGaleria_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_galeria_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria("D");

        $apaga = $this->categoria_galeria_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);

        if ($apaga) {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        }
        $this->CategoriaGaleria_Gerencia();
    }

    /**
     * Aesativada uma categoria que estava ativada
     *
     * @return void
     */
    public function CategoriaGaleria_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_galeria_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria("I");

        $this->categoria_galeria_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->CategoriaGaleria_Gerencia();
    }

    /**
     * Ativa uma categoria que estava desativada
     *
     * @return void
     */
    public function CategoriaGaleria_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_galeria_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria("A");

        $this->categoria_galeria_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("4034", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->CategoriaGaleria_Gerencia();
    }

// ---------------------- SITE -------------------------------------------------

    /**
     * Pega a categoria equivalente ao ID passado pelo parámetro
     * 
     * @param int $id_categoria ID da categoria
     * @return Array Vetor com dados da categoria selecionada
     */
    public function Pega_Categoria($id_categoria) {

        $objeto = $this->categoria_galeria_dao->get_Objs(" AND id_categoria = $id_categoria AND status_categoria = 'A'", "nome_categoria", 0, 1);

        $dados = array();

        if (count($objeto) > 0) {
            $dados = $objeto[0]->get_all_dados();
        } else {
            $dados = null;
        }
        return $dados;
    }

    /**
     * Lista as categorias de galeria
     *
     * @param boolean $exibir Exibir lista completa ou somente os que possuem post
     * @param int $id_categoria Retira da lista
     * @return Array Arry com as categorias e seus dados
     */
    public function Lista_Categorias($exibir = true, $id_categoria = 0) {

        $cond = "";
        // Não lista as categorias que não tem galeria
        if ($exibir != true) {
            $cond .= "AND (SELECT COUNT(*) FROM tb_galeria p WHERE p.status_galeria = 'A' AND p.id_categoria_galeria = id_categoria) > 0";
        }

        $cond .= $id_categoria > 0 ? "AND id_categoria != '$id_categoria'" : "";

        $objetos = $this->categoria_galeria_dao->get_Objs("$cond", "nome_categoria ASC", 0, 1000);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

}
