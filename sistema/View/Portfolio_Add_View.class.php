<?php

/**
 * View de Inclusão de Portfolio
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
class Portfolio_Add_View extends View {

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
        $this->traducao->loadTraducao("2061", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Portfolio_Control"); // CONTROLLER
        $ac = base64_encode("Portfolio_Add");
        $ac_v = base64_encode("Portfolio_Add_V");
        $post = $ac;


        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();


        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");


        /**
         * CONFIGURE O NAV
         */
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        // a linha de retorno é adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        // $retorno_nav     .= "&pesquisa=".$this->post_request['pesquisa'];
        //  $retorno_nav     .= "&id=".$this->post_request['id'];


        /**
         * CONFIGURE O BOX DE INFORMAÇÔES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações


        /**
         * CONFIGURE A TABELA
         */
        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['width'] = "75%";


        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();

        /* NOME */
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), TRUE);
        $colunas[1] = $this->form->textfield("nome_portfolio");
        Array_push($validacao, $this->form->validar('nome_portfolio', 'value', '==', '""', $this->traducao->get_leg31(), Array("nome_portfolio"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        /* TELEFONE */
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), TRUE);
        $colunas[1] = $this->form->textfield("site_portfolio");
        Array_push($validacao, $this->form->validar('site_portfolio', 'value', '==', '""', $this->traducao->get_leg32(), Array("site_portfolio"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        /* IMAGEM */
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->textfield_FILE("imagem_portfolio", "", 70, true, $this->traducao->get_leg21());
        Array_push($validacao, $this->form->validar('imagem_portfolio', 'value', '==', '""', $this->traducao->get_leg33(), Array("imagem_portfolio"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $botoes = Array();
        $botoes[0] = $this->form->button("center");


        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Formulario.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
    }

}

?>
