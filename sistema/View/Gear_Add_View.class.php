<?php

/**
 * View de Inclusão de Gears
 *
 * @author Ricardo Ribeiro Assink<ricardo@equipedigital.com>
 * @copyright Copyright (c) 2019-2029, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/08/2019
 * @package View
 */
class Gear_Add_View extends View {

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
        $this->traducao->loadTraducao("6666", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES 
         */
        $co = base64_encode("Gear_Control"); // CONTROLLER
        $ac = base64_encode("Gear_Add");
        $ac_v = base64_encode("Gear_Add_V");
        $ac_gerencia = base64_encode("Gear_Gerencia");
        $post = $ac;


        /**
         * CONFIGURE OS CAMPOS HIDDEN 
         */
        $hidden = Array();


        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR 
         */
        $componentes = Array("COUNTER", "TINYMCE_CONTEUDO");


        /**
         * CONFIGURE O NAV 
         */
        $pagina = (isset($this->post_request['pagina'])) ? $this->post_request['pagina'] : 1;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $pagina; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR


        /**
         * CONFIGURE O BOX DE INFORMAÇÔES 
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações


        /**
         * CONFIGURE A TABELA 
         */
        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = "center";
        $col[0]['width'] = "20%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "80%";


        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO 
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();


        /**
         * TABELA DA Gear  
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), TRUE);
        $colunas[1] = $this->form->select("tabela_gear", $this->traducao->get_leg13(), 0, $this->descricoes['desc_tabelas'], "left");
        Array_push($validacao, $this->form->validar('tabela_gear', 'value', '==', '0', $this->traducao->get_leg31(), Array("tabela_gear"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;




        /**
         * PREFIXO DA Gear
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), FALSE);
        $colunas[1] = $this->form->textarea("prefixo_gear", "", 100, 4, TRUE, 1000, TRUE, $this->traducao->get_leg21(), "left", false);
        $lin[] = $colunas;
        
       
        /**
         * SUFIXO DA Gear
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), FALSE);
        $colunas[1] = $this->form->textarea("sufixo_gear", "", 100, 4, TRUE, 1000, TRUE, $this->traducao->get_leg21(), "left", false);
        $lin[] = $colunas;    
        
        
        /**
         * Resultado DA Gear
         */
        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), FALSE);
        $colunas[1] = $this->form->textarea("resultado_gear", "", 100, 15, null, null, null, $this->traducao->get_leg21(), "left", false);
        $lin[] = $colunas;         
        
        

        /**
         * CONFIGURE BOTÕES 
         */
        $botoes = Array();
        $link = 'sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . $ac_gerencia . '';
        $botoes[0] = $this->form->button("center", "LIMPAR RESULTADO", "button", "limpa_resultado_gear()", "botao-success", "margin: 10px;");
        $botoes[1] = $this->form->button("center", "GERAR ...", "button", "gear_go()", "botao-success", "margin: 10px;");



        $js= '<script src="ajax/ajax_login.js" type="text/javascript"></script>
        <script type="text/JavaScript">
        
                    function gear_go(){
                        var tabela_gear  = document.form1.tabela_gear.value;
                        var prefixo_gear = document.form1.prefixo_gear.value;
                        var sufixo_gear  = document.form1.sufixo_gear.value;
                        
                        remoto           = new ajax();
                        xmlhttp          = remoto.enviar(\'AJAX_gear.php\' + "?prefixo_gear=" + prefixo_gear + "&sufixo_gear=" + sufixo_gear+ "&tabela_gear=" + tabela_gear, \'POST\', false);
                        
                        document.form1.resultado_gear.value = xmlhttp;        
                        
                       

                    }


                    function limpa_resultado_gear(){
                        document.getElementById("resultado_gear").value = \'\';

                    }

                   
               
        </script>';


        /* CONFIGURE O ARQUIVO DE TEMPLATE. */
        $tpl = new Template("../Templates/Formulario.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->JAVASCRIPT .= $js;
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
