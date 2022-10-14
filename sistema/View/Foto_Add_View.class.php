<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Usuários, filho de View
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
class Foto_Add_View extends View {

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
        $this->traducao->loadTraducao("3048", $this->get_idioma());
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
        $ac = base64_encode("Foto_Gerencia");
        $ac_apaga = base64_encode("Foto_Apaga");
        $ac_altera = base64_encode("Foto_Salva");
        $ac_acima = base64_encode("Foto_Acima");
        $ac_abaixo = base64_encode("Foto_Abaixo");
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
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        // a linha de retorno é adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR

        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         * ***************INICIO
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario07(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario08(); // texto do box de informações
        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         * ***************FIM
         */

        /*
         * ******************************************************************************************
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         * ***************INICIO
         */
        $filtros = Array();
        /*
         * ******************************************************************************************
         * CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************INICIO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR

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
        $id_gal = $this->post_request['id'];
        $nome_gal = $this->descricoes['nome'][$id_gal];
        $n_fotos = $this->descricoes['total_fotos'][$id_gal];
        $tam_tab = "800"; // tamanho da tabela que lista os itens em %
        $title_tab = "Galeria: $nome_gal ($n_fotos fotos)"; // tï¿½tulo da tabela que lista os itens
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
        $campos[0]["tamanho_celula"] = "10%";
        $campos[0]["texto"] = $this->traducao->get_leg01();


        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         * ***************INICIO
         */

        $linhas = Array();

        /*
         *
         * ******************************************************************************************
         * CONFIGURE OS MODAIS.
         * ***************INICIO
         */
        $modais = Array();


        /*
         * ******************************************************************************************
         * CONFIGURE OS MODAIS.
         * ***************FIM
         */


        /*
         * ******************************************************************************************
         * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
         * ***************INICIO
         */

        $colunas = Array();
        $colunas[0]["alinhamento"] = "left";
        $colunas[0]["texto"] = "
            <form action=\"#\" method=\"GET\" class=\"form demo_form\" style=\"padding:20px;\">
              <div class=\"upload\"></div>
              <div class=\"filelists\">
                <div style=\"display:none\">
                  <h5>Completo</h5>
                  <ol class=\"filelist complete\">
                  </ol>
                </div>
                
                <h3>Fila de upload de fotos</h3>
                <div class=\"arquivo\" style=\"\"><span class=\"sucess-num\">0</span> arquivo(s) enviado(s)</div>
                <ol class=\"filelist queue\">
                </ol>
                <span class=\"cancel_all\" style=\"display:none\">Cancelar Todos</span>
                <br>
              </div>
            </form>
        ";



        $linhas[] = $colunas;
        /**
          /**   * ******************************************************************************************
         * CONFIGURE as colunas de cada linha da tabela.
         * ***************FIM
         */
        /*
         * ************************************************************************************************************
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
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
        $tpl = new Template("../Templates/Add_Fotos_Galeria.html");
        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         * ***************FIM
         */
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
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);
        $tpl->TEMA = $this->get_tema();
        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $tpl->TITULO_ADD_FOTO = $this->traducao->get_leg06();
        $tpl->TITULO_GER_FOTO = $this->traducao->get_leg07();
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();
        $add_fotos = base64_encode("Foto_Add_V");
        $ger_fotos = base64_encode("Foto_Gerencia");
        $ger_galerias = base64_encode("Galeria_Gerencia");
        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";
        $tpl->LINK_ADD_FOTO = $link . "&ac=$add_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_GER_FOTO = $link . "&ac=$ger_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ger_galerias";
        $tpl->URL_UPLOAD = "AJAX_add_foto_galeria.php?id_galeria=" . $this->post_request['id'];
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
