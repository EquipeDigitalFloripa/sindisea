<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

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
class Candidato_Add_View extends View {

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
        $this->traducao->loadTraducao("3043", $this->get_idioma());


        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************INICIO
         */
        $co = base64_encode("Candidato_Control"); // CONTROLLER
        $ac = base64_encode("Candidato_Add");
        $ac_v = base64_encode("Candidato_Add_V");
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
        $componentes = Array("");


        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************INICIO
         */
        $control_div = "NAO"; // SIM quando � necess�rio esconder alguma div para mostrar modal
        // a linha de retorno � adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        // $retorno_nav     .= "&pesquisa=".$this->post_request['pesquisa'];
        //  $retorno_nav     .= "&id=".$this->post_request['id'];


        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMA��ES
         * ***************INICIO
         */
        $tam_infoacao = 500; // tamanho em px do box de informa��es
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // t�tulo do box de informa��es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informa��es
        $mostrar_obrig = true; // mostrar ou n�o o * de campos obrigat�rios
        $texto_obrig = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio


        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************INICIO
         */
        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // t�tulo da tabela
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
        $lin = Array();
        $colunas = Array();
        $validacao = Array();


        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), TRUE);
        $colunas[1] = $this->form->select("eleicao", $this->traducao->get_leg21(), "", $this->descricoes['eleicao'], TRUE, "", "left", "");
        Array_push($validacao, $this->form->validar('eleicao', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("eleicao"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), TRUE);
        $colunas[1] = $this->form->select("id_chapa", $this->traducao->get_leg21(), "", $this->descricoes['chapa'], TRUE, "", "left", "");
        Array_push($validacao, $this->form->validar('id_chapa', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("id_chapa"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), TRUE);
        $colunas[1] = $this->form->select("id_cargo", $this->traducao->get_leg21(), "", $this->descricoes['cargo'], TRUE, "", "left", "");
        Array_push($validacao, $this->form->validar('id_cargo', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("id_cargo"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), true);
        $colunas[1] = $this->form->textfield("nome", $this->post_request['nome'], 50);
        Array_push($validacao, $this->form->validar('nome', 'value', '==', '""', $this->traducao->get_leg31(), Array("nome"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        //INCLUIR NOVA LINHA QUE VAI CONTER DIV, QUE VAI CONTER O JAVA SCRIPT QUE VAI CHAMAR NOVO FORMULARIO(TEMPLATE);
        $botoes = Array();
        $botoes[0] = $this->form->button("center");

        // $JS = '
        //         <script>                                     
        //             $(document).ready(function (){
        //                 $("#eleicao").change(function(){
        //                     var str = $("#eleicao").val();                            
        //                     $.ajax( {
        //                         url: "AJAX_get_chapa.php",
        //                         type: "POST",
        //                         data: "id=" + str,
        //                         cache: false,
        //                         async: true,
        //                         dataType: "json",
        //                         beforeSend: function () {
        //                         },
        //                         success: function (data, textStatus, jqXHR) {
        //                             var selectbox = $(\'#id_chapa\');
        //                             selectbox.find(\'option\').remove();
        //                             $.each(data, function (i, d) {
        //                                 $(\'<option>\').val(d.id_chapa_eleicao).text(d.nome).appendTo(selectbox);
        //                             });
        //                         },
        //                         error: function(data) {
                                  
        //                         }
        //                     });
        //                 });      
        //             });
                    
        //         </script>
        //     ';


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
        $tpl->JS .= $JS;
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
