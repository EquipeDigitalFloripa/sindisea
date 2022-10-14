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
class Noticia_Foto_Add_View extends View {

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
        $this->traducao->loadTraducao("3016", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Foto_Gerencia");
        $ac_ger_noticia = base64_encode("Noticia_Gerencia");
        $ac_ger_foto = base64_encode("Noticia_Foto_Gerencia");
        $ac_foto_ordena = base64_encode("Noticia_Foto_Ordena_V");
        $post = $ac;

        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();
        $hidden['id_noticia_corrente'] = (isset($this->post_request['id_noticia_corrente'])) ? $this->post_request['id_noticia_corrente'] : NULL;

        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");

        /**
         * CONFIGURE O NAV
         */
        $pagina = (isset($this->post_request['pagina'])) ? $this->post_request['pagina'] : 0;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $pagina; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR

        /**
         * CONFIGURE O BOX DE INFORMAÇÔES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações

        /**
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = Array();

        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR

        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $id_noticia = (isset($this->post_request['id_noticia_corrente'])) ? $this->post_request['id_noticia_corrente'] : $this->post_request['id'];
        $ctr_noticia = new Noticia_Control($this->post_request);
        $dados_noticia = $ctr_noticia->Pega_Dados_Noticia($id_noticia);


        $tam_tab = "900"; // tamanho da tabela que lista os itens em %
        $title_tab = ""; // tï¿½tulo da tabela que lista os itens

        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "10%";
        $campos[0]["texto"] = $this->traducao->get_leg01();



        /**
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = Array();

        /**
         * CONFIGURE OS MODAIS.
         */
        $modais = Array();

        /**
         * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
         */
        $colunas = Array();
        $colunas[0]["alinhamento"] = "center";
        $colunas[0]["texto"] = "
            <form action=\"#\" method=\"GET\" class=\"form demo_form\" style=\"padding:20px;\">
              <div class=\"upload\"></div>
              <div class=\"filelists\">
                <div style=\"display:none\">
                  <h5>Completo</h5>
                  <ol class=\"filelist complete\">
                  </ol>
                </div>
                
                <h3>Fila de upload de fotos</h3>
                <div class=\"arquivo\" style=\"\"><span class=\"sucess-num\">0</span> arquivo(s) enviado(s)</div>
                <ol class=\"filelist queue\">
                </ol>
                <span class=\"cancel_all\" style=\"display:none\">Cancelar Todos</span>
                <br>
              </div>
            </form>
        ";
        $linhas[] = $colunas;


        /**
         * CONFIGURA BOTÕES 
         */
        $botoes = Array();
        $botoes[0] = $this->form->button("center", "CONTINUAR", "button", "validar()", "botao", "");


        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Add_Fotos.html");

        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->TITLE = $this->criaTitulo();
//        $tpl->TITLE_POST = $this->criaTituloPost("Notícia: " . $dados_noticia['titulo_noticia']);
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
        $tpl->URL_UPLOAD = "AJAX_add_foto_noticia.php?id_noticia=" . $id_noticia;
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ac_ger_noticia";
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();

        $tpl->LINK_GER_FOTO = $link . "&ac=$ac_ger_foto&id=" . $id_noticia;
        $tpl->TITULO_GER_FOTO = $this->traducao->get_leg05();
//
//        $tpl->LINK_ORDENAR = $link . "&ac=$ac_foto_ordena&id=" . $id_noticia;
//        $tpl->TITULO_ORDENAR = $this->traducao->get_leg09();

        $tpl->show();
    }

}

?>
