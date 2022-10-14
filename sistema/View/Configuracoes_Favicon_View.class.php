<?php

class Configuracoes_Favicon_View extends View {

    public function showView() {


        $this->traducao->loadTraducao("9999", $this->get_idioma());


        $co = base64_encode("Configuracoes_Control"); // CONTROLLER
        $ac = base64_encode("Configuracoes_Favicon");
        $gerencia = base64_encode("Configuracoes_Gerencia");
        $analytics = base64_encode("Configuracoes_Analytics_V");
        $metatages = base64_encode("Configuracoes_Metatags_V");
        $favicon = base64_encode("Configuracoes_Favicon_V");
        $post = $ac;


        $hidden = Array();


        $componentes = Array("COUNTER");

        /**
         * CONFIGURE O NAV
         */
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=$pagina"; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR



        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações


        /**
         * CONFIGURE VALIDAÇÃO.
         */
        $validacao = Array();
        
        $tam_tab = "900";
        $title_tab = $this->traducao->get_titulo_formulario10(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = "center";
        $col[0]['width'] = "30%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "70%";

        $dados = $this->objetos->get_all_dados();
        foreach ($dados as $chave => $valor) {
            $dados[$chave] = stripslashes($valor);
        }

        $lin = Array();
        $colunas = Array();


        $colunas[0] = $this->form->texto($this->traducao->get_leg21(), true);
        $colunas[1] = $this->form->textfield_FILE_2("favicon", "", 90, true, $this->traducao->get_leg22());
        $lin[] = $colunas;


        $botoes = Array();
        $botoes[0] = $this->form->button("center", "Salvar");


        $tpl = new Template("../Templates/Formulario_Config.html");


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

        $tpl->TEMA = $this->get_tema();
        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $tpl->TITULO_GERENCIA = $this->traducao->get_leg47();
        $tpl->TITULO_ANALYTICS = $this->traducao->get_leg49();
        $tpl->TITULO_METATAGS = $this->traducao->get_leg50();
        $tpl->TITULO_FAVICON = $this->traducao->get_leg48();

        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";
        $tpl->LINK_GERENCIA = $link . "&ac=$gerencia&id=" . $this->post_request['id'];
        $tpl->LINK_ANALYTICS = $link . "&ac=$analytics&id=" . $this->post_request['id'];
        $tpl->LINK_METATAGS = $link . "&ac=$metatages&id=" . $this->post_request['id'];
        $tpl->LINK_FAVICON = $link . "&ac=$favicon&id=" . $this->post_request['id'];


        $tpl->show();
    }

}

?>
