<?php

/**
 * View de alteração de Senha de Usuário
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 01/10/2009
 * @Ultima_Modif 01/10/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package View
 *
 */
class Login_View extends View {

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
        $this->traducao->loadTraducao("2000", $this->get_idioma());
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
        $enc = new Encripta();
        $post = $enc->md5_encrypt("Login");
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
        $componentes = Array();

        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************INICIO
         */
        $tam_tab = "250"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario01(); // título da tabela
        $col[0]['color'] = "rgba(255,255,255,0.0)";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = 'center';
        $col[0]['width'] = "10%";
        $col[1]['color'] = "rgba(255,255,255,0.0)";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = 'center';
        $col[1]['width'] = "90%";
        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************FIM
         */

        /*
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         * ***************INICIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();

        $colunas[0] = "";
        $colunas[1] = $this->form->textfield_login("login", "", 30, true, "Usuário:", null, 'center', '', "width:200px; float:left;");
        Array_push($validacao, $this->form->validar('login', 'value', '==', '""', $this->traducao->get_leg31(), Array("login"), $this->get_tema(), $this->get_idioma()));
        $lin[0] = $colunas;

        $colunas[0] = "";
        $colunas[1] = $this->form->password_login("senha", "", 30, true, "Senha:", null, 'center', "width:200px; float:left;");
        Array_push($validacao, $this->form->validar('senha', 'value', '==', '""', $this->traducao->get_leg32(), Array("senha"), $this->get_tema(), $this->get_idioma()));
        $lin[1] = $colunas;

        $botoes = Array();
        $botoes[0] = $this->form->button("center", " OK ", "button", "validar()", "botao", "border-top-left-radius:50px; border-top-right-radius:50px; border-bottom-left-radius:50px; border-bottom-right-radius:50px; background:white; border:0; width:24px; font-size:8px; height:24px; margin-top:-1px; cursor:pointer;");
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
        $tpl = new Template("../Templates/Login.html");
        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         * ***************FIM
         */
        $temas = $this->get_tema();

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = "<link href=\"temas/$temas/site_capa.css\" rel=\"stylesheet\" type=\"text/css\" /><link rel=\"stylesheet\" href=\"temas/" . $this->get_tema() . "/modal/modal-message.css\" type=\"text/css\">\n";
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post);
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaFormLogin($tam_tab, $title_tab, $col, $lin, $botoes, "", 0, 0, "rgba(255,255,255,0)", "rgba(255,255,255,0)", "margin-top:-10px;");
        $tpl->RODAPE = $this->criaRodapeLogin('#fff');
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

?>
