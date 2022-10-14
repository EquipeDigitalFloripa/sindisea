<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Gerenciamento dos GrupoSMSs
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2019-2022 EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package View
 */
class GrupoSMS_Gerencia_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {

        /* CONFIGURE O ID DE TRADUCAO DA VIEW */
        $this->traducao->loadTraducao("4010", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("GrupoSMS_Control"); // CONTROLLER
        $ac = base64_encode("GrupoSMS_Gerencia");
        $ac_add = base64_encode("GrupoSMS_Add_V");
        $ac_altera = base64_encode("GrupoSMS_Altera_V");
        $ac_ativa = base64_encode("GrupoSMS_Ativa");
        $ac_desativa = base64_encode("GrupoSMS_Desativa");
        $ac_apaga = base64_encode("GrupoSMS_Apaga");
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
        $selecao01 = (isset($this->post_request['selecao01'])) ? $this->post_request['selecao01'] : 1;
        $filtros = Array();
        $link = 'sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . $ac_add . '';
        $filtros['botao']["width"] = "100%"; // tamanho do campo
        $filtros['botao']["alinhamento"] = "left";
        $filtros['botao']["botao"] = $this->form->button("center", "Incluir Novo Grupo", "button", "location.href='$link'", "botao");

        $filtros['selecao01']["width"] = "30%"; // tamanho do campo
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = $this->traducao->get_titulo_formulario07(); // legenda ao lado do campo        
        $filtros['selecao01']["select"] = $this->form->select("selecao01", "Todos", $selecao01, array(1 => 'Grupos Ativos', 2 => 'Grupos Desativados'), "", "submit_filtro(event,'submit')", "", false, "", "");

        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario06(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $pesquisa; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO


        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $tam_tab = "960"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela que lista os itens


        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();

        $campos[0]["tamanho_celula"] = "40%";
        $campos[0]["texto"] = $this->traducao->get_leg01(); //dado

        $campos[1]["tamanho_celula"] = "15%";
        $campos[1]["texto"] = $this->traducao->get_leg02(); //alterar

        $campos[2]["tamanho_celula"] = "15%";
        $campos[2]["texto"] = $this->traducao->get_leg03(); //alterar

        $campos[3]["tamanho_celula"] = "15%";
        $campos[3]["texto"] = $this->traducao->get_leg05(); //ativar/desativar

        $campos[4]["tamanho_celula"] = "15%";
        $campos[4]["texto"] = $this->traducao->get_leg06(); //apagar



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
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {
            $dados = $this->objetos[$i]->get_all_dados();
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, "ISO-8859-1");
            }

            /**
             * CONFIGURE o tooltip de INFO
             */
            $inf = Array();
            $infos = $this->criaInfo($inf);


            /**
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             */
            if ($dados['status_grupo_sms'] == "A") {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                        <a href=\"javascript:certeza_2(" . $dados['id_grupo_sms'] . ")\">
                            <img src=\"temas/" . $this->get_tema() . "/icones/ativar.png\" width=\"25\" height=\"25\" align=\"middle\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg13() . "
                        </a>
                    </span>";
            } else {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                        <a href=\"javascript:certeza_1(" . $dados['id_grupo_sms'] . ")\">
                            <img src=\"temas/" . $this->get_tema() . "/icones/desativar.png\" width=\"25\" height=\"25\" align=\"middle\"  border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg14() . "
                        </a>
                    </span>";
            }


            /**
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
             */
            $colunas = Array();

            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = '<font size="2" color="#003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['descricao_grupo_sms'] . '</font>';


            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = '<font size="2" color="#003399" face="Verdana, Arial, Helvetica, sans-serif">' . $this->dat->get_dataFormat('BD', $dados['data_cadastro'], 'DMA') . '</font>';

            $colunas[2]["alinhamento"] = "center";
            $colunas[2]["texto"] = '<span class="texto_conteudo_tabela">
                                        <a href="javascript:submit_campo(' . $dados['id_grupo_sms'] . ',\'' . $ac_altera . '\');">
                                            <img src="temas/' . $this->get_tema() . '/icones/dados.png" width="25" height="25" align="center" border="0" hspace="2"><br>' . $this->traducao->get_leg11() . '
                                        </a>
                                    </span>';

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = $ad;

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = '<span class="texto_conteudo_tabela">
                                        <a href="javascript:certeza_0(' . $dados['id_grupo_sms'] . ');">
                                            <img src="temas/' . $this->get_tema() . '/icones/apagar.png" width="25" height="25" align="center" border="0" hspace="2"><br>' . $this->traducao->get_leg15() . '
                                        </a>
                                    </span>';

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
        $tpl->VALIDACAO = $this->criaValidacoes($validacao = array(), $this->form->get_resetcampos(), $post, $this->form->get_ajax());
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
