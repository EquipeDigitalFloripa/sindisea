<?php

/**
 * Classe de controle da entidade FotoSlider
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
class FotoSlider_Control extends Control
{

    /**
     * DAO da entidade FotoSlider
     * @var FotoSlider_DAO 
     */
    private $foto_slider_dao;

    /**
     * Construtor
     * @param array $post_request Parâmetros de _POST e _REQUEST
     */
    public function __construct($post_request)
    {

        parent::__construct($post_request);
        $this->foto_slider_dao = $this->config->get_DAO("FotoSlider");
    }

    /**
     * Chama a View de Gerenciamento das Fotos de um Slider
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function FotoSlider_Gerencia()
    {

        $slider = $this->post_request['id'];
        $condicao = " AND status_foto = \"A\" AND id_slider = " . $slider . "";

        $total_reg = $this->foto_slider_dao->get_Total("$condicao");

        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 100;

        $mat = $this->post_request['pagina'] - 1;
        $inicio = $mat * $pag_views;

        $ordem = "ordem";

        $objetos = $this->foto_slider_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->foto_slider_dao->get_Descricoes();

        //CARREGA A VIEW E MOSTRA
        $vw = new FotoSlider_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a View de inclusão de fotos em um slider
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function FotoSlider_Add_V()
    {
        $descricoes = $this->foto_slider_dao->get_Descricoes();

        $vw = new FotoSlider_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa as alterações realizadas nas fotos de um slider
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function FotoSlider_Salva_Alteracoes()
    {

        $id = array_keys($this->post_request['titulo']);

        for ($i = 0; $i < count($id); $i++) {
            $obj = $this->foto_slider_dao->loadObjeto($id[$i]);
            $titulo = $this->post_request['titulo'][$id[$i]];
            $legenda = $this->post_request['leg'][$id[$i]];
            $link = $this->post_request['link'][$id[$i]];

            $obj->set_titulo($titulo);
            $obj->set_leg($legenda);
            $obj->set_link($link);

            
            if (isset($this->post_request['apagar'][$id[$i]])) {
                $obj->set_ordem(0);
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
     */
    public function FotoSlider_Ordena_V()
    {
        $slider = $this->post_request['id'];

        $condicao = " AND status_foto = 'A' and id_slider = $slider ";
//        $total_reg = $this->slider_dao->get_Total("$condicao");

        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 100;

        $mat = $this->post_request['pagina'] - 1;
        $inicio = 0;

        $ordem = "ordem";

        $objetos = $this->foto_slider_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->foto_slider_dao->get_Descricoes();

        $vw = new FotoSlider_Ordena_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Executa a ordenação das fotos de um Slider
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function FotoSlider_Ordena()
    {
        $id = $this->post_request['id'];
        $ordem = $this->post_request['campooculto'];
        $ordem2 = str_replace('li_', '', $ordem);
        $chars = preg_split('/,/', $ordem2, -1, PREG_SPLIT_NO_EMPTY);
        $update = $this->foto_slider_dao->ordene_foto($chars, $id);
        $this->FotoSlider_Gerencia();
    }

    /*
     * SITE ******************************************************************** 
     */

    /**
     * Pega as fotos do slider setado pelo parâmetro $id_slider
     *
     * @author Marcio Figueredo
     * @param int $id_slider ID do slider
     * @return Array Vetor com as informações dos Sliders destacados
     */
    public function Lista_Fotos_Slider($id_slider)
    {
        $condicao = " AND status_foto = 'A'";
        $objetos = $this->foto_slider_dao->get_Objs(" $condicao AND id_slider = $id_slider ", "ordem ASC", 0, 100);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

}
