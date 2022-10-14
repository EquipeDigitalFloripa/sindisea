<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Contatos, filho de View
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2017-2020, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 04/07/2017
 * @package View
 */
class Contato_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("2005", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Contato_Control"); // CONTROLLER
        $ac = base64_encode("Contato_Gerencia");
        $ac_apaga = base64_encode("Contato_Apaga");
        $ac_altera = base64_encode("Contato_Altera_V");
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
         * CONFIGURE AS VALIDAÇÕES
         */
        $validacao = array();

        /**
         * CONFIGURE O NAV
         */
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $pesquisa = isset($this->post_request['pesquisa']) ? $this->post_request['pesquisa'] : "";
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=$pagina"; // NAO MODIFIQUE ESTA LINHA
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
        $filtros = Array();
        $filtros['pesquisa']["width"] = "100%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "right";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario08(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $pesquisa; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO

        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $tam_tab = "99%"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela que lista os itens

        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "30%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "15%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "15%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "15%";
        $campos[3]["texto"] = $this->traducao->get_leg05();

        $campos[4]["tamanho_celula"] = "9%";
        $campos[4]["texto"] = $this->traducao->get_leg06();

        $campos[5]["tamanho_celula"] = "6%";
        $campos[5]["texto"] = $this->traducao->get_leg07();


        /**
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), null, 'ISO-8859-1');
            }

            $telefone = substr_replace($dados['telefone'], '(', 0, 0);
            $telefone = substr_replace($telefone, ')', 3, 0);
            $telefone = substr_replace($telefone, '-', -4, 0);
            $telefone = substr_replace($telefone, ' ', 4, 0);

            /**
             * CONFIGURE o tooltip de INFO
             */
            $inf = Array();
            $infos = $this->criaInfo($inf);

            /**
             * CONFIGURE OS MODAIS.
             */
            $modais = Array();

            $modais[0]['campos'] = Array('ac' => $ac_apaga);
            $modais[0]['acao'] = "apagar";
            $modais[0]['msg'] = $this->traducao->get_leg31();

            /**
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
             */
            $colunas = Array();

            $tipo_servico = ($dados['tipo_servico'] == '0') ? "" : $dados['tipo_servico'];
                        
            $colunas[0]["alinhamento"] = "left";
            $colunas[0]["texto"] = "Data: <font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $this->dat->get_dataFormat('BD', $dados['data_contato'], 'DMA') . "</font><br>
                                    Nome: <font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['nome'] . "</font><br>
                                    E-mail: <font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['email'] . "</font><br>
                                    Telefone: <font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $telefone . "</font>";

            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"] = "<font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['cidade'] . '/' . $dados['estado'] . "</font>";

            $colunas[2]["alinhamento"] = "left";
            $colunas[2]["texto"] = "<font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['assunto'] . "</font><br>
                    <font size=\"1\" color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $tipo_servico . "</font>
                    ";

            $colunas[3]["alinhamento"] = "left";
            $colunas[3]["texto"] = "<font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['onde_conheceu'] . "</font>";

            $colunas[4]["alinhamento"] = "left";
            $colunas[4]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_contato'] . ",'$ac_altera');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";

            $colunas[5]["alinhamento"] = "left";
            $colunas[5]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:certeza_0(" . $dados['id_contato'] . ")\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/apagar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg15() . "
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
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

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
