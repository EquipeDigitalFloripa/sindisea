<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Usu�rios, filho de View
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
class Foto_Gerencia_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {
        /* CONFIGURE O ID DE TRADUCAO DA VIEW */
        $this->traducao->loadTraducao("3046", $this->get_idioma());


        /* CONFIGURE AS POSSIVEIS ACOES */
        $co = base64_encode("Galeria_Control"); // CONTROLLER
        $ac = base64_encode("Foto_Salva_Alteracoes");
        $ac_apaga = base64_encode("Foto_Apaga");
        $ac_ger = base64_encode("Foto_Gerencia");
        $ac_acima = base64_encode("Foto_Acima");
        $ac_abaixo = base64_encode("Foto_Abaixo");
        $ordenar_fotos = base64_encode("Foto_Ordena_V");
        $post = $ac;
        

        /* CONFIGURE OS CAMPOS HIDDEN */
        $hidden = Array();


        /* CONFIGURE OS COMPONENTES QUE DEVE CARREGAR */
        $componentes = Array("COUNTER");


        /* CONFIGURE O NAV */
        $control_div = "NAO";
        $retorno_nav = "pagina=" . $this->post_request['pagina'];
        $retorno_nav .= "&ac=$ac_ger";
        $retorno_nav .= "&co=$co";


        /** CONFIGURE O BOX DE INFORMA��ES */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01();
        $texto_infoacao = $this->traducao->get_titulo_formulario03(); 


        /* CONFIGURE OS FILTROS. ATENCAO !!! � NECESS�RIO EFETUAR CONFIGURA��ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE */
        $filtros = Array();


        /* CONFIGURE A PAGINACAO */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do n�mero de p�ginas
        $retorno_paginacao = "ac=$ac_ger"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&id=" . $this->post_request['id']; // CONTROLADOR

        /* CONFIGURE A LISTA DE ITENS */
        $id_gal = $this->post_request['id'];
        $nome_gal = $this->descricoes['nome'][$id_gal];
        $n_fotos = $this->descricoes['total_fotos'][$id_gal];
        $tam_tab = "900";
        $title_tab = "Galeria: $nome_gal ($n_fotos fotos)";


        /* CONFIGURE o topo da tabela que mostra a lista de elementos */
        $campos = Array();
//            $campos[0]["tamanho_celula"] = "10%";
//            $campos[0]["texto"]          = $this->traducao->get_leg01();

        $campos[0]["tamanho_celula"] = "30%";
        $campos[0]["texto"] = $this->traducao->get_leg02();

        $campos[1]["tamanho_celula"] = "60%";
        $campos[1]["texto"] = $this->traducao->get_leg03();
        
        
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor));
            }
                        
            
            /* CONFIGURE OS MODAIS. */
            $modais = Array();


            /* CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR V�O ALGUNS TRATAMENTOS. */
            $colunas = Array();

            $diretorio = "../sys/arquivos/img_galerias/";
            $nome = $dados['id_foto'] . "." . $dados['ext_img'];
            $res = $diretorio . $nome;
            $tamanho = '200';

            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = "<img src=\"../sys/includes/make_thumb.php?ts=" . time() . "&diretorio=../arquivos/img_galerias/&arquivo=" . $nome . "&tamanho=" . $tamanho . "\" >";

            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"] = $this->form->textarea("leg[" . $dados['id_foto'] . "]", $dados['leg'], 50, 4, true, 150, true, $this->traducao->get_leg30());
            $colunas[1]["texto"] .= $this->form->checkbox("apagar[" . $dados['id_foto'] . "]", $this->traducao->get_leg29(), $dados['id_foto']);
            $colunas[1]["texto"] .= $this->form->radio("capa", $this->traducao->get_leg28(), $dados['id_foto'], $dados['destaque']);

            $linhas[$i] = $colunas;
            $i++;
        }

        
        /* CONFIGURE O ARQUIVO DE TEMPLATE. */
        $tpl = new Template("../Templates/Gerencia_Fotos_Galeria.html");

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
        $tpl->TEMA = $this->get_tema();
        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $tpl->TITULO_ADD_FOTO = $this->traducao->get_leg11();
        $tpl->TITULO_GER_FOTO = $this->traducao->get_leg12();
        $tpl->TITULO_VOLTA_GER = $this->traducao->get_leg13();
        $tpl->TITULO_ORDENAR = $this->traducao->get_leg09();
        $add_fotos = base64_encode("Foto_Add_V");
        $ger_fotos = base64_encode("Foto_Gerencia");
        $ger_galerias = base64_encode("Galeria_Gerencia");
        $link = "sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$co";
        $tpl->LINK_ADD_FOTO = $link . "&ac=$add_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_GER_FOTO = $link . "&ac=$ger_fotos&id=" . $this->post_request['id'];
        $tpl->LINK_VOLTA_GER = $link . "&ac=$ger_galerias";
        $tpl->LINK_ORDENAR = $link . "&ac=$ordenar_fotos&id=" . $this->post_request['id'];
        $tpl->BOTAO = $this->form->button('center', $this->traducao->get_leg31());

        $tpl->show();
    }

}

?>
