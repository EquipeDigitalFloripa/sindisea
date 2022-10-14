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
class Arquivo_Gerencia_View extends View {

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

        $this->traducao->loadTraducao("3032", $this->get_idioma());
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
        $co = base64_encode("Arquivo_Control"); // CONTROLLER
        $ac = base64_encode("Arquivo_Gerencia");
        $ac_apaga = base64_encode("Arquivo_Apaga");
        $ac_altera = base64_encode("Arquivo_Altera_V");
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
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações
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
        $filtros['pesquisa']["width"] = "100%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "center";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        /*
         *
         *
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
        /*
         *
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

        $campos[1]["tamanho_celula"] = "50%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "20%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "20%";
        $campos[3]["texto"] = $this->traducao->get_leg04();
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
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor));
            }


            $data_upload = $this->dat->get_dataFormat('BD', $dados['data_upload'], 'COMPLETO');

            /*
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

            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = $data_upload;

            
            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"] = "Categoria:&nbsp<strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $this->descricoes['categoria_arquivo'][$dados['id_categoria_arquivo']] . "</strong></font><br>
                                    Nome:&nbsp<strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $dados['nome_arquivo'] . "</strong></font><br>
                                    Tamanho:&nbsp<strong><font size=\"1\" color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $dados['tamanho'] . " Kb</strong></font><br>
                                    Descrição:&nbsp<strong><font size=\"1\" color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['desc_arquivo'] . "</strong></font>";

            $colunas[2]["alinhamento"] = "center";
            $colunas[2]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_arquivo'] . ",'$ac_altera');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\"  align=\"center\" border=\"0\" hspace=\"5\">" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:certeza_0(" . $dados['id_arquivo'] . ")\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/del.png\" width=\"15\" height=\"15\" align=\"center\" border=\"0\" hspace=\"10\">" . $this->traducao->get_leg12() . "
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
        //$tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);

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
