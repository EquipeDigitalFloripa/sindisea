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
class CategoriaArquivo_Control extends Control {

    private $categoria_arquivo_dao;

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
        $this->categoria_arquivo_dao = $this->config->get_DAO("CategoriaArquivo");
    }

    /**
     * Mostra a lista de usuários, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function CategoriaArquivo_Add_V() {


        $vw = new CategoriaArquivo_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function CategoriaArquivo_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new CategoriaArquivo();

        $this->traducao->loadTraducao("3035", $this->post_request['idioma']);
        $objeto->set_nome_categoria($this->post_request['categoria']);
        $objeto->set_status_categoria('A');
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->categoria_arquivo_dao->Save($objeto);
        $this->CategoriaArquivo_Add_V();
    }

    public function CategoriaArquivo_Gerencia() {
        /*         * ************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $condicao .= " and (status_categoria = \"A\" or status_categoria = \"I\")";
        $total_reg = $this->categoria_arquivo_dao->get_Total("$condicao");
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
        $ordem = "nome_categoria";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->categoria_arquivo_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->categoria_arquivo_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new CategoriaArquivo_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

// fim do Usuario_Gerencia

    public function CategoriaArquivo_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_arquivo_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria("D");
        $this->categoria_arquivo_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->CategoriaArquivo_Gerencia();
    }

    /**
     *
     * Desativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function CategoriaArquivo_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_arquivo_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria("I");
        $this->categoria_arquivo_dao->Save($objeto);
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->CategoriaArquivo_Gerencia();
    }

    /**
     *
     * Ativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function CategoriaArquivo_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->categoria_arquivo_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_categoria("A");
        $this->categoria_arquivo_dao->Save($objeto);
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->CategoriaArquivo_Gerencia();
    }

    /**
     *
     * Altera dados de e-mail
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function CategoriaArquivo_Altera() {

        $objeto = $this->categoria_arquivo_dao->loadObjeto($this->post_request['id']);
        $objeto->set_nome_categoria($this->post_request['nome_categoria']);
        $this->categoria_arquivo_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3037", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->CategoriaArquivo_Gerencia();
    }

    public function CategoriaArquivo_Altera_V() {

        $objeto = $this->categoria_arquivo_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->categoria_arquivo_dao->get_Descricao();
        $vw = new CategoriaArquivo_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Lista_Categorias($qtde = 999, $inicio = 0, $ordem = 'nome_categoria ASC') {

        $objetos = $this->categoria_arquivo_dao->get_Objs(" AND status_categoria = 'A'", $ordem, $inicio, $qtde);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }

    public function Pega_Categoria($id_categoria, $nome_categoria = "") {

        if($id_categoria != 0){
            $condicao = "AND id_categoria = $id_categoria";
        }else{
            $condicao = "AND nome_categoria = '$nome_categoria'";
        }

        $objetos = $this->categoria_arquivo_dao->get_Objs(" AND status_categoria = 'A' $condicao", 'id_categoria DESC', 0, 1);
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
