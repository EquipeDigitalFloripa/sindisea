<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Alteração de Slider
 *
 * @author Marcio Figueredo marcio@equipedigital.com
 * @copyright Copyright (c) 2015-2018, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/04/2015
 * @package View
 *
 */
class Slider_Altera_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Marcio Figueredo
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {
        /*
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         */
        $this->traducao->loadTraducao("4043", $this->get_idioma());
        

        /*
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Slider_Control");        
        $ac = base64_encode("Slider_Altera");
        $ac_v = base64_encode("Slider_Altera_V");
        $post = $ac;


        /*
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = array();
        
        
        /*
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");
        $componentes[1] = "CALENDAR";
        $componentes[2] = "TINYMCE_EXACT";


        /*
         * CONFIGURE O NAV
         */
        $control_div = "NAO"; 
        $retorno_nav = "pagina=" . $this->post_request['pagina'];
        $retorno_nav .= "&ac=$ac_v"; 
        $retorno_nav .= "&co=$co"; 

        
        /*
         * CONFIGURE O BOX DE INFORMAÇÕES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); 
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); 

        
        /*
         * CONFIGURE A TABELA
         */
        $tam_tab = "900"; 
        $title_tab = $this->traducao->get_titulo_formulario04();
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = "center";
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "75%";

        /*
         * OBTEM DADOS
         */        
        $dados = $this->objetos->get_all_dados();
        foreach ($dados as $chave => $valor) {
            $dados[$chave] = stripslashes($valor);
        }

        
        /*
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         */
        $lin = array();
        $colunas = array();
        $validacao = array();

        $data_slider = $this->dat->get_dataFormat("BD", $dados['data_slider'], "DMA");
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), FALSE);
        $colunas[1] = $this->form->calendar("data_slider", $this->traducao->get_leg11(), $data_slider, "");
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), FALSE);
        $colunas[1] = $this->form->textfield("desc_slider", $dados['desc_slider'], 60, false, $this->traducao->get_leg24(), null, "left");
        $lin[] = $colunas;

        $botoes = Array();
        $botoes[0] = $this->form->button("center");
        

        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Formulario.html");
        
        
        /*
         * CONFIGURE O ARQUIVO DE TEMPLATE.
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
