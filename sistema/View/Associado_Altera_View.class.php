<?php

/**
 * View de alteração de Dados de Usuário
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
class Associado_Altera_View extends View {

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
        $this->traducao->loadTraducao("5082", $this->get_idioma());
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
        $co = base64_encode("Associado_Control"); // CONTROLLER
        $ac = base64_encode("Associado_Gerencia");
        $ac_01 = base64_encode("Associado_Altera");
        $ac_01v = base64_encode("Associado_Altera_V");
        $post = $ac_01;
        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************FIM
         */

        $JS = '  <script type="text/javascript">
            jQuery(document).ready(function ($) {

                $(\'#data_nascimento\').mask(\'00/00/0000\');
                $(\'#cpf_associado\').mask(\'000.000.000-00\');
                $(\'#telefone_residencial\').mask(SPMaskBehavior, spOptions);
                $(\'#telefone_trabalho\').mask(SPMaskBehavior, spOptions);
                $(\'#telefone_celular\').mask(SPMaskBehavior, spOptions);
                $(\'#cep\').mask(\'00000-000\');

            });
        </script>';


        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         * ***************INICIO
         */
        $hidden = Array();
        $hidden['cpf_associado_ok'] = 'sim';
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
        $componentes = Array("COUNTER", "CALENDAR");
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
        
        $data = new Data();
        $data_nascimento = $data->get_dataFormat('BD', $dados['data_nascimento'], 'DMA');


        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), true);
        $colunas[1] = $this->form->textfield("nome", $dados['nome']);
        Array_push($validacao, $this->form->validar('nome', 'value', '==', '""', $this->traducao->get_leg31(), Array("nome"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), true);
        $colunas[1] = $this->form->AJAX_existe_registro("cpf_associado", $dados['cpf'], 20, true, "", $this->traducao->get_leg27(), 20);
        Array_push($validacao, $this->form->validar('cpf_associado', 'value', '==', '""', $this->traducao->get_leg33(), Array("cpf"), $this->get_tema(), $this->get_idioma()));
        Array_push($validacao, $this->form->validar('cpf_associado_ok', 'value', '!=', '"sim"', $this->traducao->get_leg33(), Array("cpf"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), true);
        $colunas[1] = $this->form->textfield("matricula", $dados['matricula']);
        Array_push($validacao, $this->form->validar('matricula', 'value', '==', '""', $this->traducao->get_leg34(), Array("matricula"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), true);
        $colunas[1] = $this->form->textfield("data_nascimento", $data_nascimento);
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), true);
        $colunas[1] = $this->form->textfield("unidade_organizacional", $dados['unidade_organizacional']);
        Array_push($validacao, $this->form->validar('unidade_organizacional', 'value', '==', '""', $this->traducao->get_leg35(), Array("unidade_organizacional"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg06(), true);
        $colunas[1] = $this->form->textfield("email_pessoal", $dados['email_pessoal']);
        Array_push($validacao, $this->form->validar('email_pessoal', 'value', '==', '""', $this->traducao->get_leg36(), Array("email_pessoal"), $this->get_tema(), $this->get_idioma()));
        Array_push($validacao, $this->form->validar_email('email_pessoal', $this->traducao->get_leg36(), Array("email_pessoal"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg07(), false);
        $colunas[1] = $this->form->textfield("email_trabalho", $dados['email_trabalho']);
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg08(), true);
        $colunas[1] = $this->form->textfield("telefone_celular", $dados['telefone_celular']);
        Array_push($validacao, $this->form->validar('telefone_celular', 'value', '==', '""', $this->traducao->get_leg37(), Array("telefone_celular"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg09(), false);
        $colunas[1] = $this->form->textfield("telefone_residencial", $dados['telefone_residencial']);
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg10(), false);
        $colunas[1] = $this->form->textfield("telefone_trabalho", $dados['telefone_trabalho']);
        $lin[] = $colunas;

        $categoria = Array(
            'ativo' => 'Ativo',
            'aposentado' => 'Aposentado'
        );

        $colunas[0] = $this->form->texto($this->traducao->get_leg11(), true);
        $colunas[1] = $this->form->select("categoria", $this->traducao->get_leg21(), strtolower($dados['categoria']), $categoria, TRUE, 'Escolha uma categoria', "left", "");
        Array_push($validacao, $this->form->validar('categoria', 'value', '==', '"0"', $this->traducao->get_leg38(), Array("categoria"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg12(), true);
        $colunas[1] = $this->form->textfield("cep", $dados['cep'], 40);
        $lin[] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg13(), true);
        $colunas[1] = $this->form->textfield("endereco", $dados['endereco'], 80);
        Array_push($validacao, $this->form->validar('endereco', 'value', '==', '""', $this->traducao->get_leg39(), Array("endereco"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg14(), true);
        $colunas[1] = $this->form->textfield("numero", $dados['numero'], 20);
        Array_push($validacao, $this->form->validar('numero', 'value', '==', '""', $this->traducao->get_leg40(), Array("numero"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg15(), true);
        $colunas[1] = $this->form->textfield("complemento", $dados['complemento'], 60);
        Array_push($validacao, $this->form->validar('complemento', 'value', '==', '""', $this->traducao->get_leg41(), Array("complemento"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        $colunas[0] = $this->form->texto($this->traducao->get_leg16(), true);
        $colunas[1] = $this->form->textfield("bairro", $dados['bairro'], 60);
        Array_push($validacao, $this->form->validar('bairro', 'value', '==', '""', $this->traducao->get_leg42(), Array("bairro"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg17(), true);
        $colunas[1] = $this->form->textfield("cidade", $dados['cidade']);
        Array_push($validacao, $this->form->validar('cidade', 'value', '==', '""', $this->traducao->get_leg43(), Array("cidade"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $estado = Array(
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        );

        $colunas[0] = $this->form->texto($this->traducao->get_leg18(), true);
        $colunas[1] = $this->form->select("estado", $this->traducao->get_leg21(), $dados['estado'], $estado, TRUE, 'Escolha um estado', "left", "");
        Array_push($validacao, $this->form->validar('estado', 'value', '==', '"0"', $this->traducao->get_leg44(), Array("estado"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg19(), false);
        $colunas[1] = $this->form->textarea("observacoes", $dados['observacoes'], 70, 4);
        $lin[] = $colunas;

        /* DATA INÍCIO */
        $dados['data_inicio_filiacao'] = (!isset($dados['data_inicio_filiacao']) || $dados['data_inicio_filiacao'] == "") ? $this->dat->get_dataFormat("NOW", "", "DMA") : $this->dat->get_dataFormat("BD", $dados['data_inicio_filiacao'], "DMA");
        $colunas[0] = $this->form->texto($this->traducao->get_leg20(), false);
        $colunas[1] = $this->form->calendar("data_inicio_filiacao", $this->traducao->get_leg22(), $dados['data_inicio_filiacao'], false, $this->traducao->get_leg13(), "left");
        $lin[] = $colunas;

        /* DATA FIM */
        $dados['data_fim_filiacao'] = (!isset($dados['data_fim_filiacao']) || $dados['data_fim_filiacao'] == "") ? $this->dat->get_dataFormat("NOW", "", "DMA") : $this->dat->get_dataFormat("BD", $dados['data_fim_filiacao'], "DMA");
        $colunas[0] = $this->form->texto($this->traducao->get_leg21(), false);
        $colunas[1] = $this->form->calendar("data_fim_filiacao", $this->traducao->get_leg22(), $dados['data_fim_filiacao'], false, $this->traducao->get_leg13(), "left");
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
        /*
         * ************************************************************************************************************
         * MONTA O HTML E MOSTRA
         * ***************FIM
         */
    }

// fim do showView()
}

?>
