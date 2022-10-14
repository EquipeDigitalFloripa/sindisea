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
class Noticia_Relacionada_View extends View {

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
        $this->traducao->loadTraducao("3014", $this->get_idioma());

        function criaJs() {

            $js = "<script language=\"JavaScript\" >
                        $(document).ready(function(){                          
                            $('#titulo_noticia_relacionada').keydown(function(){                                
                                
                                $.post('ajax/Ajax_form.php', {titulo_noticia_relacionada:$(this).val()},
                                    function(valor){                                                                                
                                        $('#noticia_relacionada').html(valor);
                                    }
                                )
                            });
                        });
                    </script>
                    ";
            return $js;
        }

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Relacionada");
        $ac_v = base64_encode("Noticia_Relacionada_V");
        $ac_apaga_relacao = base64_encode("Noticia_Relacionada_Apaga");

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

        $titulo_infoacao2 = $this->traducao->get_titulo_formulario01(); // título do box de informações        
        $texto_infoacao2 = $this->traducao->get_titulo_formulario02(); // texto do box de informações


        /**
         * CONFIGURE A TABELA
         */
        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario05(); // título da tabela
        $title_tab2 = $this->traducao->get_titulo_formulario06(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "100%";


        /**
         * CONFIGURE OS MODAIS.
         */
        $modais = Array();
        $modais[0]['campos'] = Array('ac' => $ac);

        $modais[1]['campos'] = Array('ac' => $ac_apaga_relacao);
        $modais[1]['acao'] = "apagar";
        $modais[1]['msg'] = $this->traducao->get_leg31();


        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         */
        $lin = Array();
        $lin2 = Array();
        $colunas = Array();
        $colunas2 = Array();


        /**
         * DESCRIÇÃO DA TAG 
          s */
        $colunas[0] = $this->form->textfield("titulo_noticia_relacionada", "", 122, TRUE, $this->traducao->get_leg01());
        $colunas[0] .= "<div id=\"noticia_relacionada\" style=\"width:100%;float:left;margin-top:20px;\"></div>";

        $lin[] = $colunas;


        /**
         * CONFIGURA BOTÕES 
         */
        $botoes = Array();
        $botoes[0] = '<a href="sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . base64_encode("Noticia_Gerencia") . '">
                        ' . $this->form->button("center", "    Voltar  ", "button", FALSE, "botao", "margin:10px") . '
                     </a>';
        $botoes[1] = $this->form->button("center", "    Salvar  ", "button", "validar()", "botao", "margin:10px");


        /**
         * Instância um objeto para o controledor PostsTags_Control
         * Carrega os Objetos referente ao Posts
         */
        $ctr_relacao_noticia = new RelacaoNoticia_Control($this->post_request);
        $objetos = $ctr_relacao_noticia->Pega_Objets($id_noticia_corrente);

        if ($objetos == NULL) {
            $tabelalista = "";
        } else {

            /* CONFIGURE o topo da tabela que mostra a lista de elementos */
            $campos2 = Array();
            $campos2[0]["tamanho_celula"] = "10%";
            $campos2[0]["texto"] = "ID";

            $campos2[1]["tamanho_celula"] = "50%";
            $campos2[1]["texto"] = "TÍTULO";

            $campos2[2]["tamanho_celula"] = "30%";
            $campos2[2]["texto"] = "Data de Cadastro";

            $campos2[3]["tamanho_celula"] = "10%";
            $campos2[3]["texto"] = "Apagar";

            /* CRIA UMA INSTÂNCIA DO OBJETO POST_CONTROL */
            $ctrl_noticia = new Noticia_Control($this->post_request);

            /* Seleciona os elementos que serão mostrados e configura as linhas da tabela */
            $i = 0;
            while ($i < count($objetos)) {

                $dados = $objetos[$i]->get_all_dados();
                foreach ($dados as $chave => $valor) {
                    $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, "ISO-8859-1");
                }
                $dados_noticia = $ctrl_noticia->Pega_Dados_Noticia($dados['id_noticia']);
                $dado_noticia_relacionado = $ctrl_noticia->Pega_Dados_Noticia($dados['id_noticia_relacionado']);


                /* CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS. */
                $colunas2[0]["alinhamento"] = "center";
                $colunas2[0]["texto"] = $dado_noticia_relacionado['id_noticia'];

                $colunas2[1]["alinhamento"] = "left";
                $colunas2[1]["texto"] = $dado_noticia_relacionado['titulo_noticia'];

                $colunas2[2]["alinhamento"] = "center";
                $colunas2[2]["texto"] = $this->dat->get_dataFormat('BD', $dado_noticia_relacionado['data_noticia'], 'DMA');

                $colunas2[3]["alinhamento"] = "center";
                $colunas2[3]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:certeza_1(" . $dados['id_relacao'] . ")\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/apagar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\">
                                        </a>
                                    </span>";


                $lin2[$i] = $colunas2;
                $i++;
            }

            $tabelalista = $this->criaTabelaLista($tam_tab, $title_tab2, $campos2, $lin2, $titulo_infoacao2, $texto_infoacao2);
        }

        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Formulario2tb.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JS .= criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->TITLE_POST = $this->criaTituloPost($dados_noticia['titulo_noticia']);
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->TABELAFORM2 = $tabelalista;
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
    }

}

?>