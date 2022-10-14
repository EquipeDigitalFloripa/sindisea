<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Inclusão de Galerias
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 01/10/2009
 * @Ultima_Modif 01/10/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package View
 *
 */
class Galeria_Add_View extends View {

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
        $this->traducao->loadTraducao("3041", $this->get_idioma());


        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************INICIO
         */
        $co = base64_encode("Galeria_Control"); // CONTROLLER
        $ac = base64_encode("Galeria_Add");
        $ac_v = base64_encode("Galeria_Add_V");
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
        $componentes = Array("COUNTER");
        $componentes[1] = "CALENDAR";
        $componentes[2] = "TINYMCE_EXACT";


        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************INICIO
         */
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        // a linha de retorno é adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        // $retorno_nav     .= "&pesquisa=".$this->post_request['pesquisa'];
        //  $retorno_nav     .= "&id=".$this->post_request['id'];



        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAï¿½ï¿½ES
         * ***************INICIO
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es



        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************INICIO
         */
        $tam_tab = "970"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // tï¿½tulo da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['width'] = "75%";


        /*
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         * ***************INICIO
         */
        $lin = array();
        $colunas = array();
        $validacao = array();

        // Categoria
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), true);
        $colunas[1] = $this->form->select("id_categoria_galeria", $this->traducao->get_leg21(), "", $this->descricoes['nome_categoria']);
        array_push($validacao, $this->form->validar('id_categoria_galeria', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("id_categoria_galeria"), $this->get_tema(), $this->get_idioma()));
        $lin[0] = $colunas;

        // Data
        if ($this->post_request['data_galeria'] == "") {
            $this->post_request['data_galeria'] = $this->dat->get_dataFormat("NOW", "", "DMA");
        }
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true);
        $colunas[1] = $this->form->calendar("data_galeria", $this->traducao->get_leg11(), $this->post_request['data_galeria'], "");
        $lin[] = $colunas;

        // Titulo
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->textfield("titulo", "", 60, false, $this->traducao->get_leg24(), null, "left");
        array_push($validacao, $this->form->validar('titulo', 'value', '==', '""', $this->traducao->get_leg32(), Array("titulo"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        // Subtitulo / Chamada / Linha Fina
//        $max_caract = 250;
//        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), true);
//        $colunas[1] = $this->form->textarea("chamada", "", 70, 2, true, $max_caract, true, $this->traducao->get_leg23(), "left");
//        array_push($validacao, $this->form->validar('chamada', 'value', '==', '""', $this->traducao->get_leg33(), Array("chamada"), $this->get_tema(), $this->get_idioma()));
//        $lin[] = $colunas;

        // Texto
//        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), true);
//        $colunas[1] = $this->form->textarea_TINYMCE("texto", "");
//        $lin[] = $colunas;
        
        // Tags
//        $max_caract2 = 180;
//        $colunas[0] = $this->form->texto($this->traducao->get_leg09(), true);
//        $colunas[1] = $this->form->textarea("tags", "", 70, 2, true, $max_caract2, true, $this->traducao->get_leg24(), "left");
//        array_push($validacao, $this->form->validar('tags', 'value', '==', '""', $this->traducao->get_leg34(), array("tags"), $this->get_tema(), $this->get_idioma()));
//        $lin[] = $colunas;

        // Destacar
//        $colunas[0] = $this->form->texto($this->traducao->get_leg08(), true); //                                           
//        $colunas[1] = $this->form->checkbox("destaque", $this->traducao->get_leg07(), 1, TRUE, "left");
//        $lin[] = $colunas;
        
        // Botão enviar
        $botoes = array();
        $botoes[0] = $this->form->button("center");

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
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);
        $tpl->show();
    }

// fim do showView()
}

?>
