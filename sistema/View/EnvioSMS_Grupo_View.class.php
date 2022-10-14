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
class EnvioSMS_Grupo_View extends View {

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
        $this->traducao->loadTraducao("4013", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES 
         */
        $co = base64_encode("EnvioSMS_Control"); // CONTROLLER
        $ac = base64_encode("EnvioSMS_Grupo");
        $ac_v = base64_encode("EnvioSMS_Grupo_V");
        $post = $ac;


        /**
         * CONFIGURE OS CAMPOS HIDDEN 
         */
        $hidden = Array();
        $hidden['return'] = TRUE;


        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR 
         */
        $componentes = Array("COUNTER", "TINYMCE_BASIC");


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
         * CONFIGURE A TABELA DE AVISOS
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
         * GRUPOS
         */
        $li = '';
        $i = 0;
        while ($i < count($this->descricoes['desc_grupo_sms'])) {
            $li .= '<li>' . $this->form->checkbox('ids_grupo_sms[]', '' . $this->descricoes['desc_grupo_sms'][key($this->descricoes['desc_grupo_sms'])] . '', 1, false, "center", "") . '</li>';
            next($this->descricoes['desc_grupo_sms']);
            $i++;
        }

        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), FALSE);
        $colunas[1] = '<ul id="lista_grupos">' . $li . '</ul>';
        $lin[] = $colunas;
        
        
        /**
         * TEXTO DO SMS
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), FALSE);
        $colunas[1] = $this->form->textarea_TINYMCE("texto_envio", "", "left");
        //$colunas[1] = $this->form->textarea('texto_envio', "", 100, 3, TRUE, 140, TRUE, $this->traducao->get_leg15(), "left", false);
        $lin[] = $colunas;


        /**
         * CONFIGURE BOTÕES 
         */
        $botoes = Array();
        $botoes[0] = $this->form->button("center", "ENVIAR", "button", "validar()", "botao-success", "margin: 10px;");


        /* CONFIGURE O ARQUIVO DE TEMPLATE. */
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
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }

}

?>
