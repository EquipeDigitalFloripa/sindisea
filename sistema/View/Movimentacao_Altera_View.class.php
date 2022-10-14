<?php

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
class Movimentacao_Altera_View extends View {

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
        $this->traducao->loadTraducao("5091", $this->get_idioma());
        /*
         * ************************************************************************************************************
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************INICIO
         */
        $co = base64_encode("Movimentacao_Control"); // CONTROLLER
        $ac = base64_encode("Movimentacao_Gerencia");
        $ac_01 = base64_encode("Movimentacao_Altera");
        $ac_01v = base64_encode("Movimentacao_Altera_V");
        $post = $ac_01;
        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************INICIO
         */
        $hidden = Array();
        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************FIM
         */
        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         * ***************INICIO
         */
        $componentes = Array("");
        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         * ***************FIM
         */
        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************INICIO
         */
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        // a linha de retorno é adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_01v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        // $retorno_nav     .= "&pesquisa=".$this->post_request['pesquisa'];
        //  $retorno_nav     .= "&id=".$this->post_request['id'];
        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         * ***************FIM
         */

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
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMAÇÔES
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************INICIO
         */
        $tam_tab = "550"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['width'] = "75%";
        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************FIM
         */
        $dados = $this->objetos->get_all_dados();

        // aplica regra de recebimento no array de dados
        foreach ($dados as $chave => $valor) {
            //$dados[$chave] = htmlspecialchars(stripslashes($valor)); // só quando utilizar listas de gerenciamento
            $dados[$chave] = stripslashes($valor);
        }


        /*
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         * ***************INICIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();
        
        // Tipo movimentação
        $colunas[0] = $this->form->texto("Tipo:", TRUE);
        $colunas[1] = $this->form->select("tipo_movimentacao", "Escolha o tipo de movimentação", $dados['tipo_movimentacao'], $this->descricoes['tipo_movimentacao'], "left", "", "", false, "", "");
        Array_push($validacao, $this->form->validar('mes', 'value', '==', '"0"', $this->traducao->get_leg34(), Array("tipo_movimentacao"), $this->get_tema(), $this->get_idioma()));

        $lin[] = $colunas;
        
        // Centro de Custo
        $colunas[0] = $this->form->texto("Centro de Custo:", TRUE);
        $colunas[1] = $this->form->select("id_centro", "Escolha o centro de custo", $dados['id_centro'], $this->descricoes['centro'], "left", "", "", false, "", "");
        Array_push($validacao, $this->form->validar('mes', 'value', '==', '"0"', $this->traducao->get_leg32(), Array("id_centro"), $this->get_tema(), $this->get_idioma()));

        $lin[] = $colunas;
        
        /* DATA COMPETÊNCIA */
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true);
        $colunas[1] = $this->form->calendar("data_competencia", $this->dat->get_dataFormat("BD", $dados['data_competencia'], "DMA"), TRUE, $this->traducao->get_leg21(), "left", "10", "", array(70, 10));       
        Array_push($validacao, $this->form->validar('data_competencia', 'value', '==', '""', $this->traducao->get_leg31(), Array("data_competencia"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        //  descrição
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->textfield("descricao", $dados['descricao'], 60, false, "", null, "left");
        array_push($validacao, $this->form->validar('descricao', 'value', '==', '""', $this->traducao->get_leg33(), Array("descricao"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        //VALOR DA MOVIMENTAÇÃO
        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), true);
        $colunas[1] = $this->form->textfield("valor_mov", number_format($dados['valor_mov'], 2, ',', '.'), 20, TRUE, "", null, "left", "onKeyPress=\"return(formataMoeda(this,'.',',',event))\"", "");
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
        //$tpl->MODAIS      = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        //$tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
        $tpl->HIDDENS = $this->criaHiddens($hidden);


        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);

        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
        /*
         * ************************************************************************************************************
         * MONTA O HTML E MOSTRA
         * ***************FIM
         */
    }

// fim do showView()
}

?>
