<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Slider
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2015-2018, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/04/2015
 * @Ultima_Modif 20/05/2016 por Jean Barcellos
 *
 * @package Control
 *
 */
class Slider_Control extends Control {

    private $slider_dao;
    private $foto_slider_dao;

    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->slider_dao = $this->config->get_DAO("Slider");
        $this->foto_slider_dao = $this->config->get_DAO("FotoSlider");
    }

    /**
     * Mostra a lista de sliders, utilizado para gerenciar sliders no site
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Gerencia() {

        /* CONFIGURA FILTRO DE PESQUISA */
        $condicao = " AND (status_slider = \"A\" OR status_slider = \"I\")";
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 1) ? " AND status_slider = 'A'" :
                ((isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 2) ? " AND status_slider = 'I'" :
                ((isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 3) ? " AND status_slider = 'D'" : $condicao));


        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->slider_dao->get_Total("$condicao");

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
        $ordem = "id_slider DESC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->slider_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->slider_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Slider_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a View de Inclusão de Sliders
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Add_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->slider_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Slider_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Executa a inclusão de Sliders
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Add() {

        /* CRIA OBJETO E SALVA DADOS */
        $objeto = new Slider();
        echo "Oi";
        $objeto->set_desc_slider($this->post_request['desc_slider']);
        $objeto->set_data_slider($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_slider("A");

        $retorno = $this->slider_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA
        if ($retorno != 0) {
            $this->traducao->loadTraducao("4041", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            $this->Slider_Gerencia();
        } else {
            $this->traducao->loadTraducao("4041", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
            $this->Slider_Add_V();
        }
    }

    /**
     * Chama a View de Alteração de informação de Sliders
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Altera_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $objeto = $this->slider_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->slider_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Slider_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a alteração das informações de um Slider
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Altera() {

        /* CARREGA DADOS DO OBJETO E SALVA ALTERAÇÃO */
        $objeto = $this->slider_dao->loadObjeto($this->post_request['id']);
        $objeto->set_desc_slider($this->post_request['desc_slider']);

        $this->slider_dao->Save($objeto);

        $this->traducao->loadTraducao("4043", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Slider_Gerencia();
    }

    /**
     * Ativa um slider que estava desativado
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Ativa() {

        /* CARREGA DADOS DO OBJETO E SALVA ALTERAÇÃO */
        $objeto = $this->slider_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_slider("A");

        $this->slider_dao->Save($objeto);

        $this->traducao->loadTraducao("4042", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Slider_Gerencia();
    }

    /**
     * Desativa um slider que estava ativado
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Desativa() {

        /* CARREGA DADOS DO OBJETO E SALVA ALTERAÇÃO */
        $objeto = $this->slider_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_slider("I");

        $this->slider_dao->Save($objeto);

        $this->traducao->loadTraducao("4042", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Slider_Gerencia();
    }

    /**
     * Apaga um slider
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Slider_Apaga() {

        /* CARREGA DADOS DO OBJETO E SALVA ALTERAÇÃO */
        $objeto = $this->slider_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_slider("D");

        $this->slider_dao->Save($objeto);

        $this->traducao->loadTraducao("4042", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Slider_Gerencia();
    }

    /**
     *
     * Chama a View de Gerenciamento das Fotos de um Slider
     *
     * @author Marcio Figueredo
     * @return void
     *
     */
    public function FotoSlider_Gerencia() {

        $slider = $this->post_request['id'];
        $condicao = " AND status_foto = \"A\" AND id_slider = " . $slider . "";

        $total_reg = $this->foto_slider_dao->get_Total("$condicao");

        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 100;

        $mat = $this->post_request['pagina'] - 1;
        $inicio = $mat * $pag_views;

        $ordem = "ordem_foto";

        $objetos = $this->foto_slider_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->foto_slider_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new FotoSlider_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a View de inclusão de fotos em um slider
     *
     * @author Marcio Figueredo
     * @return void
     *
     */
    public function FotoSlider_Add_V() {
        
        $descricoes = $this->foto_slider_dao->get_Descricao();

        $vw = new FotoSlider_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Executa as alterações realizadas nas fotos de um slider
     *
     * @author Marcio Figueredo
     * @return void
     *
     */
    public function FotoSlider_Salva_Alteracoes() {

        $id = array_keys($this->post_request['leg']);

        for ($i = 0; $i < count($id); $i++) {
            $obj = $this->foto_slider_dao->loadObjeto($id[$i]);

            $obj->set_legenda_foto($this->post_request['leg'][$id[$i]]);
            $obj->set_link_foto($this->post_request['link'][$id[$i]]);

            if (isset($this->post_request['apagar'][$id[$i]])) {
                $obj->set_ordem_foto(0);
                $obj->set_status_foto('D');
            }

            $this->foto_slider_dao->Save($obj);
            $this->foto_slider_dao->corrige_ordem_faltante($obj->get_id_slider());
        }
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA
        $this->traducao->loadTraducao("4046", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->FotoSlider_Gerencia();
    }

    /**
     * Chama a View de ordenação das fotos de um Slider
     *
     * @author Marcio Figueredo
     * @return void
     *
     */
    public function FotoSlider_Ordena_V() {
        $slider = $this->post_request['id'];
        $condicao = " AND status_foto = \"A\" and id_slider = " . $slider . "";
        $total_reg = $this->slider_dao->get_Total("$condicao");

        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 100;

        $mat = $this->post_request['pagina'] - 1;
        $inicio = 0;

        $ordem = "ordem";

        $objetos = $this->foto_slider_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->slider_dao->get_Descricao();

        $vw = new FotoSlider_Ordena_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Executa a ordenação das fotos de um Slider
     *
     * @author Marcio Figueredo
     * @return void
     *
     */
    public function FotoSlider_Ordena() {
        $id = $this->post_request['id'];
        $ordem = $this->post_request['campooculto'];
        $ordem2 = str_replace('li_', '', $ordem);
        $chars = preg_split('/,/', $ordem2, -1, PREG_SPLIT_NO_EMPTY);
        $update = $this->foto_slider_dao->ordene_foto($chars, $id);
        $this->FotoSlider_Gerencia();
    }

// ---------------------- SITE -------------------------------------------------


    public function Carrega_Dados_Slider($id_slider) {

        $objeto = $this->slider_dao->get_Objs(" AND status_slider = 'A' AND id_slider = $id_slider", "data_slider", 0, 1);
        return $objeto[0]->get_all_dados();
    }

    /**
     * Pega os Sliders destacados
     *
     * @author Marcio Figueredo
     * @return Array Vetor com as informações dos Sliders destacados
     *
     */
    public function Pega_Slider() {
        $objeto = $this->slider_dao->get_Objs("AND status_slider = \"A\"", "data_slider", 0, 1);
        $i = 0;
        while ($i < count($objeto)) {
            $dados[$i] = $objeto[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

    /**
     * Pega as fotos do slider setado pelo parâmetro $slider_destaque
     *
     * @author Marcio Figueredo
     * @param int $slider_destaque ID do slider
     * @return Array Vetor com as informações dos Sliders destacados
     *   
     */
    public function Lista_Fotos_Slider($id_slider) {
        $condicao = " AND status_foto = 'A'";
        $objetos = $this->foto_slider_dao->get_Objs(" $condicao AND id_slider = $id_slider ", "ordem_foto ASC", 0, 10);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

}
