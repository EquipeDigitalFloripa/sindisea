<?php

//if (isset($_SERVER['PWD'])) {
//    include_once '../Control/Configuracoes_Control.class.php';
//    include_once '/sistema/Control/Configuracoes_Control.class.php';
//    $ctr_config = new Configuracoes_Control($post_request);
//    $endereco = $ctr_config->Pega_Dir_Adress();
//    require_once($endereco . "/sistema/AutoLoaderCmd.php");
//} else {
//    require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
//}

/**
 * Classe de controle da entidade Balancete
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
class Balancete_Control extends Control {

    /**
     * DAO da Entidade CategoriaGaleria
     * @var Balancete_Dao 
     */
    private $balancete_dao;

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
        $this->balancete_dao = $this->config->get_DAO("Balancete");
    }

    /**
     * Chama a view com a lista de Categorias a serem gerenciadas
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Balancete_Gerencia() {

        /*         * ********************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        // pega o filtro
        $mostrar = 0;
        $pesquisa = $this->post_request['pesquisa'];


        $condicao .= " and (status_balancete = \"A\" or status_balancete = \"I\")";


        $total_reg = $this->balancete_dao->get_Total("$condicao");


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
        $ordem = "data DESC";


        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->balancete_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->balancete_dao->get_Descricoes();


        //CARREGA A VIEW E MOSTRA
        $vw = new Balancete_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a view com a lista de Categorias a serem gerenciadas
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Balancete_Gerencia_Data() {

        /*         * ********************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        // pega o filtro
        $mostrar = 0;
        $pesquisa = $this->post_request['pesquisa'];

        $condicao .= " and (status_balancete = \"A\" or status_balancete = \"I\")";

        $total_reg = $this->balancete_dao->get_Total("$condicao");


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
        $ordem = "data DESC";


        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->balancete_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->balancete_dao->get_Descricoes();


        //CARREGA A VIEW E MOSTRA
        $vw = new Balancete_Gerencia_Data_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a view de inclusão de categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Balancete_Add_V() {

        $descricoes = $this->balancete_dao->get_Descricoes();

        $vw = new Balancete_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa de inclusão da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Balancete_Add() {

        $id_balancete = $this->balancete_dao->get_max_id() + 1;
        
        $target_dir = "arquivos/arquivo_balancete/balancete_" . $id_balancete . '/';
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $arquivo = $_FILES["balancete_completo"]["name"];
        $target_file = $target_dir . $arquivo;
        move_uploaded_file($_FILES["balancete_completo"]["tmp_name"], $target_file);

        $arquivo2 = $_FILES["balancete_movimento_caixa"]["name"];
        $target_file = $target_dir . $arquivo2;
        move_uploaded_file($_FILES["balancete_movimento_caixa"]["tmp_name"], $target_file);


        $arquivo3 = $_FILES["balancete_resumido"]["name"];
        $target_file = $target_dir . $arquivo3;
        move_uploaded_file($_FILES["balancete_resumido"]["tmp_name"], $target_file);

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Balancete();

        $this->traducao->loadTraducao("5071", $this->post_request['idioma']);

        $objeto->set_completo($arquivo);
        $objeto->set_movimento_caixa($arquivo2);
        $objeto->set_resumido($arquivo3);
        $objeto->set_data($this->post_request['ano'] . "-" . $this->post_request['mes'] . "-01 00:00:01");
        $objeto->set_data_cadastro($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_balancete('A');

        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $id = $this->balancete_dao->Save($objeto);
        $this->Balancete_Gerencia();
    }

    /**
     * Chama a view de alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Balancete_Altera_V() {

        $objeto = $this->balancete_dao->loadObjeto($this->post_request['id']);

        $descricoes = $this->balancete_dao->get_Descricoes();

        $vw = new Balancete_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Balancete_Altera() {

        $this->traducao->loadTraducao("5073", $this->post_request['idioma']);
        $objeto = $this->balancete_dao->loadObjeto($this->post_request['id']);

        $objeto->set_data($this->post_request['ano'] . "-" . $this->post_request['mes'] . "-01 00:00:01");

        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/sistema/sys/arquivos/arquivo_balancete/balancete_".$this->post_request['id']."/";
            
        
        if ($_FILES['balancete_completo']['error'] == 0) {
            $arquivo = $_FILES["balancete_completo"]["name"];
            $target_file = $target_dir . $arquivo;
            move_uploaded_file($_FILES["balancete_completo"]["tmp_name"], $target_file);

            $objeto->set_completo($arquivo);
        }
        
        if ($_FILES['balancete_movimento_caixa']['error'] == 0) {
            $arquivo = $_FILES["balancete_movimento_caixa"]["name"];
            $target_file = $target_dir . $arquivo;
            move_uploaded_file($_FILES["balancete_movimento_caixa"]["tmp_name"], $target_file);

            $objeto->set_movimento_caixa($arquivo);
        }

        
        if ($_FILES['balancete_resumido']['error'] == 0) {
            $arquivo = $_FILES["balancete_resumido"]["name"];
            $target_file = $target_dir . $arquivo;
            move_uploaded_file($_FILES["balancete_resumido"]["tmp_name"], $target_file);

            $objeto->set_resumido($arquivo . "." . $ext);
        }

        $update = $this->balancete_dao->Save($objeto);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        if ($update) {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        }
        $this->Balancete_Gerencia();
    }

    /**
     * Executa a exclusão de uma categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Balancete_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->balancete_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_balancete("D");

        $apaga = $this->balancete_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5072", $this->post_request['idioma']);

        if ($apaga) {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        }
        $this->Balancete_Gerencia();
    }

    /**
     * Aesativada uma categoria que estava ativada
     *
     * @return void
     */
    public function Balancete_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->balancete_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_balancete("I");

        $this->balancete_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5072", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Balancete_Gerencia();
    }

    /**
     * Ativa uma categoria que estava desativada
     *
     * @return void
     */
    public function Balancete_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->balancete_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_balancete("A");

        $this->balancete_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5072", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Balancete_Gerencia();
    }

    public function Lista_Balancetes($qtde, $inicio, $ordem, $condicao = "") {
        
        $objetos = $this->balancete_dao->get_Objs(" $condicao AND status_balancete = 'A'", $ordem, $inicio, $qtde);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }

    public function Pega_Balancete($id_balancete) {

        $condicao = "AND id_balancete = $id_balancete";

        $objetos = $this->balancete_dao->get_Objs(" AND status_balancete = 'A' $condicao", 'id_balancete DESC', 0, 1);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados[0];
    }

    public function get_Total() {
        $total = $this->balancete_dao->get_Total(" AND status_balancete = 'A'");
        return $total;
    }

}
