<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Sliders, filho de View
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2015-2018, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/04/2025
 * @package View
 *
 */
class Slider_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("4042", $this->get_idioma());


        /*
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Slider_Control");
        $ac = base64_encode("Slider_Gerencia");
        $ac_ativa = base64_encode("Slider_Ativa");
        $ac_desativa = base64_encode("Slider_Desativa");
        $ac_altera = base64_encode("Slider_Altera_V");
        $ac_apaga = base64_encode("Slider_Apaga");
        $ac_gerencia_foto = base64_encode("FotoSlider_Gerencia");
        $post = $ac;


        /*
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = array();


        /*
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = array("TOOLTIP");


        /*
         * CONFIGURE O NAV
         */
        $pagina = (isset($this->post_request['pagina'])) ? $this->post_request['pagina'] : 1;
        $pesquisa = (isset($this->post_request['pesquisa'])) ? $this->post_request['pesquisa'] : "";
        $selecao01 = (isset($this->post_request['selecao01'])) ? $this->post_request['selecao01'] : "";
        $selecao02 = (isset($this->post_request['selecao02'])) ? $this->post_request['selecao02'] : "";

        $control_div = "NAO";
        $retorno_nav = "pagina=" . $pagina;
        $retorno_nav .= "&ac=$ac";
        $retorno_nav .= "&co=$co";
        $retorno_nav .= "&pesquisa=" . $pesquisa;
        $retorno_nav .= "&selecao01=" . $selecao01;
        $retorno_nav .= "&selecao02=" . $selecao02;


        /*
         * CONFIGURE O BOX DE INFORMAÇÃO
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01();
        $texto_infoacao = $this->traducao->get_titulo_formulario02();


        /*
         * CONFIGURE OS FILTROS.
         * ATENCAO !!! É NECESSESSÁRIO EFETUAR CONFIGURAÇÕES
         *   NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = array();

        $filtros['selecao01']["width"] = "30%";
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = $this->traducao->get_titulo_formulario10();
        $status = array(1 => "Ativos", 2 => "Inativos", 3 => "Apagados");
        $filtros['selecao01']["select"] = $this->form->select("selecao01", "Todos", $selecao01, $status, "");


        /*
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05();
        $retorno_paginacao = "ac=$ac";
        $retorno_paginacao .= "&co=$co";
        $retorno_paginacao .= "&pesquisa=" . $pesquisa;
        $retorno_paginacao .= "&selecao01=" . $selecao01;
        $retorno_paginacao .= "&selecao02=" . $selecao02;


        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $tam_tab = "950";
        $title_tab = $this->traducao->get_titulo_formulario04();


        /**
         * CONFIGURE VALIDAÇÕES
         */
        $validacao = Array();


        /**
         * CONFIGURE OS MODAIS.
         */
        $modais = array();

        $modais[0]['campos'] = array('ac' => $ac_apaga);
        $modais[0]['acao'] = "apagar";
        $modais[0]['msg'] = $this->traducao->get_leg31();

        $modais[1]['campos'] = array('ac' => $ac_desativa);
        $modais[1]['acao'] = "desativar";
        $modais[1]['msg'] = $this->traducao->get_leg32();

        $modais[2]['campos'] = array('ac' => $ac_ativa);
        $modais[2]['acao'] = "ativar";
        $modais[2]['msg'] = $this->traducao->get_leg33();


        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = array();
        $campos[0]["tamanho_celula"] = "25%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "15%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "15%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "15%";
        $campos[3]["texto"] = $this->traducao->get_leg04();

        $campos[4]["tamanho_celula"] = "15%";
        $campos[4]["texto"] = $this->traducao->get_leg05();

        $campos[5]["tamanho_celula"] = "15%";
        $campos[5]["texto"] = $this->traducao->get_leg06();

        

        /**
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         */
        $linhas = array();
        $i = 0;

        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();
            
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), null, "ISO-8859-1");
            }


            /**
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             */
            if ($dados['status_slider'] == "I") {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                      <a href=\"javascript:certeza_2(" . $dados['id_slider'] . ")\">
                        <img src=\"temas/" . $this->get_tema() . "/icones/ativar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\" /><br />
                        " . $this->traducao->get_leg15() . "
                      </a>
                    </span>";
            } else {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                      <a href=\"javascript:certeza_1(" . $dados['id_slider'] . ")\">
                        <img src=\"temas/" . $this->get_tema() . "/icones/desativar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\" /><br />
                        " . $this->traducao->get_leg16() . "
                      </a>
                    </span>";
            }

            /*
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÃO ALGUNS TRATAMENTOS.
             */
            $colunas = array();

            $colunas[0]["alinhamento"] = "left";
            $colunas[0]["texto"] = "<font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $dados['desc_slider'] . "</font>";

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "<font size=\"2\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $this->dat->get_dataFormat('BD', $dados['data_slider'], 'DMA') . "</font>";

            $colunas[2]["alinhamento"] = "center";
            $colunas[2]["texto"] = "
                <span class=\"texto_conteudo_tabela\">
                  <a href=\"javascript:submit_campo(" . $dados['id_slider'] . ",'$ac_altera');\">
                    <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\" /><br />
                    " . $this->traducao->get_leg11() . "
                  </a>
                </span>";

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "
                <span class=\"texto_conteudo_tabela\">
                  <a href=\"javascript:submit_campo(" . $dados['id_slider'] . ",'$ac_gerencia_foto');\">
                    <img src=\"temas/" . $this->get_tema() . "/icones/icone_imagens.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\" /><br />
                    " . $this->traducao->get_leg12() . "
                  </a>
                </span>";

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = $ad;
            
            $colunas[5]["alinhamento"] = "center";
            $colunas[5]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                      <a href=\"javascript:certeza_0(" . $dados['id_slider'] . ")\">
                                        <img src=\"temas/" . $this->get_tema() . "/icones/apagar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\" /><br />
                                        " . $this->traducao->get_leg16() . "
                                      </a>
                                    </span>";

            $linhas[$i] = $colunas;

            $i++;
        }


        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Gerencia.html");


        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->TITLE = $this->criaTitulo();
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

        $tpl->show();
    }

}

?>
