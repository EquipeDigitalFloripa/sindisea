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
 * Classe de controle da entidade Convenio
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
class Convenio_Control extends Control {

    /**
     * DAO da Entidade CategoriaGaleria
     * @var Convenio_Dao 
     */
    private $convenio_dao;

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
        $this->convenio_dao = $this->config->get_DAO("Convenio");
    }

    /**
     * Chama a view com a lista de Categorias a serem gerenciadas
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Convenio_Gerencia() {

        /*         * ********************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        // pega o filtro
        $mostrar = 0;
        $pesquisa = $this->post_request['pesquisa'];

        $condicao = " and (status_convenio = \"A\" or status_convenio = \"I\")";

        if ($pesquisa != "") {
            $condicao .= " AND (nome LIKE '%$pesquisa%')";
        }


        $total_reg = $this->convenio_dao->get_Total("$condicao");


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
        $ordem = "nome";


        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->convenio_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->convenio_dao->get_Descricoes();


        //CARREGA A VIEW E MOSTRA
        $vw = new Convenio_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a view de inclusão de categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Convenio_Add_V() {

        $descricoes = $this->convenio_dao->get_Descricoes();

        $vw = new Convenio_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa de inclusão da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Convenio_Add() {
        

        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/sistema/sys/arquivos/img_convenio/";
        $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $foto = $this->convenio_dao->get_max_id() + 1;
        $target_file = $target_dir . $foto . "." . $ext;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);


        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Convenio();

        $this->traducao->loadTraducao("3092", $this->post_request['idioma']);
        $objeto->set_nome($this->post_request['nome']);
        $objeto->set_info($this->post_request['info']);
        $objeto->set_foto($foto);
        $objeto->set_ext_foto($ext);
        $objeto->set_status_convenio('A');
//        $this->post_request['msg_tp'] = "sucesso";
//        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $id = $this->convenio_dao->Save($objeto);
//        $this->Convenio_Crop_Foto_V($id);
        $this->Convenio_Gerencia();
    }

    public function Convenio_Crop_Foto_V($id_convenio) {

        
        $descricoes = $this->convenio_dao->get_Descricoes();
        $objeto = $this->convenio_dao->loadObjeto($id_convenio);

        $vw = new Convenio_Crop_Foto_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Convenio_Crop_Foto() {

        $img = new Imagem();
        $obj = $this->convenio_dao->loadObjeto($this->post_request['id']);

        $ext = $obj->get_ext_foto();
        $nome = $obj->get_foto() . "." . $ext;

        $img->crop('arquivos/img_convenio/', $nome, $this->post_request['x1'], $this->post_request['y1'], $this->post_request['w'], $this->post_request['h'], 306, 408);

        $this->traducao->loadTraducao("4059", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Convenio_Gerencia();
    }

    /**
     * Chama a view de alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Convenio_Altera_V() {

        $objeto = $this->convenio_dao->loadObjeto($this->post_request['id']);

        $descricoes = $this->convenio_dao->get_Descricoes();

        $vw = new Convenio_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Convenio_Altera() {

        $this->traducao->loadTraducao("5063", $this->post_request['idioma']);
        $objeto = $this->convenio_dao->loadObjeto($this->post_request['id']);

        $objeto->set_nome($this->post_request['nome']);
        $objeto->set_info($this->post_request['info']);

        if ($_FILES['foto']['error'] == 0) {

            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/sistema/sys/arquivos/img_convenio/";

            $ext_img = substr(strrchr(trim($this->post_request['foto']['name']), '.'), 1);
            $foto = $this->post_request['id'];
            $target_file = $target_dir . $foto . "." . $ext_img;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

            $objeto->set_foto($foto);
            $objeto->set_ext_foto($ext_img);

            $this->convenio_dao->Save($objeto);
            $this->Convenio_Crop_Foto_V2($this->post_request['id']);
        } else {
            $update = $this->convenio_dao->Save($objeto);
            // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
            if ($update) {
                $this->post_request['msg_tp'] = "sucesso";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            } else {
                $this->post_request['msg_tp'] = "erro";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
            }
            $this->Convenio_Gerencia();
        }
    }

    public function Convenio_Crop_Foto_V2($id_convenio) {
        $descricoes = $this->convenio_dao->get_Descricoes();
        $objeto = $this->convenio_dao->loadObjeto($id_convenio);

        $vw = new Convenio_Crop_Foto_View2($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Convenio_Crop_Foto2() {

        $img = new Imagem();
        $obj = $this->convenio_dao->loadObjeto($this->post_request['id']);

        $ext = $obj->get_ext_foto();
        $nome = $obj->get_foto() . "." . $ext;

        $img->crop('arquivos/img_convenio/', $nome, $this->post_request['x1'], $this->post_request['y1'], $this->post_request['w'], $this->post_request['h'], 200, 200);

        $this->traducao->loadTraducao("1002", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Convenio_Gerencia();
    }

    /**
     * Executa a exclusão de uma categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Convenio_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->convenio_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_convenio("D");

        $apaga = $this->convenio_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5062", $this->post_request['idioma']);

        if ($apaga) {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        }
        $this->Convenio_Gerencia();
    }

    /**
     * Aesativada uma categoria que estava ativada
     *
     * @return void
     */
    public function Convenio_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->convenio_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_convenio("I");

        $this->convenio_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5062", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Convenio_Gerencia();
    }

    /**
     * Ativa uma categoria que estava desativada
     *
     * @return void
     */
    public function Convenio_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->convenio_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_convenio("A");

        $this->convenio_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5062", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Convenio_Gerencia();
    }
    
    public function Lista_Convenioes($qtde, $inicio, $ordem) {

        $condicao = "";

        $objetos = $this->convenio_dao->get_Objs(" AND status_convenio = 'A' $condicao", $ordem, $inicio, $qtde);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }
    
    public function Lista_Juridico($qtde, $inicio, $ordem) {

        $condicao = "";

        $objetos = $this->convenio_dao->get_Objs(" AND status_convenio = 'C' $condicao", $ordem, $inicio, $qtde);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }
    
    public function Pega_Convenio($id_convenio) {

        $condicao = "AND id_convenio = $id_convenio";

        $objetos = $this->convenio_dao->get_Objs(" AND status_convenio = 'A' $condicao", 'id_convenio DESC', 0, 1);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados[0];
    }
    
}
