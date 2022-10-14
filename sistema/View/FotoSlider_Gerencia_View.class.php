<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia FotoSlider, filho de View
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
class FotoSlider_Gerencia_View extends View {

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
        $ac = base64_encode("FotoSlider_Salva_Alteracoes");
        $ac_foto_add = base64_encode("FotoSlider_Add_V");
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
         * CONFIGURE O BOX DE INFORMAÇÕES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01();
        $texto_infoacao = $this->traducao->get_titulo_formulario02();


        /*
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES
         * NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = array();


        /*
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05();
        $retorno_paginacao = "ac=$ac";
        $retorno_paginacao .= "&co=$co";
        $retorno_paginacao .= "&slider=" . $this->post_request['id'];


        /*
         * CONFIGURE A LISTA DE ITENS
         */
        $id_slider = $this->post_request['id'];
        $n_fotos = ($this->descricoes['total_fotos'][$id_slider] == NULL) ? 0 : $this->descricoes['total_fotos'][$id_slider];

        $ctr_slider = new Slider_Control($this->post_request);

        $dados_slider = $ctr_slider->Carrega_Dados_Slider($id_slider);

        $tam_tab = "900";
        $title_tab = "Slider: " . $dados_slider['desc_slider'] . " ($n_fotos fotos)";


        /*
         * CONFIGURE OS MODAIS.
         */
        $modais = array();

        /*
         * CONFIGURE AS VALIDAÇÕES.
         */
        $validacao = array();



        /*
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = array();

        $campos[0]["tamanho_celula"] = "30%";
        $campos[0]["texto"] = $this->traducao->get_leg02();

        $campos[1]["tamanho_celula"] = "60%";
        $campos[1]["texto"] = $this->traducao->get_leg03();


        /*
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = array();
        $i = 0;

        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();

            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), null, "ISO-8859-1");
            }


            /*
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR Vï¿½O ALGUNS TRATAMENTOS.
             */
            $colunas = array();

            $diretorio = "../arquivos/img_slider/";
            $tamanho = '250';

            $thumb = $dados['id_foto'] . "." . $dados['ext_foto'];

            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = "<img src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=" . $diretorio . "&arquivo=" . $thumb . "&tamanho=" . $tamanho . "\" >";

            $colunas[1]["alinhamento"] = "left";            
            $colunas[1]["texto"] = "<span style=\"width: 100%;float: left;\">Legenda:</span>" . $this->form->textarea("leg[" . $dados['id_foto'] . "]", $dados['legenda_foto'], 80, 3, true, 350, true, $this->traducao->get_leg13()) . "<br>";
            $colunas[1]["texto"] .= "<span style=\"width: 100%;float: left;\">Link:</span>" . $this->form->textfield("link[" . $dados['id_foto'] . "]", $dados['link_foto'], 80, false, $this->traducao->get_leg25(), null, "left") . "<br>";
            $colunas[1]["texto"] .= $this->form->checkbox("apagar[" . $dados['id_foto'] . "]", $this->traducao->get_leg29(), $dados['id_foto']);

            $linhas[$i] = $colunas;

            $i++;
        }


        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Gerencia_Fotos.html");


        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
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
        $pagin = $this->criaPaginacao($pagina, $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->TEMA = $this->get_tema();

        $tpl->TITULO_ADD_FOTO = $this->traducao->get_leg06();
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();
        $tpl->TITULO_ORDENAR = $this->traducao->get_leg09();

        $link = "sys.php?id_sessao=" . $this->get_id_sessao() . "&idioma=" . $this->get_idioma() . "&co=$co";

        $tpl->LINK_ADD_FOTO = $link . "&ac=$ac_foto_add&id=" . $this->post_request['id'];
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ac_slider_ger";
        $tpl->LINK_ORDENAR = $link . "&ac = $ac_foto_ord&id = " . $this->post_request['id'];

        $tpl->BOTAO = $this->form->button('center', $this->traducao->get_leg31());

        $tpl->show();
    }

}

?>
