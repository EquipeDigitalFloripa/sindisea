<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Usuários, filho de View
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package View
 *
 */
class Conteudo_Gerencia_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {
        /*
         * ************************************************************************************************************
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         * ***************INICIO
         */
        $this->traducao->loadTraducao("3052", $this->get_idioma());
        /*
         * ************************************************************************************************************
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************INICIO
         */
        $co = base64_encode("Conteudo_Control"); // CONTROLLER
        $ac = base64_encode("Conteudo_Gerencia");
        $ac_apaga = base64_encode("Conteudo_Apaga");
        $ac_altera = base64_encode("Conteudo_Altera_V");
        $ac_acima = base64_encode("LinkConteudo_Acima");
        $ac_abaixo = base64_encode("LinkConteudo_Abaixo");
        $post = $ac;
        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************INICIO
         */
        $hidden = Array();
        //$hidden['exemplo']    = $this->post_request['exemplo'];
        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         * ***************INICIO
         */
        $componentes = Array("");
        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************INICIO
         */
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        // a linha de retorno é adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=" . $this->post_request['pesquisa']; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        $retorno_nav .= "&selecao01=" . $this->post_request['selecao01'];
        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         * ***************INICIO
         */
        $tam_infoacao = 500; // tamanho em px do box de informações
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações
        $mostrar_obrig = false; // mostrar ou não o * de campos obrigatórios
        $texto_obrig = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio
        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         * ***************FIM
         */

        /*
         * ******************************************************************************************
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         * ***************INICIO
         */
        $filtros = Array();
        $filtros['pesquisa']["width"] = "50%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "right";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        $menu = Array(1 => $this->traducao->get_leg42(), 2 => $this->traducao->get_leg43());
        $filtros['selecao01']["width"] = "50%"; // tamanho do campo
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = $this->traducao->get_titulo_formulario08(); // legenda ao lado do campo
        $filtros['selecao01']["select"] = $this->form->select("selecao01", $this->traducao->get_leg41(), $this->post_request['selecao01'], $menu, "");
        /*
         * ******************************************************************************************
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************INICIO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR

        $retorno_paginacao .= "&pesquisa=" . $this->post_request['pesquisa']; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        $retorno_paginacao .= "&selecao01=" . $this->post_request['selecao01'];

        /*
         *
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         * ***************INICIO
         */
        $tam_tab = "900"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela que lista os itens
        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************INICIO
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "10%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "10%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "50%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "15%";
        $campos[3]["texto"] = $this->traducao->get_leg04();

        $campos[4]["tamanho_celula"] = "15";
        $campos[4]["texto"] = $this->traducao->get_leg05();


        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         * ***************INICIO
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();
            // aplica regra de recebimento no array de dados

            $rotulos = Array(1 => "Não", 2 => "Sim");
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor),NULL,'ISO-8859-1');
            }

            /*
             *
             * ******************************************************************************************
             * CONFIGURE OS MODAIS.
             * ***************INICIO
             */
            $modais = Array();

            $modais[0]['campos'] = Array('ac' => $ac_apaga);
            $modais[0]['acao'] = "apagar";
            $modais[0]['msg'] = $this->traducao->get_leg31();

            /*
             * ******************************************************************************************
             * CONFIGURE OS MODAIS.
             * ***************FIM
             */


            /*
             * ******************************************************************************************
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
             * ***************INICIO
             */

            $colunas = Array();
            $colunas[0]["alinhamento"] = "center";

            if ($dados['menu']) {

                $colunas[0]["texto"] = "<span class=\"texto_conteudo_tabela\">";
                if ($dados['ordem_menu'] <> 1) {
                    $colunas[0]["texto"] .= "<a href=\"javascript:submit_campo(" . $dados['id_conteudo'] . ",'$ac_acima');\">";
                }
                $colunas[0]["texto"] .= "<img align = \"center\" src=\"temas/" . $this->get_tema() . "/icones/subir.png\" width=\"15\" height=\"15\" align=\"center\" border=\"0\" hspace=\"2\"><br>";
                if ($dados['ordem_menu'] <> 1) {
                    $colunas[0]["texto"] .= "</a>";
                }

                if ($dados['ordem_menu'] <> $this->descricoes['total_links']) {
                    $colunas[0]["texto"] .= "<a href=\"javascript:submit_campo(" . $dados['id_conteudo'] . ",'$ac_abaixo');\">";
                }
                $colunas[0]["texto"] .= "<img align = \"center\" src=\"temas/" . $this->get_tema() . "/icones/descer.png\" width=\"15\" height=\"15\" align=\"center\" border=\"0\" hspace=\"2\"><br>";
                if ($dados['ordem_menu'] <> $this->descricoes['total_links']) {
                    $colunas[0]["texto"] .= "</a>";
                }
                $colunas[0]["texto"] .="</span>";
            } else {
                $colunas[0]["texto"] = "";
            }

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "" . $rotulos[$dados['menu']] . "";

            $colunas[2]["alinhamento"] = "left";
            $colunas[2]["texto"] = "<strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['nome_link'] . " (id = " . $dados['id_conteudo'] . ")</strong></font>";

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_conteudo'] . ",'$ac_altera');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:certeza_0(" . $dados['id_conteudo'] . ")\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/del.png\" width=\"15\" height=\"15\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg12() . "
                                        </a>
                                    </span>";

            $linhas[$i] = $colunas;
            /**
             * ******************************************************************************************
             * CONFIGURE as colunas de cada linha da tabela.
             * ***************FIM
             */
            $i++;
        }

        /*
         * ************************************************************************************************************
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * MONTA O HTML E MOSTRA
         * ***************INICIO
         */

        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         * ***************INICIO
         */
        $tpl = new Template("../Templates/Gerencia.html");
        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         * ***************FIM
         */
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
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, "", $titulo_infoacao, $texto_infoacao);

        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];

        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
        /*
         * ************************************************************************************************************
         * MONTA O HTML E MOSTRA
         * ***************FIM
         */
    }

// fim do showView()
}

// Fim da classe
?>
