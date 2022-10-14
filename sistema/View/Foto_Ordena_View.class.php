<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Usuï¿½rios, filho de View
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
class Foto_Ordena_View extends View {

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
        $this->traducao->loadTraducao("9008", $this->get_idioma());
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
        $ac = base64_encode("Foto_Ordena");
        $ger_post = base64_encode("Foto_Gerencia");
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
        $hidden['campooculto'] = "";
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
        $componentes = Array("COUNTER");
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
        $retorno_nav .= "&ac=$ac_ger"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR

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
        $titulo_infoacao = $this->traducao->get_titulo_formulario03(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es
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
        $retorno_paginacao = "ac=$ac_ger"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&post=" . $this->post_request['id']; // CONTROLADOR

        /*
         *
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         * ***************INICIO
         */

        $id_pro = $this->post_request['id'];
        $tam_tab = "900"; // tamanho da tabela que lista os itens em %

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

        $campos[0]["tamanho_celula"] = "100";
        $campos[0]["texto"] = $this->traducao->get_leg02();

        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************FIM
         */
        $title_tab = "Ordenação de Fotos"; // tï¿½tulo da tabela
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
                $dados[$chave] = htmlspecialchars(stripslashes($valor));
            }
            $modais = Array();


            /*
             * ******************************************************************************************
             * CONFIGURE OS MODAIS.
             * ***************FIM
             */

            $div_id = $dados['id_foto'];
            $colunas = Array();
            $validacao = Array();


            $diretorio = "../sys/arquivos/img_galerias/";
            $nome = "orig_" . $dados['id_foto'] . "." . $dados['ext_img'];
            $mini = $dados['id_foto'] . "." . $dados['ext_img'];
            $tamanho = '180';

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "<li id=\"li_$div_id\"><div><img border=\"1\" src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=../arquivos/img_galerias/&arquivo=" . $mini . "&tamanho=" . $tamanho . "\" ></div></li>";
            $linhas[$i] = $colunas;
            /**
              /**   * ******************************************************************************************
             * CONFIGURE as colunas de cada linha da tabela.
             * ***************FIM
             */
            $i++;
        }
        $botoes = Array();

        $tpl = new Template("../Templates/Ordena_Fotos_Galeria.html");
        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         * ***************FIM
         */
        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();

        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";
        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJssemLightbox();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
//        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);
        $tpl->TABELALISTA = $this->criaDivLista($tam_tab, $linhas, $title_tab, $botoes, $titulo_infoacao, $texto_infoacao);
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);
        $tpl->TEMA = $this->get_tema();
        
        $add_fotos = base64_encode("Foto_Add_V");
        $ger_fotos = base64_encode("Foto_Gerencia");
        $ger_galerias = base64_encode("Galeria_Gerencia");
//        Monta os titulos e links da barra de navegação do upload de fotos
        $tpl->TITULO_ADD_FOTO = $this->traducao->get_leg06();
        $tpl->TITULO_GER_FOTO = $this->traducao->get_leg07();
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();
        $tpl->LINK_ADD_FOTO = $link . "&ac=$add_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_GER_FOTO = $link . "&ac=$ger_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ger_galerias";

        $tpl->BOTAO2 = $botoes[0] = $this->form->button("center", "Salvar");

        $tpl->show();
        /*
         * ************************************************************************************************************
         * MONTA O HTML E MOSTRA
         * ***************FIM
         */
    }

// fim do showView()
}

// Fim da classe
?>
