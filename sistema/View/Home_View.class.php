<?php

/**
 * View da Home do Sistema
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
class Home_View extends View {

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
        $this->traducao->loadTraducao("2001", $this->get_idioma());

        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Home_Control"); // CONTROLLER
        $ac = base64_encode("Home_V");
        $post = $ac;



        $titleX = (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 2) ? "Onde Conheceu?" :
                ((isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 1) ? "Assunto" :
                (((isset($this->post_request['selecao03']) && $this->post_request['selecao03'] == 0)) ? "Meses" :
                ((isset($this->post_request['data_inicio']) && $this->post_request['data_inicio'] != "") ? "Dias" : "Dias")));

        $param = (isset($this->post_request['selecao04']) && $this->post_request['selecao04'] != 0) ? "ano=" . $this->post_request['selecao04'] : "ano=" . date("Y");
        $param .= (isset($this->post_request['selecao03']) && $this->post_request['selecao03'] > 0) ? "&mes=" . $this->post_request['selecao03'] : ((isset($this->post_request['selecao03']) && $this->post_request['selecao03'] == 0) ? "" : "&mes=" . date("m"));
        $param .= (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] != 0) ? "&tipo=" . $this->post_request['selecao02'] : "";
        $param .= ((isset($this->post_request['data_inicio']) && $this->post_request['data_inicio'] != "") && (isset($this->post_request['data_fim']) && $this->post_request['data_fim'] != "")) ? "&data_inicio=" . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_inicio'], "AMD") . "&data_fim=" . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_fim'], "AMD") : "";
        
        /**
         * CONFIGURE AS JQUERY DA PÁGINA
         */
        $criaJs = '
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load("current", {"packages": ["corechart", "bar"], "language": "pt"});
                google.charts.setOnLoadCallback(drawChart);
                
                function drawChart() {                    
                    var jsonData = $.ajax({url: "AJAX_carrega_dados.php?' . $param . '", dataType: "json", async: false}).responseText;
                    var jsonResponse = JSON.parse(jsonData);
                    
                    var str = (jsonResponse.contador > 1) ? " contatos" : " contato";
                    $("#count").append("<font size=\"2\" color=\"#003300\" face=\"Verdana, Arial, Helvetica, sans-serif\">" + jsonResponse.contador + str + " no período</font>");
                    
                    var data = new google.visualization.DataTable(jsonResponse.grafico);
                    
                    var options = {
                        chartArea: {width: "90%"},
                        hAxis: {title: "' . $titleX . '", titleTextStyle: {fontName: "Arial", fontSize: "10", bold: false, italic: false, color: "#000000"}, textStyle: {fontName: "Arial", fontSize: "9", bold: false, italic: false, color: "#000000"}, textPosition: "out", baseline: 0, baselineColor: "#000000", direction: 1, format: "decimal"},
                        vAxis: {title: "Número de Contatos", titleTextStyle: {fontName: "Arial", fontSize: "10", bold: false, italic: false, color: "#000000"}, textStyle: {fontName: "Arial", fontSize: "10", bold: false, italic: false, color: "#000000"}, textPosition: "out", baseline: 0, baselineColor: "#000000", direction: 1, format: "decimal", gridlines: {color: "#cccccc", count: 8}},
                        annotations: {textStyle: {fontName: "Arial",fontSize: 10,bold: false,italic: false,color: "#000000"}},
                        legend: {position: "bottom", alignment: "start"},
                        tooltip: {textStyle: {fontName: "Arial", fontSize: "10", bold: false, italic: false, color: "#000000"},showColorCode: true},
                        seriesType: "bars",                        
                        crosshair: {color: "#000",trigger: "selection"},
                        curveType: "none", 
                        focusTarget: "datum", 
                        lineDashStyle: [0], 
                        lineWidth: 3, 
                        pointShape: "circle", 
                        pointSize: 5,
                        pointsVisible: true
                    }
                    var chart = new google.visualization.ComboChart(document.getElementById("Chart"));                    
                    chart.draw(data, options);
                }
            </script>
            ';

        /**
         * CONFIGURE O BOX DE INFORMAÇÕES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01();
        $texto_infoacao = $this->traducao->get_titulo_formulario02();


        /**
         * CONFIGURE OS FILTROS. ATENÇÃO !!! É NECESA?IO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $ctr_contato = new Contato_Control($this->post_request);
        $array_filtro = $ctr_contato->Lista_Array_Filtro();

        $filtros = Array();
        $array_tipo = array(1 => "Por Assunto", 2 => "Por Onde conheceu?");
        $filtros['selecao02']["width"] = "20%";
        $filtros['selecao02']["alinhamento"] = "left";
        $filtros['selecao02']["texto"] = "Filtrar por: ";
        $filtros['selecao02']["select"] = $this->form->select("selecao02", "Nenhum", isset($this->post_request['selecao02']) ? $this->post_request['selecao02'] : 0, $array_tipo, "", "submit_filtro(event,'submit')", "", false, "", "");

        $array_meses = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
        $filtros['selecao03']["width"] = "10%";
        $filtros['selecao03']["alinhamento"] = "left";
        $filtros['selecao03']["texto"] = "Filtrar por mês: ";
        $filtros['selecao03']["select"] = $this->form->select("selecao03", "Todos", isset($this->post_request['selecao03']) ? $this->post_request['selecao03'] : date("m"), $array_meses, "", "submit_filtro(event,'submit')", "", false, "", "");

        $filtros['selecao04']["width"] = "10%";
        $filtros['selecao04']["alinhamento"] = "left";
        $filtros['selecao04']["texto"] = "Filtrar por ano: ";
        $filtros['selecao04']["select"] = $this->form->select("selecao04", "Selecione", isset($this->post_request['selecao04']) ? $this->post_request['selecao04'] : date("Y"), $array_filtro['ano'], "", "submit_filtro(event,'submit')", "", false, "", "");

        $filtros['calendar01']["width"] = "28%"; // tamanho do campo
        $filtros['calendar01']["alinhamento"] = "left";
        $filtros['calendar01']["texto"] = "<div style=\"width:100%;float:left\">Filtrar por período:</div>";
        $filtros['calendar01']["calendario"] = "<div style=\"float:left\">" . $this->form->calendar("data_inicio", "Data Início", (isset($this->post_request['data_fim']) ? $this->post_request['data_inicio'] : ""), "") . "</div>
            <div style=\"float:right\">" . $this->form->calendar("data_fim", "Data Fim", (isset($this->post_request['data_fim']) ? $this->post_request['data_fim'] : ""), "") . "</div>
            ";

        $filtros['botao']["width"] = "5%"; // tamanho do campo
        $filtros['botao']["alinhamento"] = "center";
        $filtros['botao']["texto"] = "Filtrar";
        $filtros['botao']["botao"] = $this->form->button("center", "Filtrar", "button", "submit_filtro(event,'submit')", "botao", "margin: 8px 0px 0px 0px;");
//                . $this->form->button("center", "Limpar Filtro", "button", "limpar_filtro(event,'limpar')", "botao", "margin: 8px 0px 0px 5px;");

        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();

        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("CALENDAR");


        /**
         * CONFIGURE OS MODAIS.
         */
        $modais = Array();

        /**
         * CONFIGURE VALIDAÇÕES
         */
        $validacao = Array();


        /**
         * CONFIGURE O NAV
         */
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=$pagina"; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR       

        
        
        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $ano = (isset($this->post_request['selecao04'])) ? $this->post_request['selecao04'] : date("Y");
        $mes = (isset($this->post_request['selecao03'])) ? $this->post_request['selecao03'] : date("m");
        $title_tab = "Relatório do Contato de " . $ano;
        $title_tab = ($mes > 0) ? "Relatório do Contato de " . $array_meses[$mes] . "/$ano" : $title_tab;

        if (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 1) {
            $title_tab = ($mes > 0) ? "Relatório do Contato Por Assunto em " . $array_meses[$mes] . "/$ano" : "Relatório do Contato Por Assunto em $ano";
        }
        if (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 2) {
            $title_tab = ($mes > 0) ? "Relatório do Contato Por Onde Conheceu a ED? em " . $array_meses[$mes] . "/$ano" : "Relatório do Contato Por Onde Conheceu a ED? em $ano";
        }

        if ((isset($this->post_request['data_inicio']) && $this->post_request['data_inicio'] != "") && (isset($this->post_request['data_fim']) && $this->post_request['data_fim'] != "")) {
            $title_tab = "Relatório do Contato no Peíodo de " . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_inicio'], "DMA") . " à " . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_fim'], "DMA");
            if (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 1) {
                $title_tab = "Relatório do Contato Por Assunto no Peíodo de " . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_inicio'], "DMA") . " à " . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_fim'], "DMA");
            }
            if (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 2) {
                $title_tab = "Relatório do Contato Por Onde Conheceu a ED? no Peíodo de " . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_inicio'], "DMA") . " à " . $this->dat->get_dataFormat("CALENDARINICIO", $this->post_request['data_fim'], "DMA");
            }
        }


        $tam_tab = "99%";
        $saldo = "";
        
            include_once '../Libs/SMS.class.php';
            $sms = new SMS();
            $saldo = $sms->AccountBalance();
            $saldo = substr($saldo, 2);
            if ($saldo < 5) {
                $saldo = "<font size='3' color='red'>$saldo/SMS</font>";
            } else {
                $saldo = "<font size='3' color='green'>$saldo/SMS</font>";
            }

        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "100%";
        $campos[0]["texto"] = "";

        /**
         * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR Vï¿½O ALGUNS TRATAMENTOS.
         */
        $colunas = Array();
        $colunas[0]["alinhamento"] = "center";
        $colunas[0]["texto"] = '            
            <div id="Chart" style="width: 100%; height: 500px;"></div><br><br>
                <a style="float:left;margin-left:100px;" href="sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . base64_encode("Contato_Control") . '&ac=' . base64_encode("Contato_Gerencia") . '&' . $param . '">
                    <span style="float:left">
                    Fonte: <font size="2" color="#003300" face="Verdana, Arial, Helvetica, sans-serif">Relatório de Contatos do Site - </font>
                    </span>
                    <div style="float:left;margin-left:4px;" id="count"></div>
                </a>';

        $linhas[0] = $colunas;



        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Home.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JS .= $criaJs;
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);
        $tpl->TEMA = $this->get_tema();
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");
        $tpl->LEG01 = "Gerenciamento de Conteúdo";
        $tpl->ULTACESSO = $this->post_request['ultimo_acesso'];
        $tpl->SALDO = $saldo;
        $tpl->show();
    }

}

?>
