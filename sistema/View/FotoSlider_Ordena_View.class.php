<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Ordenar Foto Slider, filho de View
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
class FotoSlider_Ordena_View extends View {

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
        $this->traducao->loadTraducao("9008", $this->get_idioma());


        /*
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Slider_Control");
        $ac = base64_encode("FotoSlider_Ordena");
        $ac_ger = base64_encode("FotoSlider_Gerencia");
        $post = $ac;


        /*
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();
        $hidden['campooculto'] = "";


        /*
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");


        /*
         * CONFIGURE O NAV
         */
        $control_div = "NAO";
        $retorno_nav = "pagina=" . $this->post_request['pagina'];
        $retorno_nav .= "&ac=$ac_ger";
        $retorno_nav .= "&co=$co";


        /*
         * CONFIGURE O BOX DE INFORMAÇÕES
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
        $retorno_paginacao = "ac=$ac_ger";
        $retorno_paginacao .= "&co=$co";
        $retorno_paginacao .= "&imoveis=" . $this->post_request['id'];


        /*
         * CONFIGURE A LISTA DE ITENS
         */
        $id_pro = $this->post_request['id'];
        $tam_tab = "900";


        /*
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();

        $campos[0]["tamanho_celula"] = "100";
        $campos[0]["texto"] = $this->traducao->get_leg02();


        /*
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $title_tab = "Ordenação de Fotos";


        /*
         * Seleciona os elementos que serï¿½o mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();

            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), null, "ISO-8859-1");
            }


            /*
             * CONFIGURE OS MODAIS.
             */
            $modais = Array();


            /*
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR Vï¿½O ALGUNS TRATAMENTOS.
             */
            $div_id = $dados['id_foto'];
            $colunas = array();
            $validacao = array();

            $diretorio = "../arquivos/img_slider/";
            $thumb = $dados['id_foto'] . "." . $dados['ext_img'];
            $tamanho = '180';

            $arquivo_video = array('mp4');
            if (in_array($dados['ext_img'], $arquivo_video)) {
                $thumb = "video.jpg";
            } else {
                $thumb = $dados['id_foto'] . "." . $dados['ext_img'];
            }

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "<li id=\"li_$div_id\"><div><img border=\"1\" src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=" . $diretorio . "&arquivo=" . $thumb . "&tamanho=" . $tamanho . "\" ></div></li>";
            $linhas[$i] = $colunas;

            $i++;
        }
        $botoes = Array();
        $botoes[0] = $this->form->button("center");


        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Ordena_Fotos.html");


        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJssemLightbox();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaDivLista($tam_tab, $linhas, $title_tab, $botoes, $titulo_infoacao, $texto_infoacao);
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);
        $tpl->TEMA = $this->get_tema();
        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $tpl->TITULO_ADD_FOTO = $this->traducao->get_leg06();
        $tpl->TITULO_GER_FOTO = $this->traducao->get_leg07();
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();
        $add_fotos = base64_encode("FotoSlider_Add_V");
        $ger_fotos = base64_encode("FotoSlider_Gerencia");
        $ger_imoveis = base64_encode("Slider_Gerencia");
        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";
        $tpl->LINK_ADD_FOTO = $link . "&ac=$add_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_GER_FOTO = $link . "&ac=$ger_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ger_imoveis";

        $tpl->show();
    }

}

?>
