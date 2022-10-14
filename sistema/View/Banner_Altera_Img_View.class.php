<?php

/**
 * View de Inclus�o de Usu�rio
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


class Banner_Altera_Img_View extends View {

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
        $this->traducao->loadTraducao("3061", $this->get_idioma());
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
        $co          = base64_encode("Banner_Control"); // CONTROLLER
        $ac          = base64_encode("Banner_Gerencia");
        $ac_01      = base64_encode("Banner_Altera_Img");
        $ac_01v     = base64_encode("Banner_Altera_Img_V");
        $post        = $ac_01;
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
        $componentes      = Array();
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
        $control_div      = "NAO"; // SIM quando � necess�rio esconder alguma div para mostrar modal
        // a linha de retorno � adicionada ao NAV // SEM O IDIOMA (criaNav())
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
         * CONFIGURE O BOX DE INFORMA��ES
         ****************INICIO
         */
        $tam_infoacao      = 500; // tamanho em px do box de informa��es
        $titulo_infoacao   = $this->traducao->get_titulo_formulario01(); // t�tulo do box de informa��es
        $texto_infoacao    = $this->traducao->get_titulo_formulario02(); // texto do box de informa��es
        $mostrar_obrig     = true; // mostrar ou n�o o * de campos obrigat�rios
        $texto_obrig       = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio
        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMA��ES
         ****************FIM
         */
            $dados  = $this->objetos->get_all_dados();

            // aplica regra de recebimento no array de dados
            foreach ($dados as $chave => $valor){
                //$dados[$chave] = htmlspecialchars(stripslashes($valor)); // s� quando utilizar listas de gerenciamento
                $dados[$chave] = stripslashes($valor);
            }
        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         ****************INICIO
         */
        $tam_tab           = "670"; // tamanho da tabela em px ou em %
        $title_tab         = "Banner: ".$this->descricoes['regiao'][$dados['regiao']];// t�tulo da tabela
        
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

            $diretorio = "../sys/arquivos/banners/";
            $nome      = $dados['id_banner'].".".$dados['ext'];
            $res = $diretorio.$nome;


            $subtitle_tab =  "<img src=arquivos/banners/".$nome."?ts=".time().">";
            
            //$lin[0] = $colunas;
        
            $colunas[0]          = $this->form->texto($this->traducao->get_leg04(),true);
            $colunas[1]          = $this->form->textfield_FILE("imagem","",70,true,$this->traducao->get_leg21());
            Array_push($validacao, $this->form->validar('imagem','value', '==', '""',$this->traducao->get_leg33(),Array("imagem"),$this->get_tema(),$this->get_idioma()));
            $lin[0] = $colunas;

            $botoes = Array();
            $botoes[0]           = $this->form->button("center");
            /**
             * ******************************************************************************************
             * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
             ****************FIM
            */
  
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
            $tpl->JAVASCRIPT  = $this->criaJavascript();
            $tpl->VALIDACAO   = $this->criaValidacoes($validacao,$this->form->get_resetcampos(),$post,$this->form->get_ajax());
            $tpl->TITLE       = $this->criaTitulo();
            $tpl->COMPONENTES = $this->criaComponentes($componentes);
            //$tpl->MODAIS      = $this->criaModalLista($modais);
            $tpl->NAV         = $this->criaNav($retorno_nav, $control_div);
            $tpl->MENU        = $this->criaMenu();
            //$tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
            $tpl->HIDDENS     = $this->criaHiddens($hidden);


            $tpl->TABELAFORM  = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, $subtitle_tab);

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
