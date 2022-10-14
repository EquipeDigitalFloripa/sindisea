<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Galerias, filho de View
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package View
 *
 */
class Galeria_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("3042", $this->get_idioma());
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
        $co = base64_encode("Galeria_Control"); // CONTROLLER
        $ac = base64_encode("Galeria_Gerencia");
        $ac_ativa = base64_encode("Galeria_Ativa");
        $ac_desativa = base64_encode("Galeria_Desativa");
        $ac_altera = base64_encode("Galeria_Altera_V");
        $ac_altera_img = base64_encode("Galeria_Altera_Img_V");
        $ac_destacar = base64_encode("Galeria_Destacar");
        $ac_rev_destacar = base64_encode("Galeria_Reverter_Destaque");
        $ac_gerencia_foto = base64_encode("Foto_Gerencia");
        $post = $ac;


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

        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         * ***************INICIO
         */
        $componentes = Array("TOOLTIP");


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
        $control_div = "NAO"; // SIM quando ï¿½ necessï¿½rio esconder alguma div para mostrar modal
        // a linha de retorno ï¿½ adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=" . $this->post_request['pesquisa']; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        $retorno_nav .= "&selecao01=" . $this->post_request['selecao01'];
        $retorno_nav .= "&selecao02=" . $this->post_request['selecao02'];

        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAï¿½ï¿½ES
         * ***************INICIO
         */
        $tam_infoacao = 500; // tamanho em px do box de informaï¿½ï¿½es
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es
        $mostrar_obrig = false; // mostrar ou nï¿½o o * de campos obrigatï¿½rios
        $texto_obrig = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio
        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAï¿½ï¿½ES
         * ***************FIM
         */

        /*
         * ******************************************************************************************
         * CONFIGURE OS FILTROS. ATENCAO !!! ï¿½ NECESSï¿½RIO EFETUAR CONFIGURAï¿½ï¿½ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         * ***************INICIO
         */
        $filtros = Array();
        $filtros['pesquisa']["width"] = "40%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "right";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        $filtros['selecao01']["width"] = "30%"; // tamanho do campo
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = $this->traducao->get_titulo_formulario10(); // legenda ao lado do campo
        $status = Array(1 => $this->traducao->get_leg42(), 2 => $this->traducao->get_leg43());
        $filtros['selecao01']["select"] = $this->form->select("selecao01", $this->traducao->get_leg41(), $this->post_request['selecao01'], $status, "");

        /*
         * ******************************************************************************************
         * CONFIGURE OS FILTROS. ATENCAO !!! ï¿½ NECESSï¿½RIO EFETUAR CONFIGURAï¿½ï¿½ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************INICIO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do nï¿½mero de pï¿½ginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $this->post_request['pesquisa']; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        $retorno_paginacao .= "&selecao01=" . $this->post_request['selecao01'];
        $retorno_paginacao .= "&selecao02=" . $this->post_request['selecao02'];
        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         * ***************INICIO
         */
        $tam_tab = "99%"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // tï¿½tulo da tabela que lista os itens
        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************INICIO
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "20%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "5%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "35%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "13%";
        $campos[3]["texto"] = $this->traducao->get_leg04();

        $campos[4]["tamanho_celula"] = "13%";
        $campos[4]["texto"] = $this->traducao->get_leg05();

        $campos[5]["tamanho_celula"] = "13%";
        $campos[5]["texto"] = $this->traducao->get_leg06();

        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * Seleciona os elementos que serï¿½o mostrados e configura as linhas da tabela
         * ***************INICIO
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();

            foreach ($dados as $chave => $valor) {
                $dados[$chave] = stripslashes($valor);
            }

            $titulo = strip_tags($dados['titulo']);
            $categoria = htmlspecialchars($this->descricoes['nome_categoria'][$dados['id_categoria_galeria']], null, "ISO-8859-1");
//            $chamada = strip_tags(nl2br($dados['chamada']));
            $datas = $this->dat->get_dataFormat('BD', $dados['data_galeria'], 'DMA');
//            $texto = strip_tags($dados['texto']);
            $tam_str = 52;

            if (strlen($titulo) > $tam_str) {
                $titulo = htmlspecialchars(substr($titulo, 0, $tam_str), null, "ISO-8859-1");
                $titulo = "$titulo ...";
            } else {
                $titulo = htmlspecialchars($titulo, null, "ISO-8859-1");
            }

//            if (strlen($chamada) > $tam_str) {
//                $chamada = htmlspecialchars(substr($chamada, 0, $tam_str), null, "ISO-8859-1");
//                $chamada = "$chamada ...";
//            } else {
//                $chamada = htmlspecialchars($chamada, null, "ISO-8859-1");
//            }

//            if (strlen($texto) > $tam_str) {
//                $texto = substr($texto, 0, $tam_str);
//                $texto = "$texto ...";
//            } else {
//                $texto = $texto;
//            }

            $fotos = $this->descricoes['total_fotos'][$dados['id_galeria']];
            $inf = Array();
            $inf["" . $this->traducao->get_leg21() . ""] = $titulo;
            $inf["" . $this->traducao->get_leg22() . ""] = $datas;
            $inf["" . $this->traducao->get_leg25() . ""] = $fotos;
            $infos = $this->criaInfo($inf);

            $modais = Array();

            $modais[0]['campos'] = Array('ac' => $ac_destacar);
            $modais[0]['acao'] = "destacar";
            $modais[0]['msg'] = $this->traducao->get_leg31();

            $modais[1]['campos'] = Array('ac' => $ac_rev_destacar);
            $modais[1]['acao'] = "reverter_destacar";
            $modais[1]['msg'] = $this->traducao->get_leg32();

            $modais[2]['campos'] = Array('ac' => $ac_desativa);
            $modais[2]['acao'] = "desativar";
            $modais[2]['msg'] = $this->traducao->get_leg33();

            $modais[3]['campos'] = Array('ac' => $ac_ativa);
            $modais[3]['acao'] = "ativar";
            $modais[3]['msg'] = $this->traducao->get_leg34();


            if ($dados['status_galeria'] == "I") {
                $ad = "<span class=\"texto_conteudo_tabela\">
                            <a href=\"javascript:certeza_3(" . $dados['id_galeria'] . ")\">
                                <img src=\"temas/" . $this->get_tema() . "/icones/ativar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg15() . "
                            </a>
                        </span>";
            } else {
                $ad = "<span class=\"texto_conteudo_tabela\">
                            <a href=\"javascript:certeza_2(" . $dados['id_galeria'] . ")\">
                                <img src=\"temas/" . $this->get_tema() . "/icones/desativar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg16() . "
                            </a>
                        </span>";
            }

            if ($dados['destaque'] == "1") {
                $destaq = "<span class=\"texto_conteudo_tabela\">
                                <a href=\"javascript:certeza_1(" . $dados['id_galeria'] . ")\">
                                    <img src=\"temas/" . $this->get_tema() . "/icones/ativardestaque.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg19() . "
                                </a>
                            </span>";
            } else {
                $destaq = "<span class=\"texto_conteudo_tabela\">
                                <a href=\"javascript:certeza_0(" . $dados['id_galeria'] . ")\">
                                    <img src=\"temas/" . $this->get_tema() . "/icones/desativardestaque.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg20() . "
                                </a>
                            </span>";
            }


            $colunas = Array();
                        
            $diretorio = "../sys/arquivos/img_galerias/";
            if ($this->descricoes['foto_destaque'][$dados['id_galeria']]) {
                $nome = $this->descricoes['foto_destaque'][$dados['id_galeria']];
            } else {
                $nome = "default.jpg";
            }
            $src_imagem = $diretorio . $nome;

            $colunas[0]["alinhamento"] = "center";
            if ($this->descricoes['total_fotos'][$dados['id_galeria']] > 0) {
                $colunas[0]["texto"] = "
                  <a title=\"Foto destaque da Galeria:" . $dados['titulo'] . "\"href=\"$src_imagem\" rel=\"lightbox\">
                    <img src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=../arquivos/img_galerias/&arquivo=" . $nome . "&tamanho=150\" border=\"0\" >
                  </a>";
            } else {
                $colunas[0]["texto"] = "
                    <img src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=../arquivos/img_galerias/&arquivo=" . $nome . "&tamanho=150\" border=\"0\" >
                ";
            }

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "$infos";

            $colunas[2]["alinhamento"] = "left";
            $colunas[2]["texto"] = "
                <p>Título:&nbsp<strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $titulo . "</strong></font></p>
                <p>Categoria: <strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $categoria . "</font></strong></p>
                <p>Data:&nbsp<strong><font size=\"1\" color = \"#000000\" face=\"Verdana, Arial, Helvetica, sans-serif\"> " . $datas . "</strong></font></p>";

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_galeria'] . ",'$ac_altera');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_galeria'] . ",'$ac_gerencia_foto');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/icone_imagens.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg12() . "
                                        </a>
                                    </span>";

//            $colunas[5]["alinhamento"] = "center";
//            $colunas[5]["texto"] = $destaq;

            $colunas[5]["alinhamento"] = "center";
            $colunas[5]["texto"] = $ad;


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
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
    }
}
?>
