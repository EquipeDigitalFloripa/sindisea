<?php

/**
 * View de Atualização de Conteúdo
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
class Conteudo_Edit_View extends View {

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
        $this->traducao->loadTraducao("3030", $this->get_idioma());
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
        $co = base64_encode("Conteudo_Control"); // CONTROLLER
        $ac = base64_encode("Conteudo_Edit");
        $ac_01 = base64_encode("Conteudo_Edit_V");
        $post = $ac;
        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************FIM
         */


        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         * ***************INICIO
         */
        $componentes = Array('TINYMCE_CONTEUDO', 'DTREE');
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
        $retorno_nav .= "&ac=$ac_01"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR

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
        $mostrar_obrig = false; // mostrar ou não o * de campos obrigatórios
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
        $tam_tab = "970"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "15%";
        $col[0]['valign'] = "top";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['width'] = "85%";
        $col[1]['valign'] = "top";
        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************FIM
         */

        /*
         * ******************************************************************************************
         * CONFIGURE OS MODAIS.
         * ***************INICIO
         */
        $modais = Array();

        $modais[0]['campos'] = Array('ac' => $ac);
        $modais[0]['acao'] = "salvar";
        $modais[0]['msg'] = $this->traducao->get_leg31();

        /*
         * ******************************************************************************************
         * CONFIGURE OS MODAIS.
         * ***************FIM
         */

        /*
          $dados  = $this->objetos->get_all_dados();

          // aplica regra de recebimento no array de dados
          foreach ($dados as $chave => $valor){
          //$dados[$chave] = htmlspecialchars(stripslashes($valor)); // só quando utilizar listas de gerenciamento
          $dados[$chave] = stripslashes($valor);
          }
         */

        $valores = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();
            // aplica regra de recebimento no array de dados
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor),NULL,'ISO-8859-1');
            }

            if ($this->post_request['id_conteudo'] == "") {
                if ($i == 0) {
                    $inicial = $dados['id_conteudo']; // inicializa o campo ID
                    $conteudo_inicial = $dados['conteudo'];
                    $nome_link_inicial = $dados['nome_link'];
                }
            } else {
                if ($dados['id_conteudo'] == $this->post_request['id_conteudo']) {
                    $inicial = $dados['id_conteudo']; // inicializa o campo ID
                    $conteudo_inicial = $dados['conteudo'];
                    $nome_link_inicial = $dados['nome_link'];
                }
            }

            $valores[$i]['nome'] = $dados['nome_link'];
            $valores[$i]['id_conteudo'] = $dados['id_conteudo'];
            $valores[$i]['ac'] = $ac_01;
            $i++;
        }// fim do while



        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************INICIO
         */
        $hidden = Array();
        //$hidden['id_destinatario'] = $dados['id_emissor'];

        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************FIM
         */


        /*
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         * ***************INICIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();

        $colunas[0] = "<br><br>" . $this->form->dtree($valores, $inicial);
        $colunas[1] = "<font color=#000066 size=4><b>" . $nome_link_inicial . "</b></font>" . $this->form->textarea_TINYMCE("conte", $conteudo_inicial);
        $lin[0] = $colunas;


        $botoes = Array();
        $botoes[0] = $this->form->button("center", $this->traducao->get_leg01(), "button", "certeza_0(document.form1.id.value,'$ac')");


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
        $tpl->MODAIS = $this->criaModalLista($modais);
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
