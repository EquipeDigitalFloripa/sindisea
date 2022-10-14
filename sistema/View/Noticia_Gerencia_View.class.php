<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Gerenciamento dos Posts
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
class Noticia_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("3010", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Gerencia");
        $ac_altera = base64_encode("Noticia_Altera_V");
        $ac_tags = base64_encode("Noticia_Tag_V");
        $ac_relacao = base64_encode("Noticia_Relacionada_V");
        $ac_ativa = base64_encode("Noticia_Ativa");
        $ac_desativa = base64_encode("Noticia_Desativa");
        $ac_apaga = base64_encode("Noticia_Apaga");
        $ac_gerencia_foto = base64_encode("Noticia_Foto_Gerencia");
        $ac_destacar_slider = base64_encode("Produto_Destacar_Slider");
        $ac_rev_destacar_slider = base64_encode("Produto_Reverter_Destaque_Slider");
        $post = $ac;

        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();
        $hidden['categoria'] = (isset($this->post_request['categoria'])) ? $this->post_request['categoria'] : "";

        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("TOOLTIP");

        /**
         * CONFIGURE O NAV
         */
        $selecao01 = isset($this->post_request['selecao01']) ? $this->post_request['selecao01'] : 0;
        $selecao02 = isset($this->post_request['selecao02']) ? $this->post_request['selecao02'] : 0;
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $pesquisa = isset($this->post_request['pesquisa']) ? $this->post_request['pesquisa'] : "";

        $control_div = "NAO"; // SIM quando ï¿½ necessï¿½rio esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $pagina; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=" . $pesquisa; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        $retorno_nav .= "&selecao01=" . $selecao01;
        $retorno_nav .= "&selecao02=" . $selecao02;

        /**
         * CONFIGURE O BOX DE INFORMAï¿½ï¿½ES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es

        /**
         * CONFIGURE OS FILTROS. ATENCAO !!! ï¿½ NECESSï¿½RIO EFETUAR CONFIGURAï¿½ï¿½ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = Array();
        $filtros['pesquisa']["width"] = "40%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "right";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        $filtros['selecao01']["width"] = "30%"; // tamanho do campo
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = $this->traducao->get_titulo_formulario08(); // legenda ao lado do campo        
        $filtros['selecao01']["select"] = $this->form->select("selecao01", $this->traducao->get_leg44(), $selecao01, $this->descricoes['categoria_noticia'], "", "submit_filtro(event,'submit')", "", false, "", "");

        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do nï¿½mero de pï¿½ginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $pesquisa; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        $retorno_paginacao .= "&selecao01=" . $selecao01;
        $retorno_paginacao .= "&selecao02=" . $selecao02;

        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $tam_tab = "99%"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // tï¿½tulo da tabela que lista os itens


        /**
         * CONFIGURE VALIDAÇÕES
         */
        $validacao = Array();

        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "12%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "5%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "28%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "12%";
        $campos[3]["texto"] = $this->traducao->get_leg04();

        $campos[4]["tamanho_celula"] = "10%";
        $campos[4]["texto"] = $this->traducao->get_leg08();

        $campos[5]["tamanho_celula"] = "10%";
        $campos[5]["texto"] = $this->traducao->get_leg05();

        $campos[6]["tamanho_celula"] = "11%";
        $campos[6]["texto"] = $this->traducao->get_leg06();

        $campos[7]["tamanho_celula"] = "10%";
        $campos[7]["texto"] = $this->traducao->get_leg07();

        $ctr_noticia = new Noticia_Control($this->post_request);
        $ctr_rel_conteudo = new RelacaoConteudo_Control($this->post_request);

        /**
         * Seleciona os elementos que serï¿½o mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {
            $dados = $this->objetos[$i]->get_all_dados();
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, 'ISO-8859-1');
            }

            $data_noticia = $this->dat->get_dataFormat('BD', $dados['data_noticia'], 'DMA');
            $data_cadastro_noticia = $this->dat->get_dataFormat('BD', $dados['data_cadastro_noticia'], 'COMPLETO');
            $data_publicacao_noticia = $this->dat->get_dataFormat('BD', $dados['data_publicacao_noticia'], 'COMPLETO');
            $data_expiracao_noticia = ($dados['data_expiracao_noticia'] == '0000-00-00 00:00:00') ? "Nunca expira" : $this->dat->get_dataFormat('BD', $dados['data_expiracao_noticia'], 'COMPLETO');
            $data_atualizacao_noticia = $this->dat->get_dataFormat('BD', $dados['data_atualizacao_noticia'], 'COMPLETO');


            $dados_rel_conteudo = $ctr_rel_conteudo->Lista_Relacao_Conteudo(" AND id_noticia = " . $dados['id_noticia'] . "");
            $x = 0;
            $li_paginas = "";
            while ($x < count($dados_rel_conteudo)) {
                $li_paginas .= "<li>" . $this->descricoes['paginas'][$dados_rel_conteudo[$x]['id_conteudo']] . "</li>";
                $x++;
            }

            $inf = Array();
            $inf["" . $this->traducao->get_leg21() . ""] = "<b>$data_cadastro_noticia</b>";
            $inf["" . $this->traducao->get_leg22() . ""] = "<b>$data_publicacao_noticia</b>";
            $inf["" . $this->traducao->get_leg23() . ""] = "<b>$data_expiracao_noticia</b>";
            $inf["" . $this->traducao->get_leg24() . ""] = "<b>$data_atualizacao_noticia</b>";
            $inf["" . $this->traducao->get_leg25() . ""] = "<ul>" . $li_paginas . "</ul>";

            $infos = $this->criaInfo($inf);

            /**
             * CONFIGURE OS MODAIS.
             */
            $modais = Array();

            $modais[0]['campos'] = Array('ac' => $ac_desativa);
            $modais[0]['acao'] = "desativar";
            $modais[0]['msg'] = $this->traducao->get_leg31();

            $modais[1]['campos'] = Array('ac' => $ac_ativa);
            $modais[1]['acao'] = "ativar";
            $modais[1]['msg'] = $this->traducao->get_leg32();

            $modais[2]['campos'] = Array('ac' => $ac_apaga);
            $modais[2]['acao'] = "apagar";
            $modais[2]['msg'] = $this->traducao->get_leg33();

            $modais[3]['campos'] = Array('ac' => $ac_destacar_slider);
            $modais[3]['acao'] = "destacar_slider";
            $modais[3]['msg'] = $this->traducao->get_leg34();

            $modais[4]['campos'] = Array('ac' => $ac_rev_destacar_slider);
            $modais[4]['acao'] = "reverter_destacar_slider";
            $modais[4]['msg'] = $this->traducao->get_leg35();


            /**
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             */
            if ($dados['status_noticia'] == "I") {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                        <a href=\"javascript:certeza_1(" . $dados['id_noticia'] . ")\">
                            <img src=\"temas/" . $this->get_tema() . "/icones/desativar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg15() . "
                        </a>
                    </span>";
            } else {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                        <a href=\"javascript:certeza_0(" . $dados['id_noticia'] . ")\">
                            <img src=\"temas/" . $this->get_tema() . "/icones/ativar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg16() . "
                        </a>
                    </span>";
            }
            
            if ($dados['destaque_slider'] == "1") {
                $destaq = "<span class=\"texto_conteudo_tabela\">
                                <a href=\"javascript:certeza_4(" . $dados['id_noticia'] . ")\">
                                    <img src=\"temas/" . $this->get_tema() . "/icones/ativardestaque.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg19() . "
                                </a>
                            </span>";
            } else {
                $destaq = "<span class=\"texto_conteudo_tabela\">
                                <a href=\"javascript:certeza_3(" . $dados['id_noticia'] . ")\">
                                    <img src=\"temas/" . $this->get_tema() . "/icones/desativardestaque.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg20() . "
                                </a>
                            </span>";
            }

            /**
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR Vï¿½O ALGUNS TRATAMENTOS.
             */
            $colunas = Array();

            $img_destaque = $ctr_noticia->Pega_Foto_Destaque($dados['id_noticia']);
            $img = ($img_destaque == NULL) ? 'default.jpg' : $img_destaque[0]['id_foto'] . '.' . $img_destaque[0]['ext_foto'];
            $diretorio = "../sys/arquivos/img_noticias/";

            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = "<a title=\"Foto Capa do Posts: " . $dados['titulo_noticia'] . "\"href=\"" . $diretorio . $img . "\" rel=\"lightbox[roadtrip]\">
                                        <img src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=../arquivos/img_noticias/&arquivo=" . $img . "&tamanho=90 \" border=\"0\" >
                                     </a>                                     
                                     ";

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "$infos";

            $colunas[2]["alinhamento"] = "left";
            $colunas[2]["texto"] = "Categoria: <font size=\"2\" color=\"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $this->descricoes['categoria_noticia'][$dados['id_categoria_noticia']] . "</font><br><br>
                                    Título: <b><font size=\"2\" color=\"#003300\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $dados['titulo_noticia'] . "</font></b><br><br>                                    
                                    Visualizações: <font size=\"1\" color=\"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $dados['contador_noticia'] . "</font><br><br>
                                    Data da Notícia: <font size=\"1\" color=\"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $data_noticia . "</font>
                                    ";

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "<span class=\"texto_conteudo_tabela\">                                        
                                        <a href=\"javascript:submit_campo(" . $dados['id_noticia'] . ",'$ac_altera');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a><br /><hr />
                                        <span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_noticia'] . ",'$ac_tags');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg12() . "
                                        </a><br /><hr />
                                        <a href=\"javascript:submit_campo(" . $dados['id_noticia'] . ",'$ac_relacao');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg13() . "
                                        </a><br /><hr />                                        
                                    </span>
                                    ";
            
            
            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = $destaq;

            $colunas[5]["alinhamento"] = "center";
            $colunas[5]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_noticia'] . ",'$ac_gerencia_foto');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/icone_imagens.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>
                                            " . $this->traducao->get_leg14() . "
                                        </a>
                                    </span>";


            $colunas[6]["alinhamento"] = "center";
            $colunas[6]["texto"] = $ad;

            $colunas[7]["alinhamento"] = "center";
            $colunas[7]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:certeza_2(" . $dados['id_noticia'] . ")\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/apagar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg17() . "
                                        </a>
                                    </span>";





            $linhas[$i] = $colunas;

            $i++;
        }

        $tpl = new Template("../Templates/Gerencia.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);

        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];

        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");


        $tpl->show();
    }

}

?>
