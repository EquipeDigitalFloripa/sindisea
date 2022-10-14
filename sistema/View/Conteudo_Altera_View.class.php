<?php

/**
 * View de Inclusão de Usuário
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 01/10/2009
 * @Ultima_Modif 04/04/2014 por Marcio Figueredo
 *
 *
 * @package View
 *
 */
class Conteudo_Altera_View extends View {

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
        $this->traducao->loadTraducao("3053", $this->get_idioma());
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
        $ac_01 = base64_encode("Conteudo_Altera");
        $ac_01v = base64_encode("Conteudo_Altera_V");
        $post = $ac_01;
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
        $hidden['url_amigavel_ok'] = 'sim';

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
        $retorno_nav .= "&ac=$ac_01v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        // $retorno_nav     .= "&pesquisa=".$this->post_request['pesquisa'];
        //  $retorno_nav     .= "&id=".$this->post_request['id'];
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
        $mostrar_obrig = true; // mostrar ou não o * de campos obrigatórios
        $texto_obrig = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio
        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************INICIO
         */
        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "45%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['width'] = "55%";

        $tam_tab2 = "900"; // tamanho da tabela em px ou em %
        $title_tab2 = $this->traducao->get_titulo_formulario05(); // título da tabela
        $col2[0]['color'] = "#FFFFFF";
        $col2[0]['nowrap'] = false;
        $col2[0]['width'] = "45%";
        $col2[1]['color'] = "#EBEBEB";
        $col2[1]['nowrap'] = false;
        $col2[1]['width'] = "55%";
        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************FIM
         */
        $dados = $this->objetos->get_all_dados();

        // aplica regra de recebimento no array de dados
        foreach ($dados as $chave => $valor) {
            $dados[$chave] = stripslashes($valor);
        }


        /*
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         * ***************INICIO
         */

        $lin = Array();
        $colunas = Array();
        $validacao = Array();

        $menu = Array(1 => "Não", 2 => "Sim");

        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), true);
        $colunas[1] = $this->form->select("menu", $this->traducao->get_leg21(), $dados['menu'], $menu);
        Array_push($validacao, $this->form->validar('menu', 'value', '==', '"0"', $this->traducao->get_leg33(), Array('menu'), $this->get_tema(), $this->get_idioma()));
        $lin[0] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true);
        $colunas[1] = $this->form->textfield("nome_link", stripcslashes($dados['nome_link']), 30, true, $this->traducao->get_leg22(), 40);
        Array_push($validacao, $this->form->validar('nome_link', 'value', '==', '""', $this->traducao->get_leg31(), Array("nome_link"), $this->get_tema(), $this->get_idioma()));
        $lin[1] = $colunas;

        //keywords
        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), true);
        $colunas[1] = $this->form->textarea("keywords", stripcslashes($dados['keywords']), 50, 4, FALSE, '', FALSE, '');
        $lin[2] = $colunas;

        //title url
        $colunas[0] = $this->form->texto($this->traducao->get_leg06(), true);
        $colunas[1] = $this->form->textfield("title_url", stripcslashes($dados['title_url']), 30, true, $this->traducao->get_leg22(), 40);
        Array_push($validacao, $this->form->validar('title_url', 'value', '==', '""', $this->traducao->get_leg31(), Array("title_url"), $this->get_tema(), $this->get_idioma()));
        $lin[3] = $colunas;


        $lin2 = Array();
        $colunas[0] = $this->form->texto($this->traducao->get_leg07(), true);
        // $colunas[1] = $this->form->textfield("url_amigavel", $this->post_request['url_amigavel'], 30, true, $this->traducao->get_leg23(), 40);
        $colunas[1] = $this->form->AJAX_existe_registro("url_amigavel", $dados['url_amigavel'], 30, true, $this->traducao->get_leg23(), $this->traducao->get_leg27());
        Array_push($validacao, $this->form->validar('url_amigavel', 'value', '==', '""', $this->traducao->get_leg31(), Array("url_amigavel"), $this->get_tema(), $this->get_idioma()));
        Array_push($validacao, $this->form->validar('url_amigavel_ok', 'value', '!=', '"sim"', $this->traducao->get_leg33(), Array("url_amigavel"), $this->get_tema(), $this->get_idioma()));
        $lin2[0] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg08(), true);
        $colunas[1] = $this->form->textfield("arquivo_pagina", $dados['arquivo_pagina'], 30, true, $this->traducao->get_leg24(), 40);
        Array_push($validacao, $this->form->validar('arquivo_pagina', 'value', '==', '""', $this->traducao->get_leg31(), Array("arquivo_pagina"), $this->get_tema(), $this->get_idioma()));
        $lin2[1] = $colunas;

        $botoes = Array();
        $botoes2 = Array();
        $botoes2[0] = $this->form->button("center");
        /**
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
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
        $tpl = new Template("../Templates/Formulario2tb.html");
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
        //$tpl->MODAIS      = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);


        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->TABELAFORM2 = $this->criaTabelaForm($tam_tab2, $title_tab2, $col2, $lin2, $botoes2, "", $titulo_infoacao, $texto_infoacao);

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

?>
