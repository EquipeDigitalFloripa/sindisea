<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Inclusão de Fotos no Post
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 11/07/2016
 * @package View
 *
 */
class Noticia_Foto_Ordena_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {

        /**
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         */
        $this->traducao->loadTraducao("9008", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Foto_Ordena");
        $ac_foto_add = base64_encode("Noticia_Foto_Add_V");
        $ac_ger_noticia = base64_encode("Noticia_Gerencia");
        $ac_ger_foto = base64_encode("Noticia_Foto_Gerencia");
        $post = $ac;

        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();
        $hidden['campooculto'] = "";

        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");

        /**
         * CONFIGURE O NAV
         */
        $control_div = "NAO"; // SIM quando ï¿½ necessï¿½rio esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_ger_foto"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR

        /**
         * CONFIGURE O BOX DE INFORMAï¿½ï¿½ES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es

        /**
         * CONFIGURE OS FILTROS. ATENCAO !!! ï¿½ NECESSï¿½RIO EFETUAR CONFIGURAï¿½ï¿½ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = Array();

        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do nï¿½mero de pï¿½ginas
        $retorno_paginacao = "ac=$ac_ger_foto"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&id_noticia=" . $this->post_request['id']; // CONTROLADOR

        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $id_pro = $this->post_request['id'];
        $tam_tab = "900"; // tamanho da tabela que lista os itens em %
        $title_tab = "Ordenação de Fotos"; // tï¿½tulo da tabela

        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();

        $campos[0]["tamanho_celula"] = "100";
        $campos[0]["texto"] = $this->traducao->get_leg02();

        $ctr_noticia = new Noticia_Control($this->post_request);
        $dados_noticia = $ctr_noticia->Pega_Dados_Noticia($this->post_request['id']);

        /**
         * Seleciona os elementos que serï¿½o mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {
            $dados = $this->objetos[$i]->get_all_dados();
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, "ISO-8859-1");
            }
            $modais = Array();

            $div_id = $dados['id_foto'];
            $colunas = Array();
            $validacao = Array();

            $diretorio = "../sys/arquivos/img_noticias/";
            $nome = $dados['id_foto'] . "." . $dados['ext_foto'];
            $mini = $dados['id_foto'] . "." . $dados['ext_foto'];
            $tamanho = '180';

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "<li id=\"li_$div_id\"><div><img border=\"1\" src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=../arquivos/img_noticias/&arquivo=" . $mini . "&tamanho=" . $tamanho . "\" ></div></li>";
            $linhas[$i] = $colunas;

            $i++;
        }
        $botoes = Array();

        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Ordena_Fotos.html");

        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();

        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";
        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJssemLightbox();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->TITLE_POST = $this->criaTituloPost("Notícia: " . $dados_noticia['titulo_noticia']);
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


        $tpl->LINK_GERENCIA_FOTO = $link . "&ac=$ac_ger_foto&id=" . $this->post_request['id'];
        $tpl->TITULO_GERENCIA_FOTO = $this->traducao->get_leg05();

        $tpl->LINK_VOLTA_GER = $link . "&ac=$ac_ger_noticia";
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();

        $tpl->LINK_ADD_FOTO = $link . "&ac=$ac_foto_add&id=" . $this->post_request['id'];
        $tpl->TITULO_ADD_FOTO = $this->traducao->get_leg06();

        $tpl->show();
    }

}

?>
