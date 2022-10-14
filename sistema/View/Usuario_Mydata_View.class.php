<?php

/**
 * View de alteração de Dados do Usuário Corrente
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
class Usuario_Mydata_View extends View {

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
        $this->traducao->loadTraducao("2026", $this->get_idioma());
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
        $co = base64_encode("Usuario_Control"); // CONTROLLER
        $ac_01 = base64_encode("Usuario_Mydata");
        $ac_01v = base64_encode("Usuario_Mydata_V");
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
        $hidden['login_usuario_ok'] = 'sim';
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
        $componentes = Array("COUNTER");
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
        $retorno_nav .= "&pesquisa=" . $this->post_request['pesquisa'];
        $retorno_nav .= "&id=" . $this->post_request['id'];
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
        $tam_tab = "850"; // tamanho da tabela em px ou em %
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

        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), true);
        $colunas[1] = $this->form->textfield("nome_usuario", $dados['nome_usuario']);
        Array_push($validacao, $this->form->validar('nome_usuario', 'value', '==', '""', $this->traducao->get_leg31(), Array("nome_usuario"), $this->get_tema(), $this->get_idioma()));
        $lin[0] = $colunas;

        if ($this->user->get_perm_usuario() != 'R') {
            unset($this->descricoes['desc_perm_usuario']['R']);
        }
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true);
        $colunas[1] = $this->form->select("perm_usuario", $this->traducao->get_leg21(), $dados['perm_usuario'], $this->descricoes['desc_perm_usuario']);
        Array_push($validacao, $this->form->validar('perm_usuario', 'value', '==', '"0"', $this->traducao->get_leg32(), Array("perm_usuario"), $this->get_tema(), $this->get_idioma()));
        $lin[1] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->AJAX_existe_registro("login_usuario", $dados['login_usuario'], 20, true, $this->traducao->get_leg26(), $this->traducao->get_leg27());
        Array_push($validacao, $this->form->validar('login_usuario', 'value', '==', '""', $this->traducao->get_leg33(), Array("login_usuario"), $this->get_tema(), $this->get_idioma()));
        Array_push($validacao, $this->form->validar('login_usuario', 'value.length', '<', '3', $this->traducao->get_leg33(), Array("login_usuario"), $this->get_tema(), $this->get_idioma()));
        Array_push($validacao, $this->form->validar('login_usuario_ok', 'value', '!=', '"sim"', $this->traducao->get_leg33(), Array("login_usuario"), $this->get_tema(), $this->get_idioma()));
        $lin[2] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), true);
        $colunas[1] = $this->form->textfield("email_usuario", $dados['email_usuario']);
        if ($dados['autoriza_public_email'] == "S") {
            $autoriza = true;
        } else {
            $autoriza = false;
        }
        Array_push($validacao, $this->form->validar('email_usuario', 'value', '==', '""', $this->traducao->get_leg34(), Array("email_usuario"), $this->get_tema(), $this->get_idioma()));
        Array_push($validacao, $this->form->validar_email('email_usuario', $this->traducao->get_leg34(), Array("email_usuario"), $this->get_tema(), $this->get_idioma()));
        $lin[3] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), false);
        $colunas[1] = $this->form->textfield("endereco_usuario", $dados['endereco_usuario'], 80);
        $lin[4] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg06(), false);
        $colunas[1] = $this->form->textfield("bairro_usuario", $dados['bairro_usuario'], 60);
        $lin[5] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg07(), false);
        $colunas[1] = $this->form->textfield("complemento_end_usuario", $dados['complemento_end_usuario'], 60);
        $lin[6] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg08(), false);
        $colunas[1] = $this->form->textfield("cep_usuario", $dados['cep_usuario'], 20);
        $lin[7] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg09(), true);
        $colunas[1] = $this->form->textfield("cidade_usuario", $dados['cidade_usuario']);
        Array_push($validacao, $this->form->validar('cidade_usuario', 'value', '==', '""', $this->traducao->get_leg35(), Array("cidade_usuario"), $this->get_tema(), $this->get_idioma()));
        $lin[8] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg10(), true);
        $colunas[1] = $this->form->textfield("pais_residencia_usuario", $dados['pais_residencia_usuario']);
        Array_push($validacao, $this->form->validar('pais_residencia_usuario', 'value', '==', '""', $this->traducao->get_leg41(), Array("pais_residencia_usuario"), $this->get_tema(), $this->get_idioma()));
        $lin[9] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg11(), false);
        $colunas[1] = $this->form->textfield("telefone_usuario", $dados['telefone_usuario']);
        $lin[10] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg12(), false);
        $colunas[1] = $this->form->textfield("website_usuario", $dados['website_usuario']);
        $lin[11] = $colunas;

//            $colunas[0]          = $this->form->texto($this->traducao->get_leg19(),false);
//            $colunas[1]          = $this->form->textarea("outros_dados_usuario",$dados['outros_dados_usuario'],90,10,true,1500,true,$this->traducao->get_leg24());
//            $lin[12] = $colunas;

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
