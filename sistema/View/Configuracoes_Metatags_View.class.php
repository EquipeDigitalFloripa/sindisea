<?php

class Configuracoes_Metatags_View extends View {

    public function showView() {


        $this->traducao->loadTraducao("9999", $this->get_idioma());


        $co = base64_encode("Configuracoes_Control"); // CONTROLLER
        $ac = base64_encode("Configuracoes_Metatags");
        $gerencia = base64_encode("Configuracoes_Gerencia");
        $analytics = base64_encode("Configuracoes_Analytics_V");
        $metatages = base64_encode("Configuracoes_Metatags_V");
        $favicon = base64_encode("Configuracoes_Favicon_V");
        $post = $ac;


        $hidden = Array();


        $componentes = Array("COUNTER");


        $control_div = "NAO";
        $retorno_nav = "pagina=" . $this->post_request['pagina'];
        $retorno_nav .= "&ac=$ac";
        $retorno_nav .= "&co=$co";


        $titulo_infoacao = $this->traducao->get_titulo_formulario03(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações

        /**
         * CONFIGURE VALIDAÇÃO.
         */
        $validacao = Array();

        $tam_tab = "900";
        $title_tab = $this->traducao->get_titulo_formulario09(); // título da tabela
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

        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true);
        $colunas[1] = $this->form->textfield("title", $dados['title'], 80, TRUE, "Define um título para o site nas páginas institucionais.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true);
        $colunas[1] = $this->form->textfield("content_type", $dados['content_type'], 80, TRUE, "Declara a(s) linguagem(ns) natural(is) do documento.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->textfield("pragma", $dados['pragma'], 80, TRUE, "Faz com que o navegador não armazene a página em cache.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), true);
        $colunas[1] = $this->form->textfield("cache_control", $dados['cache_control'], 80, TRUE, "Serve para informar ao buscador se a página pode ser armazenada em cache.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), true);
        $colunas[1] = $this->form->textfield("author", $dados['author'], 80, TRUE, "Serve para identificar qual o nome do autor da página.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg06(), true);
        $colunas[1] = $this->form->textfield("content_language", $dados['content_language'], 80, TRUE, "Utilizado para declarar as linguagens utilizadas no conteúdo da página.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg07(), true);
        $colunas[1] = $this->form->textfield("reply_to", $dados['reply_to'], 80, TRUE, "Especifica um endereço de e-mail para entrar em contato com o(s) responsável(is) pelo site.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg08(), true);
        $colunas[1] = $this->form->textfield("url", $dados['url'], 80, TRUE, "Mostra aos buscadores qual a url principal do seu site.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg09(), true);
        $colunas[1] = $this->form->textfield("copyright", $dados['copyright'], 80, TRUE, "Declara o direito autoral da página.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg10(), true);
        $colunas[1] = $this->form->textfield("owner", $dados['owner'], 80, TRUE, "", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg11(), true);
        $colunas[1] = $this->form->textfield("rating", $dados['rating'], 80, TRUE, "Esta tag funciona para classificar a página por censura.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg12(), true);
        $colunas[1] = $this->form->textfield("robots", $dados['robots'], 80, TRUE, "Especifica informações de indexação para os robôs de busca.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg13(), true);
        $colunas[1] = $this->form->textfield("googlebot", $dados['googlebot'], 80, TRUE, "É uma forma de comunicação direta com o robô do Google", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg14(), true);
        $colunas[1] = $this->form->textfield("classification", $dados['classification'], 80, TRUE, "Serve para informar ao robô a categoria do documento.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg15(), true);
        $colunas[1] = $this->form->textfield("revisit_after", $dados['revisit_after'], 80, TRUE, "Informa ao robô de quanto em quanto tempo a página é atualizada.", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg16(), true);
        $colunas[1] = $this->form->textfield("geo_placename", $dados['geo_placename'], 80, TRUE, "", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg17(), true);
        $colunas[1] = $this->form->textfield("geo_country", $dados['geo_country'], 80, TRUE, "", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg18(), true);
        $colunas[1] = $this->form->textfield("dc_language", $dados['dc_language'], 80, TRUE, "", NULL, "left", "", "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg19(), true);        
        $colunas[1] = $this->form->textarea("description", $dados['description'], 80, 3, false, 250, TRUE, "Contém uma descrição da página.", "left", false);
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg20(), true);
        $colunas[1] = $this->form->textarea("keywords", $dados['keywords'], 80, 3, false, 250, TRUE, "Indexar os documentos juntamente com informações encontradas em seu título e body.", "left", false);        
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
