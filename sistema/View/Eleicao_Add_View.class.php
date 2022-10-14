<?php
require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");
/**
 * View de Inclusão de Eleição
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


class Eleicao_Add_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */

    public function showView(){
        /*
         * ************************************************************************************************************
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         ****************INICIO
         */
        $this->traducao->loadTraducao("3035", $this->get_idioma());
        /*
         * ************************************************************************************************************
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         ****************INICIO
         */
        $co          = base64_encode("Eleicao_Control"); // CONTROLLER
        $ac          = base64_encode("Eleicao_Add");
        $ac_v        = base64_encode("Eleicao_Add_V");
        $post        = $ac;
        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         ****************INICIO
         */
        $hidden = Array();
        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         ****************FIM
         */
        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         ****************INICIO
         */
        $componentes      = Array("");
        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         ****************FIM
         */
        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         ****************INICIO
         */
        $control_div      = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        // a linha de retorno é adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav      = "pagina=".$this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav     .= "&ac=$ac_v"; // ACAO
        $retorno_nav     .= "&co=$co"; // CONTROLADOR
        // $retorno_nav     .= "&pesquisa=".$this->post_request['pesquisa'];
        //  $retorno_nav     .= "&id=".$this->post_request['id'];
        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         ****************INICIO
         */
        $tam_infoacao      = 500; // tamanho em px do box de informações
        $titulo_infoacao   = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao    = $this->traducao->get_titulo_formulario02(); // texto do box de informações
        $mostrar_obrig     = true; // mostrar ou não o * de campos obrigatórios
        $texto_obrig       = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio
        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         ****************INICIO
         */
        $tam_tab           = "550"; // tamanho da tabela em px ou em %
        $title_tab         = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color']   = "#FFFFFF";
        $col[0]['nowrap']  = false;
        $col[0]['width']   = "25%";
        $col[1]['color']   = "#EBEBEB";
        $col[1]['nowrap']  = false;
        $col[1]['width']   = "75%";
        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         ****************FIM
         */


        /*
          * ******************************************************************************************
          * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
          ****************INICIO
         */
        $lin       = Array();
        $colunas   = Array();
        $validacao = Array();

        $colunas[0]          = $this->form->texto($this->traducao->get_leg01(),true);
        $colunas[1]          = $this->form->textfield("descricao",$this->post_request['descricao'],50);
        Array_push($validacao, $this->form->validar('descricao','value', '==', '""',$this->traducao->get_leg31(),Array("descricao"),$this->get_tema(),$this->get_idioma()));
        $lin[0] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), TRUE);
        $colunas[1] = $this->form->textfield("data_inicio",$this->post_request['data_inicio'],50);
        Array_push($validacao, $this->form->validar('data_inicio','value', '==', '""',$this->traducao->get_leg32(),Array("data_inicio"),$this->get_tema(),$this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), TRUE);
        $colunas[1] = $this->form->textfield("data_fim",$this->post_request['data_fim'],50);
        Array_push($validacao, $this->form->validar('data_fim','value', '==', '""',$this->traducao->get_leg33(),Array("data_fim"),$this->get_tema(),$this->get_idioma()));
        $lin[] = $colunas;

        //INCLUIR NOVA LINHA QUE VAI CONTER DIV, QUE VAI CONTER O JAVA SCRIPT QUE VAI CHAMAR NOVO FORMULARIO(TEMPLATE);
        $botoes = Array();
        $botoes[0]           = $this->form->button("center");
        /**
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         ****************FIM
         */

        $JS = '  <script type="text/javascript">
            jQuery(document).ready(function ($) {    
                $(\'#data_inicio\').mask(\'00/00/0000\');
                $(\'#data_fim\').mask(\'00/00/0000\');
            });
        </script>';

        /*
        * ************************************************************************************************************
        * MONTA O HTML E MOSTRA
        ****************INICIO
        */

        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         ****************INICIO
        */
        $tpl = new Template("../Templates/Formulario.html");
        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         ****************FIM
        */
        $tpl->CABECALHO   = $this->criaCabecalho();
        $tpl->META        = $this->criaMetaTags();
        $tpl->CSS         = $this->criaCss();
        $tpl->JS          = $this->criaJs();
        $tpl->JS         .= $JS;
        $tpl->JAVASCRIPT  = $this->criaJavascript();
        $tpl->VALIDACAO   = $this->criaValidacoes($validacao,$this->form->get_resetcampos(),$post,$this->form->get_ajax());
        $tpl->TITLE       = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->NAV         = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU        = $this->criaMenu();
        //$tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
        $tpl->HIDDENS     = $this->criaHiddens($hidden);
        $tpl->TABELAFORM  = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE      = $this->criaRodape();
        $tpl->MODALCOMP   = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
        /*
        * ************************************************************************************************************
        * MONTA O HTML E MOSTRA
        ****************FIM
        */
    }// fim do showView()



}

?>
