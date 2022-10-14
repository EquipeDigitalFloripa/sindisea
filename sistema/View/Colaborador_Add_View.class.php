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
 * @Ultima_Modif 01/10/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package View
 *
 */
class Colaborador_Add_View extends View {

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
        $this->traducao->loadTraducao("5031", $this->get_idioma());


        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************INICIO
         */
        $co = base64_encode("Colaborador_Control"); // CONTROLLER
        $ac = base64_encode("Colaborador_Add");
        $ac_v = base64_encode("Colaborador_Add_V");
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
        $componentes = array("COUNTER", "TINYMCE_CONTEUDO");

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
         * CONFIGURE O BOX DE INFORMAÇÔES
         * ***************INICIO
         */
        $tam_infoacao = 500; // tamanho em px do box de informações
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações
        $mostrar_obrig = true; // mostrar ou não o * de campos obrigatórios
        $texto_obrig = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio


        /*
         * CONFIGURE A TABELA 
         * MARCIO FIGUEREDO 23/10/2014
         */
        $tam_tab = "970"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // tï¿½tulo da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "20%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = FALSE;
        $col[1]['width'] = "80%";


        /*
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         * ***************INICIO
         */

      
        $lin = Array();
        $colunas = Array();
        $validacao = Array();
        
        /* gestão */
        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), TRUE);
        $colunas[1] = $this->form->select("id_gestao", $this->traducao->get_leg21(), "", $this->descricoes['gestao'], TRUE, 'Escolha uma gestão', "left", "");
        Array_push($validacao, $this->form->validar('id_gestao', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("id_gestao"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;
        
        //  nome
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), true);        
        $colunas[1] = $this->form->textfield("nome", "", 40, false, $this->traducao->get_leg24(), null, "left");
        array_push($validacao, $this->form->validar('nome', 'value', '==', '""', $this->traducao->get_leg32(), Array("nome"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;
        
        //  Função
        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), true);        
        $colunas[1] = $this->form->textfield("funcao", "", 40, false, $this->traducao->get_leg24(), null, "left");
        array_push($validacao, $this->form->validar('funcao', 'value', '==', '""', $this->traducao->get_leg33(), Array("funcao"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        //  Função
        $colunas[0] = $this->form->texto($this->traducao->get_leg06(), true);        
        $colunas[1] = $this->form->textfield("ordem", "", 10, false, $this->traducao->get_leg24(), null, "left");
        array_push($validacao, $this->form->validar('ordem', 'value', '==', '""', $this->traducao->get_leg34(), Array("ordem"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;
        
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true); //        
        $colunas[1] = $this->form->textarea_TINYMCE("info", "");
        $lin[] = $colunas;        
        
        // foto_colaborador
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->textfield_FILE("foto", $this->post_request['foto'], 70);
        $lin[] = $colunas;

        $botoes = Array();
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
        //$tpl->MODAIS      = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        //$tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
        $tpl->HIDDENS = $this->criaHiddens($hidden);


        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);

        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
    }

// fim do showView()
}

?>
