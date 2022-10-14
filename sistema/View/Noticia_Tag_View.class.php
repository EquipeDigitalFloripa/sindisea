<?php

/**
 * View de Inclusão de Tags no Posts
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
class Noticia_Tag_View extends View {

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
        $this->traducao->loadTraducao("3013", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Tag");
        $ac_v = base64_encode("Noticia_Tag_V");

        $post = $ac;


        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();
        $hidden['id_noticia_corrente'] = $id_noticia_corrente = (isset($this->post_request['id_noticia_corrente'])) ? $this->post_request['id_noticia_corrente'] : $this->post_request['id'];        


        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("CALENDAR");
        $componentes[] = "TINYMCE_EXACT";
        $componentes[] = "COUNTER";


        /**
         * CONFIGURE O NAV
         */
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        // a linha de retorno é adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR


        /**
         * CONFIGURE O BOX DE INFORMAÇÔES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações

        $titulo_infoacao2 = $this->traducao->get_titulo_formulario03(); // título do box de informações
        $texto_infoacao2 = $this->traducao->get_titulo_formulario04(); // texto do box de informações


        /**
         * CONFIGURE A TABELA
         */
        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario05(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = "center";
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "55%";
        $col[2]['color'] = "#EBEBEB";
        $col[2]['nowrap'] = false;
        $col[2]['valign'] = "center";
        $col[2]['width'] = "10%";


        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();
        $modais = Array();


        /* INSERIR NOTA TAG */
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), FALSE);
        $colunas[1] = $this->form->textfield("desc_tag", "", 60);
        $colunas[2] = $this->form->button("center", "   Adicionar TAG   ", "button", "validar()", "botao", "height:25px;font-size:10pt;");
        $lin[] = $colunas;


        /**
         * Instância um objeto para o controledor PostssTags_Control
         * Carrega os Objetos referente ao Posts
         */
        $id_noticia = (isset($this->post_request['id_noticia_corrente'])) ? $this->post_request['id_noticia_corrente'] : $this->post_request['id'];
        $ctr_tag_noticia = new TagNoticia_Control($this->post_request);
        $dados_tags = $ctr_tag_noticia->Pega_Tags_Noticia($id_noticia);
        $array_tags = $ctr_tag_noticia->Solicita_Lista_Tags();

        $ctrl_noticia = new Noticia_Control($this->post_request);
        $dados_noticia = $ctrl_noticia->Pega_Dados_Noticia($id_noticia);

        if ($array_tags == NULL) {
            $tabelalista = "";
        } else {

            $title_tab2 = $this->traducao->get_titulo_formulario06(); // título da tabela
            $col2[0]['color'] = "#FFFFFF";
            $col2[0]['nowrap'] = false;
            $col2[0]['valign'] = "center";
            $col2[0]['width'] = "25%";

            $lin2 = Array();
            $colunas2 = Array();

            /* Seleciona os elementos que serão mostrados e configura as linhas da tabela */
            $tags_noticias = "";
            for ($i = 0; $i < count($array_tags); $i++) {
                $leg = htmlspecialchars(stripslashes($array_tags[$i]['desc_tag']), NULL, "ISO-8859-1");

                if (in_array($array_tags[$i]['id_tag'], $dados_tags)) {
                    $tags_noticias .= "<li>" . $this->form->checkbox("tag_noticia[]", $leg, $array_tags[$i]['id_tag'], TRUE, "left") . "</li>";
                } else {
                    $tags_noticias .= "<li>" . $this->form->checkbox("tag_noticia[]", $leg, $array_tags[$i]['id_tag'], FALSE, "left") . "</li>";
                }
            }

            /* CHECKBOS DAS TAGS */
            $colunas2[0] = "
                <style>
                    ul.lista_tags{width:100%;padding:0px;float:left;margin:0px;list-style:none;align-items: top;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: space-between;}
                    ul.lista_tags li{width:20%;margin: 10px 10px;}
                </style>
                <ul class=\"lista_tags\">$tags_noticias</ul>";
            $lin2[] = $colunas2;


            /* CONFIGURA BOTÕES */
            $botoes = Array();
            $botoes[0] = '<a href="sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . base64_encode("Noticia_Gerencia") . '">
                        ' . $this->form->button("center", "    Voltar  ", "button", FALSE, "botao", "margin:10px") . '
                     </a>';
            $botoes[1] = $this->form->button("center", "    Salvar  ", "button", "validar()", "botao", "margin:10px");

            $tabelalista = $this->criaTabelaForm($tam_tab, $title_tab2, $col2, $lin2, $botoes, "", $titulo_infoacao2, $texto_infoacao2);
        }

        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Formulario2tb.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->TITLE_POST = $this->criaTituloPost("Notícia: " . $dados_noticia['titulo_noticia']);
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, "", "", $titulo_infoacao, $texto_infoacao);
        $tpl->TABELAFORM2 = $tabelalista;
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }

}

?>