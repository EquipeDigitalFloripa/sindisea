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
class Noticia_Foto_Altera_View extends View {

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
        $this->traducao->loadTraducao("3023", $this->get_idioma());

        

        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************INICIO
         */

        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Foto_Altera");
        $ger_fotos = base64_encode("Noticia_Foto_Gerencia");
        $post = $ac;

        

        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************INICIO
         */
        $hidden = Array();

        

        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         * ***************INICIO
         */
        $componentes = Array();
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
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações
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

        $dados = $this->objetos->get_all_dados();
//        $id_post = $dados['id_post'];
//        $nome_pro = $this->descricoes['nome'][$id_post];
//        $n_fotos = $this->descricoes['total_fotos'][$id_post];
        $tam_tab = "900"; // tamanho da tabela que lista os itens em %
//        $title_tab = "Produto: $nome_pro ($n_fotos fotos)"; // tï¿½tulo da tabela que lista os itens
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
        
        
        $this->post_request['id'] = $dados['id_foto'];
        $diretorio = "../sys/arquivos/img_noticias/";
        $nome = $dados['id_foto'] . "." . $dados['ext_foto'];
        
        $res = $diretorio . $nome;        
        $colunas = Array();
        $colunas[0]["alinhamento"] = "center";
        $colunas[0]["texto"] = "<br/><img src=\"$res\" id=\"cropbox\" /><br/>";
        $hidden['ext'] = $dados['ext_foto'];
        $linhas[] = $colunas;
        
        
        $tpl = new Template("../Templates/Crop_Foto.html");

        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();

        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->TITLE = $this->criaTitulo();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao = array(), $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, "Alteração do corte da imagem", $campos, $linhas, $titulo_infoacao, $texto_infoacao);
        
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);
        $tpl->TEMA = $this->get_tema();
        
        $tpl->BOTAO1 = $botoes[0] = $this->form->button2("center", "Voltar", "button", $link . "&ac=$ger_fotos&id=" . $dados['id_noticia'], "botao", "");
        $tpl->BOTAO2 = $botoes[1] = $this->form->button("center", "Salvar");
        $tpl->show();
    }
}
?>
