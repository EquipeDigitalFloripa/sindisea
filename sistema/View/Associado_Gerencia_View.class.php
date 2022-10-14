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
class Associado_Gerencia_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {

        /* CONFIGURE O ID DE TRADUCAO DA VIEW */
        $this->traducao->loadTraducao("5083", $this->get_idioma());



        /* CONFIGURE AS POSSIVEIS ACOES */
        $co = base64_encode("Associado_Control"); // CONTROLLER
        $ac = base64_encode("Associado_Gerencia");
        $ac_apaga = base64_encode("Associado_Apaga");
        $ac_ativa = base64_encode("Associado_Ativa");
        $ac_desativa = base64_encode("Associado_Desativa");
        $ac_download = base64_encode("Associado_Lista_Download");
        $ac_altera = base64_encode("Associado_Altera_V");
        $ac_pass = base64_encode("Associado_Pass_V");
        $ac_imprimir = base64_encode("Associado_Imprimir");
        $post = $ac;



        /* CONFIGURE OS CAMPOS HIDDEN */
        $hidden = Array();


        /* CONFIGURE OS COMPONENTES QUE DEVE CARREGAR */
        $componentes = Array("TOOLTIP");


        /* CONFIGURE O NAV */
        $pesquisa = isset($this->post_request['pesquisa']) ? $this->post_request['pesquisa'] : "";
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 1;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=" . $pagina; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=" . $pesquisa;


        /* CONFIGURE O BOX DE INFORMAÇÔES */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // título do box de informações
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informações


        /* CONFIGURE OS FILTROS. ATENCAO !!! É NECESSÁRIO EFETUAR CONFIGURAÇÕES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE */
        $selecao01 = isset($this->post_request['selecao01']) ? $this->post_request['selecao01'] : 1;
        $selecao02 = isset($this->post_request['selecao02']) ? $this->post_request['selecao02'] : 0;


        $filtros = Array();
        $filtros['pesquisa']["width"] = "10%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "left";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();

        $filtros['selecao01']["width"] = "10%"; // tamanho do campo
        $filtros['selecao01']["alinhamento"] = "left";
        $filtros['selecao01']["texto"] = "Por Status";
        $filtros['selecao01']["select"] = $this->form->select("selecao01", "Selecione", $selecao01, array(0 => "Todos", 'A' => "Ativo", 'I' => "Inativo"), "", "download(event,'submit')", "", false, "", "");

        $filtros['selecao02']["width"] = "10%"; // tamanho do campo
        $filtros['selecao02']["alinhamento"] = "left";
        $filtros['selecao02']["texto"] = "Relatórios";
        $filtros['selecao02']["select"] = $this->form->select("selecao02", "Todos", $selecao02, array(1 => "Relatório de E-mails ", 2 => "Relatório de Endereços", 3 => "Relatório de Aposentados"), "", "submit_filtro(event,'submit')", "", false, "", "");

        $filtros['botao']["width"] = "100%"; // tamanho do campo
        $filtros['botao']["alinhamento"] = "right";        
        $filtros['botao']["botao"] = $this->form->button("center", "GERAR PDF", "button", "imprimir()", "botao-printer", "");
        
        $filtros['botao01']["width"] = "0%"; // tamanho do campo
        $filtros['botao01']["alinhamento"] = "right";
        $filtros['botao01']["botao01"] = $this->form->button("left", "EXPORTAR XLS", "button", "download()");



        /* CONFIGURE A PAGINACAO */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do número de páginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $pesquisa;



        /* CONFIGURE A LISTA DE ITENS */
        $tam_tab = "99%"; // tamanho da tabela que lista os itens em %
        $title_tab = ($selecao02 == 3) ? 'Lista de Filiados Aposentados - ' . $this->total_reg : 'Lista de Filiados - ' . $this->total_reg;            

        


        /* CONFIGURE o topo da tabela que mostra a lista de elementos */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "4%";
        $campos[0]["texto"] = $this->traducao->get_leg01();

        $campos[1]["tamanho_celula"] = "28%";
        $campos[1]["texto"] = $this->traducao->get_leg02();

        $campos[2]["tamanho_celula"] = "34%";
        $campos[2]["texto"] = $this->traducao->get_leg03();

        $campos[3]["tamanho_celula"] = "8%";
        $campos[3]["texto"] = $this->traducao->get_leg04();

        $campos[4]["tamanho_celula"] = "8%";
        $campos[4]["texto"] = $this->traducao->get_leg04();

        $campos[5]["tamanho_celula"] = "10%";
        $campos[5]["texto"] = $this->traducao->get_leg05();

        $campos[6]["tamanho_celula"] = "8%";
        $campos[6]["texto"] = $this->traducao->get_leg06();




        /* Seleciona os elementos que serão mostrados e configura as linhas da tabela */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {

            $dados = $this->objetos[$i]->get_all_dados();

            // aplica regra de recebimento no array de dados
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, 'ISO-8859-1');
            }



            /* CONFIGURE o tooltip de INFO */
            $inf = Array();
            $inf["" . $this->traducao->get_leg21() . ""] = $dados['matricula'];
            $inf["" . $this->traducao->get_leg22() . ""] = $dados['unidade_organizacional'];
            $inf["" . $this->traducao->get_leg23() . ""] = $dados['categoria'];
            $inf["" . $this->traducao->get_leg24() . ""] = $dados['cep'];
            $inf["" . $this->traducao->get_leg25() . ""] = $dados['endereco'];
            $inf["" . $this->traducao->get_leg26() . ""] = $dados['numero'];
            $inf["" . $this->traducao->get_leg27() . ""] = $dados['bairro'];
            $inf["" . $this->traducao->get_leg28() . ""] = $dados['cidade'];
            $inf["" . $this->traducao->get_leg29() . ""] = $dados['estado'];

            $infos = $this->criaInfo($inf);



            /* CONFIGURE OS MODAIS. */
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



            /* CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ */
            if ($dados['status_associado'] == "A") {
                $ad = "<span class=\"texto_conteudo_tabela\">
                            <a href=\"javascript:certeza_2(" . $dados['id_associado'] . ")\" title=\"" . $this->traducao->get_leg13() . "\">
                                <img src=\"temas/" . $this->get_tema() . "/icones/desativar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg16() . "
                            </a>
                        </span>";
            } else {
                $ad = "<span class=\"texto_conteudo_tabela\">
                            <a href=\"javascript:certeza_1(" . $dados['id_associado'] . ")\" title=\"" . $this->traducao->get_leg14() . "\">
                                <img src=\"temas/" . $this->get_tema() . "/icones/ativar.png\" width=\"25\" height=\"25\" align=\"center\"  border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg17() . "
                            </a>
                        </span>";
            }


            /* CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS. */
            $colunas = Array();
            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = "$infos";

            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"] = '<strong>CPF: </strong> <font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['cpf'] . '</font><br>
                                <strong>Nome: </strong> <font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['nome'] . '</font><br>
                                <strong>Tel. Residencial: </strong> <font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['telefone_residencial'] . '</font><br>
                                <strong>Tel. Trabalho: </strong> <font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['telefone_trabalho'] . '</font><br>
                                <strong>Tel. Celular: </strong> <font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['telefone_celular'] . '</font><br>
                                    ';

            $colunas[2]["alinhamento"] = "left";
            $colunas[2]["texto"] = '<strong>CEP: </strong><font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['cep'] . '</font><br>
                <strong>Endereço: </strong><font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['endereco'] . ', ' . $dados['numero'] . ' - ' . $dados['complemento'] . '</font><br>
                <strong>Bairro: </strong><font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['bairro'] . '</font><br>
                <strong>Cidade: </strong><font size="2" color="003399" face="Verdana, Arial, Helvetica, sans-serif">' . $dados['cidade'] . '</font>';

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "<span class=\"texto_conteudo_tabela\"><a href=\"javascript:submit_campo(" . $dados['id_associado'] . ",'$ac_altera');\"><img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "</a></span>";

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = "<span class=\"texto_conteudo_tabela\"><a href=\"javascript:submit_campo(" . $dados['id_associado'] . ",'$ac_pass');\"><img src=\"temas/" . $this->get_tema() . "/icones/senha.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg12() . "</a></span>";

            $colunas[5]["alinhamento"] = "center";
            $colunas[5]["texto"] = $ad;

            $colunas[6]["alinhamento"] = "center";
            $colunas[6]["texto"] = "<span class=\"texto_conteudo_tabela\"><a href=\"javascript:certeza_0(" . $dados['id_associado'] . ")\"><img src=\"temas/" . $this->get_tema() . "/icones/apagar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg15() . "</a></span>";

            $linhas[$i] = $colunas;


            $i++;
        }



        /* CONFIGURA JAVASCRIPT DA PÁGINA */
        $js = '
            <script>
                var imprimir = function(){
                    
                    $.ajax({                                    
                        url: "sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . $ac_imprimir . '",
                        type: "POST", cache: false, async: true,
                        data: "selecao01=' . $selecao01 . '&selecao02=' . $selecao02 . '&pesquisa=' . $pesquisa . '",                        
                        beforeSend : function(){
                        },
                        success: function (data) {   
                            window.open("../sys/arquivos/file.pdf", "_blank");
                        }
                    });
                };
                var download = function (){
                     $.ajax({
                        url: "/sistema/sys/sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . $ac_download . '",
                        beforeSend : function(){
                           displayMessage("temas/1/modal/msg_processando.php?tema=1&idioma=' . $this->get_idioma() . '&msg=' . rawurlencode("oi caio") . '");
                        },
                        success: function (data){
                            closeMessage();
                            window.open("./arquivos/Filiados.xls", "_blank");
                        }
                    });
                  }
            </script>';







        /* CONFIGURE O ARQUIVO DE TEMPLATE. */
        $tpl = new Template("../Templates/Gerencia.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JS .= $js;
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao = array(), $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao, "");
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }

}

?>
