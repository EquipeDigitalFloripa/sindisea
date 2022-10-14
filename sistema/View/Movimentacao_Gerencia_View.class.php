<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View Gerencia Usuários, filho de View
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package View
 *
 */
class Movimentacao_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("5090", $this->get_idioma());
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
        $ac_apaga = base64_encode("Movimentacao_Apaga");
        $ac_ativa = base64_encode("Movimentacao_Ativa");
        $ac_desativa = base64_encode("Movimentacao_Desativa");
        $ac_altera = base64_encode("Movimentacao_Altera_V");

        $ac_imprimir = base64_encode("Movimentacao_Imprimir");
        $post = $ac;
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
        //$hidden['exemplo']    = $this->post_request['exemplo'];
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
        $componentes[1] = "CALENDAR";
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
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=" . $this->post_request['pesquisa'];
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

        $selecao04 = (isset($this->post_request['selecao04'])) ? $this->post_request['selecao04'] : date("m");
        $selecao03 = (isset($this->post_request['selecao03'])) ? $this->post_request['selecao03'] : date("Y");
//        $calendar01 = (isset($this->post_request['calendar01'])) ? $this->post_request['calendar01'] : date('01/m/Y');
//        $calendar02 = (isset($this->post_request['calendar02'])) ? $this->post_request['calendar02'] : date('d/m/Y');
        $selecao01 = isset($this->post_request['selecao01']) ? $this->post_request['selecao01'] : 0;
        $selecao02 = isset($this->post_request['selecao02']) ? $this->post_request['selecao02'] : 0;
        $filtros = Array();


        $meses = array("01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro");

        $filtros['selecao04']["width"] = "10%"; // tamanho do campo
        $filtros['selecao04']["alinhamento"] = "left";
        $filtros['selecao04']["texto"] = "Mês:";
        $filtros['selecao04']["select"] = $this->form->select("selecao04", "", $selecao04, $meses, "", "submit_filtro(event,'submit')", "", false, "", "");

        $filtros['selecao03']["width"] = "10%"; // tamanho do campo
        $filtros['selecao03']["alinhamento"] = "left";
        $filtros['selecao03']["texto"] = "Ano:";
        $filtros['selecao03']["select"] = $this->form->select("selecao03", "", $selecao03, array("2018" => "2018", "2019" => "2019", "2020" => "2020"), "", "submit_filtro(event,'submit')", "", false, "", "");


//        $filtros['calendar01']["width"] = "5%"; // tamanho do campo
//        $filtros['calendar01']["alinhamento"] = "left";
//        $filtros['calendar01']["texto"] = "Data Início";
//        $filtros['calendar01']["calendario"] = $this->form->calendar("calendar01", "Selecionar data", $calendar01);
//
//        $filtros['calendar02']["width"] = "5%"; // tamanho do campo
//        $filtros['calendar02']["alinhamento"] = "left";
//        $filtros['calendar02']["texto"] = "Data Fim";
//        $filtros['calendar02']["calendario"] = $this->form->calendar("calendar02", "Selecionar data", $calendar02);

        $filtros['pesquisa']["width"] = "80%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "left";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        $filtros['selecao01']["width"] = "5%"; // tamanho do campo
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = "Tipo";
        $filtros['selecao01']["select"] = $this->form->select("selecao01", "Todos", $selecao01, $this->descricoes['tipo_movimentacao'], "", "", "", false, "", "");

        $filtros['selecao02']["width"] = "5%"; // tamanho do campo
        $filtros['selecao02']["alinhamento"] = "left";
        $filtros['selecao02']["texto"] = "Centro de Custo";
        $filtros['selecao02']["select"] = $this->form->select("selecao02", "Todos", $selecao02, $this->descricoes['centro'], "", "", "", false, "", "");


        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************INICIO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $this->post_request['pesquisa'];
        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         * ***************INICIO
         */
        $tam_tab = "900"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela que lista os itens
        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************INICIO
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "10%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "25%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "20%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "10%";
        $campos[3]["texto"] = $this->traducao->get_leg04();

        $campos[4]["tamanho_celula"] = "15%";
        $campos[4]["texto"] = $this->traducao->get_leg05();

        $campos[5]["tamanho_celula"] = "10%";
        $campos[5]["texto"] = $this->traducao->get_leg06();

        $campos[6]["tamanho_celula"] = "10%";
        $campos[6]["texto"] = $this->traducao->get_leg07();



        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         * ***************INICIO
         */
        $linhas = Array();
        $i = 0;


        $botoes = Array();
        $botoes[0] = (count($this->objetos) > 0) ? $this->form->button("center", "  IMPRIMIR  ", "button", "imprimir()", "botao-printer", "") : '';

        $ctr_valcentro = new ValorCentro_Control($post_request);
        $valores_centro = $ctr_valcentro->Pegar_Valores($selecao03 . "-" . "$selecao04" . "-01");
        foreach ($valores_centro as $chave => $valor) {
            $valor_total += $valor;
            $centro_custo .= '<tr>
                                        <td style="width:80%;">' . $this->descricoes[centro][$chave] . '</td>
                                        <td style="width:20%; text-align:right; border-bottom: 1px solid black">R$ ' . $valor . '</td>
                                        </tr>';
        }
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();

            // aplica regra de recebimento no array de dados
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), null, "ISO-8859-1");
            }

            /*
             * ******************************************************************************************
             * CONFIGURE OS MODAIS.
             * ***************INICIO
             */
            $modais = Array();

            $modais[0]['campos'] = Array('ac' => $ac_apaga);
            $modais[0]['acao'] = "apagar";
            $modais[0]['msg'] = $this->traducao->get_leg31();

            $modais[1]['campos'] = Array('ac' => $ac_ativa);
            $modais[1]['acao'] = "ativar";
            $modais[1]['msg'] = $this->traducao->get_leg32();

            $modais[2]['campos'] = Array('ac' => $ac_desativa);
            $modais[2]['acao'] = "desativar";
            $modais[2]['msg'] = $this->traducao->get_leg33();
            /*
             * ******************************************************************************************
             * CONFIGURE OS MODAIS.
             * ***************FIM
             */

            /*
             * ******************************************************************************************
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             * ***************INICIO
             */


            /*
             * ******************************************************************************************
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             * ***************FIM
             */

            /*
             * ******************************************************************************************
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
             * ***************INICIO
             */


            $colunas = Array();

            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = "<strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">
                    " . $this->dat->get_dataFormat('BD', $dados['data_competencia'], 'DMA') . "</font></strong>
                        ";

            $colunas[1]["alinhamento"] = "center";
            $colunas[1]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                            <font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['descricao'] . "</font>
                                    </span>
                                                ";

            $colunas[2]["alinhamento"] = "center";
            $colunas[2]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                            <font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">R$" . $dados['valor_mov'] . "</font>
                                    </span>
                                                ";

            $id_tipo = $dados['tipo_movimentacao'];
            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                            <font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $this->descricoes['tipo_movimentacao'][$id_tipo] . "</font>
                                    </span>
                                                ";

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                            <font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $this->descricoes['centro'][$dados['id_centro']] . "</font>
                                    </span>
                                                ";

            $colunas[5]["alinhamento"] = "center";
            $colunas[5]["texto"] = "
                                            <span class=\"texto_conteudo_tabela\">
                                            <a href=\"javascript:submit_campo(" . $dados['id_movimentacao'] . ",'$ac_altera');\">
                                                <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\"  align=\"left\" border=\"0\" hspace=\"2\">" . $this->traducao->get_leg11() . "
                                            </a>
                                            </span>";

            $colunas[6]["alinhamento"] = "center";
            $colunas[6]["texto"] = "
                                            <span class=\"texto_conteudo_tabela\">
                                            <a href=\"javascript:certeza_0(" . $dados['id_movimentacao'] . ")\">
                                                <img src=\"temas/" . $this->get_tema() . "/icones/del.png\" width=\"15\" height=\"15\" align=\"left\" border=\"0\" hspace=\"2\">" . $this->traducao->get_leg15() . "
                                            </a>
                                            </span>";

            if ($id_tipo == 1 AND $dados['id_centro'] > 2) {
                $valor_total_entrada += $dados['valor_mov'];
                $valor_entrada .= '<tr style="border-bottom: 1px solid black">
                                            <td>' . $this->dat->get_dataFormat('BD', $dados['data_competencia'], 'DMA') . '</td>
                                            <td>' . $dados['descricao'] . '</td>
                                            <td>' . $this->descricoes['centro'][$dados['id_centro']] . '</td>
                                            <td>R$ ' . $dados['valor_mov'] . '</td>
                                        </tr>';
            }

            if ($id_tipo == 2 AND $dados['id_centro'] > 2) {
                $valor_total_saida += $dados['valor_mov'];
                $valor_saida .= '<tr style="border-bottom: 1px solid black">
                                            <td>' . $this->dat->get_dataFormat('BD', $dados['data_competencia'], 'DMA') . '</td>
                                            <td>' . $dados['descricao'] . '</td>
                                            <td>' . $this->descricoes['centro'][$dados['id_centro']] . '</td>
                                            <td>R$ ' . $dados['valor_mov'] . '</td>
                                        </tr>';
            }

            if ($dados['id_centro'] <= 2) {
                if ($id_tipo == 2) {
                    $color = "red";
                    $valor_total_investimento -= $dados['valor_mov'];
                } else {
                    $valor_total_investimento += $dados['valor_mov'];
                    $color = "black";
                }
                $valor_investimento .= '<tr style="border-bottom: 1px solid black; color: ' . $color . '">
                                            <td>' . $this->dat->get_dataFormat('BD', $dados['data_competencia'], 'DMA') . '</td>
                                            <td>' . $dados['descricao'] . '</td>
                                            <td>' . $this->descricoes['centro'][$dados['id_centro']] . '</td>
                                            <td>R$ ' . $dados['valor_mov'] . '</td>
                                        </tr>';
            }

            $linhas[$i] = $colunas;
            if ($id_tipo == 1) {
                $valores_centro[$dados['id_centro']] += $dados['valor_mov'];
            } else {
                $valores_centro[$dados['id_centro']] -= $dados['valor_mov'];
            }

            /**
             * ******************************************************************************************
             * CONFIGURE as colunas de cada linha da tabela.
             * ***************FIM
             */
            $i++;
        }

        foreach ($valores_centro as $chave => $valor) {
            $valor_total2 += $valor;
            $centro_custo2 .= '<tr>
                                        <td style="width:80%;">' . $this->descricoes[centro][$chave] . '</td>
                                        <td style="width:20%; text-align:right; border-bottom: 1px solid black">R$ ' . $valor . '</td>
                                        </tr>';
        }
        $tabel_impressao = '<div style="visibility: hidden; position:absolute !important; top: -10000px; left: -10000px;">
                                <div id="tb_detalhes">                               
                                    <div style="border-bottom: 1px solid black; border-top: 1px solid black; font-size: 15px; text-align: center;">BALANCETE JUNHO 2019</span></div>
                                    <table width="100%" cellspacing="0" style="padding-top: 10px; font-size: 10px; font-weight: bold;">
                                    <tr>
                                        <td style="width:80%;">Saldos Anteriores</td>
                                        <td style="width:20%; text-align:right; border-bottom: 1px solid black">R$ ' . $valor_total . '</td>
                                    </tr>
                                    </table>

                                    <table width="100%" cellspacing="0" style="padding-top: 10px; font-size: 9px;">
                                        ' . $centro_custo . '
                                    </table>
                                    <br><br>
                                    <table width="100%" cellspacing="0" style="padding-top: 10px; font-size: 10px; font-weight: bold;">
                                        <tr>
                                            <td style="width:80%;">Entradas</td>
                                            <td style="width:20%; text-align:right; border-bottom: 1px solid black">R$ ' . $valor_total_entrada . '</td>
                                        </tr>
                                    </table>

                                    <table class="valores" width="100%" cellspacing="0" style="padding-top: 10px; font-size: 9px;">                                        
                                        ' . $valor_entrada . '
                                    </table>
                                    <br><br>
                                    <table width="100%" cellspacing="0" style="padding-top: 10px; font-size: 10px; font-weight: bold;">
                                        <tr>
                                            <td style="width:80%;">Saídas</td>
                                            <td style="width:20%; text-align:right; border-bottom: 1px solid black">R$ ' . $valor_total_saida . '</td>
                                        </tr>
                                    </table>

                                    <table class="valores" width="100%" cellspacing="0" style="padding-top: 10px; font-size: 9px;">
                                        ' . $valor_saida . '
                                    </table>
                                    <br><br>
                                    <table width="100%" cellspacing="0" style="padding-top: 10px; font-size: 10px; font-weight: bold;">
                                        <tr>
                                            <td style="width:80%;">Investimentos</td>
                                            <td style="width:20%; text-align:right; border-bottom: 1px solid black">R$ ' . $valor_total_investimento . '</td>
                                        </tr>
                                    </table>

                                    <table class="valores" width="100%" cellspacing="0" style="padding-top: 10px; font-size: 9px;">
                                        ' . $valor_investimento . '
                                    </table>
                                    <br><br>
                                    <table width="100%" cellspacing="0" style="padding-top: 10px; font-size: 10px; font-weight: bold;">
                                    <tr>
                                        <td style="width:80%;">Saldos Anteriores</td>
                                        <td style="width:20%; text-align:right; border-bottom: 1px solid black">R$ ' . $valor_total2 . '</td>
                                    </tr>
                                    </table>

                                    <table width="100%" cellspacing="0" style="padding-top: 10px; font-size: 9px;">
                                        ' . $centro_custo2 . '
                                    </table>
                                </div>
                            </div>
                            ';

        /*
         * ************************************************************************************************************
         * Seleciona os elementos que serão mostrados e configura as linhas da tabela
         * ***************FIM
         */

        /*
         * ************************************************************************************************************
         * MONTA O HTML E MOSTRA
         * ***************INICIO
         */
        /* CONFIGURA JAVASCRIPT DA PÁGINA */
        $js = '
            <script>
            var imprimir = function(){
                    var html = $("#tb_detalhes").html();
                    console.log(html);
                        $.ajax({                                    
                            url: "sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . $ac_imprimir . '",
                            type: "POST",
                            cache: false,
                            data: "html=" + html + "",
                            success: function (data) {                            
                                window.open("../sys/arquivos/pdf/file_balancete.pdf", "_blank");
                            }
                        });
                    };
                $(document).ready(function(){
                    $("#calendar01, #calendar02").mask("00/00/0000");
                })
            </script>';
        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         * ***************INICIO
         */

        $tpl = new Template("../Templates/Gerencia.html");
        /*
         * ******************************************************************************************
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         * ***************FIM
         */
        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JS .= $js;
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        //$tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao, $botoes) . $tabel_impressao;
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
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

// Fim da classe
?>
