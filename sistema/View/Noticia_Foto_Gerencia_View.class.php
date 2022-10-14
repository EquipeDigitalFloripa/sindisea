<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Gerenciamento das Fotos do Post
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
class Noticia_Foto_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("3015", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Foto_Salva_Alteracoes");
        $ac_ger_noticia = base64_encode("Noticia_Gerencia");
        $ac_foto_add = base64_encode("Noticia_Foto_Add_V");
        $ac_foto_altera = base64_encode("Noticia_Foto_Altera_V");
        $ac_foto_ordena = base64_encode("Noticia_Foto_Ordena_V");
        $post = $ac;

        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();        

        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");

        /**
         * CONFIGURE O NAV
         */
        $control_div = "NAO"; // SIM quando ï¿½ necessï¿½rio esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR

        /**
         * CONFIGURE O BOX DE INFORMAï¿½ï¿½ES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es

        /**
         * CONFIGURE OS FILTROS. ATENCAO !!! ï¿½ NECESSï¿½RIO EFETUAR CONFIGURAï¿½ï¿½ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = Array();
        $validacao= Array();
        $modais= Array();

        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do nï¿½mero de pï¿½ginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&post=" . $this->post_request['id']; // CONTROLADOR

        /**
         * CONFIGURE A LISTA DE ITENS
         */        
        $n_fotos = $this->descricoes['total_fotos'][$this->post_request['id']];
        $tam_tab = "900"; // tamanho da tabela que lista os itens em %
        $title_tab = "Galeria ($n_fotos fotos)"; // tï¿½tulo da tabela que lista os itens

        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "30%";
        $campos[0]["texto"] = $this->traducao->get_leg02();

        $campos[1]["tamanho_celula"] = "60%";
        $campos[1]["texto"] = $this->traducao->get_leg03();

        /**
         * Seleciona os elementos que serï¿½o mostrados e configura as linhas da tabela
         */
        $ctr_noticia = new Noticia_Control($this->post_request);
        $dados_noticia = $ctr_noticia->Pega_Dados_Noticia($this->post_request['id']);

        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {
            $dados = $this->objetos[$i]->get_all_dados();

            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor));
            }


            /**
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR Vï¿½O ALGUNS TRATAMENTOS.
             */
            $colunas = Array();
            $nome = $dados['id_foto'] . "." . $dados['ext_foto'];
            $tamanho = '200';
            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = "<img src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=../arquivos/img_noticias/&arquivo=" . $nome . "&tamanho=" . $tamanho . "\" >";


            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"] = $this->form->textarea("leg_foto[" . $dados['id_foto'] . "]", $dados['leg_foto'], 50, 4, true, 150, true, $this->traducao->get_leg30());
            $colunas[1]["texto"] .= $this->form->checkbox("apagar_foto[" . $dados['id_foto'] . "]", $this->traducao->get_leg29(), $dados['id_foto']);
            $colunas[1]["texto"] .= $this->form->radio("foto_capa", $this->traducao->get_leg28(), $dados['id_foto'], $dados['destaque_foto']);
            $colunas[1]["texto"] .= "<span style=\"width: 100px;float: left; margin: -4px 0px 0px 10px;\" class=\"texto_conteudo_tabela\"><a href=\"javascript:submit_campo(" . $dados['id_foto'] . ",'$ac_foto_altera');\"><img src=\"temas/" . $this->get_tema() . "/icones/icone_imagens.png\" width=\"25\" height=\"25\" align=\"left\" border=\"0\" hspace=\"2\"> <p style=\" margin: 6px 10px 0px 0px;\">Alterar Corte</p></a></span>";


            $linhas[$i] = $colunas;

            $i++;
        }

        /**
         * CONFIGURA BOTÕES 
         */
        $botoes = Array();        
        $botoes[0] = (count($this->objetos) > 0) ? $this->form->button("center", "SALVAR ALTERAÇÕES", "button", "validar()", "botao", "") : '';

        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Gerencia_Fotos.html");

        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->TITLE_POST = $this->criaTituloPost($dados_noticia['titulo_noticia']);
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao, $botoes);
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");        
        $tpl->TEMA = $this->get_tema();
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ac_ger_noticia";
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg08();
        $tpl->LINK_ADD_FOTO = $link . "&ac=$ac_foto_add&id=" . $this->post_request['id'];
        $tpl->TITULO_ADD_FOTO = $this->traducao->get_leg06();
        $tpl->LINK_ORDENAR = $link . "&ac=$ac_foto_ordena&id=" . $this->post_request['id'];
        $tpl->TITULO_ORDENAR = $this->traducao->get_leg09();

        $tpl->show();
    }

}

?>
