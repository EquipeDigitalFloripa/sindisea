<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Inclusão de Usuário
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 01/10/2009
 * @Ultima_Modif 04/08/2015 por Marcio Figueredo
 *
 *
 * @package View
 *
 */
class Arquivo_Add_View extends View {

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
        $this->traducao->loadTraducao("3031", $this->get_idioma());


        /* CONFIGURE AS POSSIVEIS ACOES */
        $co = base64_encode("Arquivo_Control"); // CONTROLLER
        $ac = base64_encode("Arquivo_Add");
        $ac_v = base64_encode("Arquivo_Add_V");
        $post = $ac;


        /* CONFIGURE OS CAMPOS HIDDEN */
        $hidden = Array();


        /* CONFIGURE OS COMPONENTES QUE DEVE CARREGAR */

        $componentes = Array("COUNTER");
        $componentes[1] = "CALENDAR";
        $componentes[2] = "TINYMCE_EXACT";

        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 1;
        /* CONFIGURE O NAV */
        $control_div = "NAO";
        $retorno_nav = "pagina=" . $pagina;
        $retorno_nav .= "&ac=$ac_v";
        $retorno_nav .= "&co=$co";


        /* CONFIGURE O BOX DE INFORMAÇÔES */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações


        /* CONFIGURE A TABELA */
        $tam_tab = "990";
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = "center";
        $col[0]['width'] = "30%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "70%";


        /* CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();
        
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), FALSE);
        $colunas[1] = $this->form->calendar("data_upload", $this->traducao->get_leg11(), $this->dat->get_dataFormat("NOW", "", "DMA"), "");
        $lin[] = $colunas;
        
        /* CATEGORIA DA ARQUIVO */
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), TRUE);
        $colunas[1] = $this->form->select("id_categoria_arquivo", $this->traducao->get_leg21(), "", $this->descricoes['categoria_arquivo'], TRUE, 'Escolha uma categoria para o Arquivo', "left", "");
        Array_push($validacao, $this->form->validar('id_categoria_arquivo', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("id_categoria_arquivo"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->textarea("descricao", "", 80, 2, true, 100, true, $this->traducao->get_leg23(), "left");
        Array_push($validacao, $this->form->validar('descricao', 'value', '==', '""', $this->traducao->get_leg31(), Array("descricao"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), true);
        $colunas[1] = $this->form->textfield_FILE("arquivo", "", 60, true, $this->traducao->get_leg24(), null, "left");
        Array_push($validacao, $this->form->validar('arquivo', 'value', '==', '""', $this->traducao->get_leg33(), Array("arquivo"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $botoes = Array();
        $botoes[0] = $this->form->button("center");
        /**
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
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
        $tpl = new Template("../Templates/Formulario.html");
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
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();        
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }
}

?>
