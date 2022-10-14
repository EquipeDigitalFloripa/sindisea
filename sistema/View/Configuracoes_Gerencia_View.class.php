<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Configuracoes_Gerencia_View extends View {

    public function showView() {

        /**
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         */
        $this->traducao->loadTraducao("9999", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Configuracoes_Control"); // CONTROLLER
        $ac = base64_encode("Configuracoes_Gerencia");
        $ac_analytics = base64_encode("Configuracoes_Analytics_V");
        $ac_metatags = base64_encode("Configuracoes_Metatags_V");
        $ac_favicon = base64_encode("Configuracoes_Favicon_V");
        $post = $ac;

        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();

        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("TOOLTIP");


        /**
         * CONFIGURE O NAV
         */
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=$pagina"; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR


        /**
         * CONFIGURE O BOX DE INFORMAÇÔES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // t?tulo do box de informa??es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informa??es


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
        $tam_tab = "980";
        $title_tab = $this->traducao->get_titulo_formulario08(); // título da tabela


        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "33%";
        $campos[0]["texto"] = $this->traducao->get_leg48();

        $campos[1]["tamanho_celula"] = "33%";
        $campos[1]["texto"] = $this->traducao->get_leg49();

        $campos[2]["tamanho_celula"] = "33%";
        $campos[2]["texto"] = $this->traducao->get_leg50();
        


        /**
         * CONFIGURE VALIDAÇÃO.
         */
        $validacao = Array();

        /**
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < 1) {

            /**
             * CONFIGURE o tooltip de INFO
             */
            $inf = Array();
            $infos = $this->criaInfo($inf);

            /* (
             * CONFIGURE OS MODAIS.
             */
            $modais = Array();


            /**
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
             */
            $colunas = Array();
            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(1,'$ac_favicon');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(1,'$ac_analytics');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";

            $colunas[2]["alinhamento"] = "center";
            $colunas[2]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(1,'$ac_metatags');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";


            $linhas[$i] = $colunas;

            $i++;
        }


        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Gerencia.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
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

        $tpl->show();
    }

}

?>
