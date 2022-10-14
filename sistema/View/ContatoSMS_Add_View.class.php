<?php

/**
 * View de Inclusão de Avisos
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2019-20122, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package View
 */
class ContatoSMS_Add_View extends View {

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
        $this->traducao->loadTraducao("4006", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES 
         */
        $co = base64_encode("ContatoSMS_Control"); // CONTROLLER
        $ac = base64_encode("ContatoSMS_Add");
        $ac_v = base64_encode("ContatoSMS_Add_V");
        $ac_gerencia = base64_encode("ContatoSMS_Gerencia");
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
        $pagina = (isset($this->post_request['pagina'])) ? $this->post_request['pagina'] : 1;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $pagina; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR


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
        $col[0]['valign'] = "center";
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "75%";


        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO 
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();


        /**
         * CATEGORIA
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), TRUE);
        $colunas[1] = $this->form->select("id_grupo_sms", "Selecione", 0, $this->descricoes['desc_grupo_sms'], $align = "left", "", "", false, "");
        Array_push($validacao, $this->form->validar('id_grupo_sms', 'value', '==', '0', $this->traducao->get_leg33(), Array("id_grupo_sms"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        /**
         * NOME
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), FALSE);
        $colunas[1] = $this->form->textfield("nome_contato");
        $lin[] = $colunas;


        /**
         * TELEFONE
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), TRUE);
        $colunas[1] = $this->form->textfield("telefone_contato");
        Array_push($validacao, $this->form->validar('telefone_contato', 'value', '==', '""', $this->traducao->get_leg33(), Array("telefone_contato"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        /**
         * CONFIGURE BOTÕES 
         */
        $botoes = Array();
        $link = 'sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . $ac_gerencia . '';
        $botoes[0] = $this->form->button("center", "CANCELAR", "button", "location.href='$link'", "botao-danger", "margin: 10px;");
        $botoes[1] = $this->form->button("center", "SALVAR", "button", "validar()", "botao-success", "margin: 10px;");



        $js = '<script language="JavaScript" type="text/javascript">
                    window.onload = function(){
                        $("#telefone_contato").mask(SPMaskBehavior, spOptions);                    
                    };
                </script>';


        /* CONFIGURE O ARQUIVO DE TEMPLATE. */
        $tpl = new Template("../Templates/Formulario.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JS .= $js;
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }

}

?>
