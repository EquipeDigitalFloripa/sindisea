<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Gerenciamento de Centros
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 30/08/2018
 *
 * @package View
 */
class Centro_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("7037", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Centro_Control"); // CONTROLLER
        $ac = base64_encode("Centro_Gerencia");
        $ac_add = base64_encode("Centro_Add_V");
        $ac_altera = base64_encode("Centro_Altera_V");
        $ac_ativa = base64_encode("Centro_Ativa");
        $ac_desativa = base64_encode("Centro_Desativa");
        $ac_apaga = base64_encode("Centro_Apaga");
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
        $pagina = (isset($this->post_request['pagina'])) ? $this->post_request['pagina'] : 1;
        $pesquisa = (isset($this->post_request['pesquisa'])) ? $this->post_request['pesquisa'] : "";
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $pagina; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=" . $pesquisa; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO


        /**
         * CONFIGURE O BOX DE INFORMAÇÔES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações


        /**
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $selecao01 = isset($this->post_request['selecao01']) ? $this->post_request['selecao01'] : 1;

        $filtros = Array();
        $filtros['pesquisa']["width"] = "10%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "left";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        $filtros['selecao01']["width"] = "10%"; // tamanho do campo
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = $this->traducao->get_titulo_formulario08(); // legenda ao lado do campo        
        $filtros['selecao01']["select"] = $this->form->select("selecao01", $this->traducao->get_leg05(), $selecao01, array(1 => 'Ativos', 2 => 'Inativos'), "", "submit_filtro(event,'submit')", "", false, "", "");




        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $pesquisa; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO


        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $tam_tab = "99%"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela que lista os itens


        /**
         * CONFIGURE VALIDAÇÕES
         */
        $validacao = array();


        /**
         * CONFIGURE OS MODAIS.
         */
        $modais = Array();

        $modais[0]['campos'] = Array('ac' => $ac_apaga);
        $modais[0]['acao'] = "apagar";
        $modais[0]['msg'] = $this->traducao->get_leg31();

        $modais[1]['campos'] = Array('ac' => $ac_ativa);
        $modais[1]['acao'] = "ativar";
        $modais[1]['msg'] = $this->traducao->get_leg32();

        $modais[2]['campos'] = Array('ac' => $ac_desativa);
        $modais[2]['acao'] = "desativar";
        $modais[2]['msg'] = $this->traducao->get_leg33();


        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "55%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "15%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "15%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "15%";
        $campos[3]["texto"] = $this->traducao->get_leg04();


        /**
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();

            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, 'ISO-8859-1');
            }


            /**
             * CONFIGURE o tooltip de INFO
             */
            $inf = Array();
            $infos = $this->criaInfo($inf);


            /**
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             */
            if ($dados['status_centro'] == "A") {
                $ad = "<span class=\"texto_conteudo_tabela\" style=\"text-align:left;\">
                            <a href=\"javascript:certeza_2(" . $dados['id_centro'] . ")\">
                                <img src=\"temas/" . $this->get_tema() . "/icones/ativar.png\" width=\"25\" height=\"25\" align=\"left\" border=\"0\" hspace=\"2\">                                
                                <font style=\"float:left;margin: 4px 0px 0px 0px;\" color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $this->traducao->get_leg11() . "</font>
                            </a>
                        </span>
                       ";
            } else {
                $ad = "<span class=\"texto_conteudo_tabela\" style=\"text-align:left;\">
                            <a href=\"javascript:certeza_1(" . $dados['id_centro'] . ")\">
                                <img src=\"temas/" . $this->get_tema() . "/icones/desativar.png\" width=\"25\" height=\"25\" align=\"left\"  border=\"0\" hspace=\"2\">                                
                                <font color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $this->traducao->get_leg12() . "</font>
                            </a>
                        </span>";
            }


            /**
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
             */
            $colunas = Array();

            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"] = "<font  color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['descricao'] . "</font>";

            $colunas[2]["alinhamento"] = "center";
            $colunas[2]["texto"] = "<span class=\"texto_conteudo_tabela\" style=\"text-align:left;\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_centro'] . ",'$ac_altera');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"left\" border=\"0\" hspace=\"2\">
                                            <font style=\"float:left;margin: 4px 0px 0px 0px;\"  color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $this->traducao->get_leg13() . "</font>
                                        </a>
                                    </span>";


            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = $ad;

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = "<span class=\"texto_conteudo_tabela\" style=\"text-align:left;\">
                                        <a href=\"javascript:certeza_0(" . $dados['id_centro'] . ")\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/apagar.png\" width=\"25\" height=\"25\" align=\"left\" border=\"0\" hspace=\"2\">
                                            <font style=\"float:left;margin: 4px 0px 0px 0px;\"  color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $this->traducao->get_leg14() . "</font>
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
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }

}

?>
