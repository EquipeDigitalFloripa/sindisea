<?php

/**
 * View Gerencia Foto Adiciona, filho de View
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2015-2018, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/04/2015
 * @package View
 *
 */
class FotoSlider_Add_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Marcio Figueredo
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {
        /*
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         */
        $this->traducao->loadTraducao("4046", $this->get_idioma());


        /*
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Slider_Control");
        $ac = base64_encode("FotoSlider_Gerencia");
        $ac_foto_ord = base64_encode("FotoSlider_Ordena_V");
        $ac_slider_ger = base64_encode("Slider_Gerencia");
        $post = $ac;



        /*
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = array();


        /*
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = array("COUNTER");


        /*
         * CONFIGURE O NAV
         */
        $pagina = (isset($this->post_request['pagina'])) ? $this->post_request['pagina'] : 1;
        $control_div = "NAO";
        $retorno_nav = "pagina=" . $pagina;
        $retorno_nav .= "&ac=$ac";
        $retorno_nav .= "&co=$co";


        /*
         * CONFIGURE O BOX DE INFORMAÇÔES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01();
        $texto_infoacao = $this->traducao->get_titulo_formulario02();


        /*
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = Array();


        /*
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05();
        $retorno_paginacao = "ac=$ac";
        $retorno_paginacao .= "&co=$co";


        /*
         * CONFIGURE A LISTA DE ITENS
         */
        $id_slider = $this->post_request['id'];
        $n_fotos = $this->descricoes['total_fotos'][$id_slider];
        $tam_tab = "900";

        $ctr_slider = new Slider_Control($this->post_request);

        $dados_slider = $ctr_slider->Carrega_Dados_Slider($id_slider);

        $title_tab = "Slider: " . $dados_slider['desc_slider'] . " ($n_fotos fotos)";


        /*
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = array();
        $campos[0]["tamanho_celula"] = "10%";
        $campos[0]["texto"] = "";


        /*
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = array();


        /*
         * CONFIGURE OS MODAIS.
         */

        $modais = array();
        /*
         * CONFIGURE OS VALIDAÇÕES.
         */
        $validacao = array();


        /*
         * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
         */
        $colunas = Array();
        $colunas[0]["alinhamento"] = "left";
        $colunas[0]["texto"] = "
            <form action=\"#\" method=\"GET\" class=\"form demo_form\" style=\"padding:20px;\">
                <div class=\"upload\"></div>
                <div class=\"filelists\">
                    <div style=\"display:none\">
                        <h5>Completo</h5>
                        <ol class=\"filelist complete\"></ol>
                    </div>

                    <h3>Fila de upload de fotos</h3>
                    <div class=\"arquivo\" style=\"\"><span class=\"sucess-num\">0</span> arquivo(s) enviado(s)</div>
                    <ol class=\"filelist queue\"></ol>
                    <span class=\"cancel_all\" style=\"display:none\">Cancelar Todos</span>
                    <br>
                </div>
            </form>
        ";
        $linhas[] = $colunas;

        
        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Add_Fotos.html");
            

        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl->TEMA = $this->get_tema();
        $tpl->TITLE = $this->criaTitulo();
        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");
        
        $link = "sys.php?id_sessao=" . $this->get_id_sessao() . "&idioma=" . $this->get_idioma() . "&co=$co";
        
        $tpl->TITULO_GER_FOTO = $this->traducao->get_leg07();        
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();
        
        $tpl->TITULO_ORDENAR = $this->traducao->get_leg09();
        
        
        $tpl->LINK_GER_FOTO = $link . "&ac=$ac&id=" . $this->post_request['id'];
        
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ac_slider_ger";
        $tpl->LINK_ORDENAR = $link . "&ac = $ac_foto_ord&id = " . $this->post_request['id'];
        
        $tpl->URL_UPLOAD = "AJAX_add_foto_slider.php?id_slider=" . $this->post_request['id'];
        
        $tpl->show();
    }

}

?>
