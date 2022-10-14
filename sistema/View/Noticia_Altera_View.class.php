<?php

/**
 * View de Alteração de dados da Notícia
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 11/07/2016
 * @package View
 *
 */
class Noticia_Altera_View extends View {

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
        $this->traducao->loadTraducao("3012", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Noticia_Control"); // CONTROLLER
        $ac = base64_encode("Noticia_Altera");
        $ac_v = base64_encode("Noticia_Altera_V");
        $ac_excluir_relacao = base64_encode("Noticia_Conteudo_Apaga");
        $post = $ac;

        $criaJs = '
                <script>
                                     
                    $(document).ready(function (){
                        $("#titulo_noticia").keyup(function(){
                            
                            str = $("#titulo_noticia").val();
                            str = str.toLowerCase();
                            str = str.replace(/[àáâã]/gi, "a");
                            str = str.replace(/[èéê]/gi, "e");
                            str = str.replace(/[ìíî]/gi, "i");
                            str = str.replace(/[òóôõ]/gi, "o");
                            str = str.replace(/[ùúû]/gi, "u");
                            str = str.replace(/[ç]/gi, "c");
                            str = str.replace(/[^a-z0-9-\s]/gi, "");
                            str = str.replace(/[_\s]/g, "-");

                            $("#url_amigavel").val(str);
                            
                            $.ajax( {
                                url: "AJAX_url_amigavel.php",
                                type: "POST",
                                data: "string=" + str,
                                cache: false,
                                async: true,
                                dataType: "json",
                                beforeSend: function () {
                                },
                                success: function (data, textStatus, jqXHR) {
                                    
                                    console.log(data.sucesso);
                                    if(data.sucesso > 0){
                                        $("#habilitado").html("<img style=\"float:left\" src=\"temas/1/icones/alerta.png\" width=\"20\" height=\"20\" align=\"middle\" border=\"0\" hspace=\"6\"><font size=\"1\" color=\"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\" style=\"float:left;margin-top:5px;\">URL está sendo utilizada em outra notícia.</font>");
                                    }else{
                                        $("#habilitado").html("<img style=\"float:left\" src=\"temas/1/icones/ativar.png\" width=\"25\" height=\"25\" align=\"middle\" border=\"0\" hspace=\"2\"><font size=\"1\" color=\"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\" style=\"float:left;margin-top:7px;\">URL liberada para esta notícia.</font>");
                                    }
                                    
                                }
                            });
                        });  
                    });
                    
                </script>
            ';


        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();

        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");
        $componentes[1] = "CALENDAR";
        $componentes[2] = "TINYMCE_EXACT";

        /**
         * CONFIGURE O NAV
         */
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal
        $retorno_nav = "pagina=$pagina"; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR


        /**
         * CONFIGURE O BOX DE INFORMAÇOES
         */
        $titulo_noticia_infoacao = $this->traducao->get_titulo_formulario01(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es

        /**
         * CONFIGURE A TABELA 
         */
        $tam_tab = "960"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // tï¿½tulo da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = "center";
        $col[0]['width'] = "20%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = FALSE;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "80%";

        $ctr_rel_conteudo = new RelacaoConteudo_Control($this->post_request);

        $dados = $this->objetos->get_all_dados();
        foreach ($dados as $chave => $valor) {
            $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, 'ISO-8859-1');
        }


        $dados_rel_conteudo = $ctr_rel_conteudo->Lista_Relacao_Conteudo(" AND id_noticia = " . $dados['id_noticia'] . "");
        $i = 0;
        while ($i < count($dados_rel_conteudo)) {
            $dados_conteudo[$i] = $dados_rel_conteudo[$i]['id_conteudo'];
            $i++;
        }


        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();


        /* DATA DA NOTÍCIA */
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), TRUE);
        $colunas[1] = $this->form->calendar("data_noticia", $this->traducao->get_leg11(), $this->dat->get_dataFormat("BD", $dados['data_noticia'], "DMA"), TRUE, $this->traducao->get_leg12(), "left");
        $lin[] = $colunas;

        /* DATA DA PUBLICAÇÃO */
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), TRUE);
        $colunas[1] = $this->form->calendar("data_publicacao_noticia", $this->traducao->get_leg11(), $this->dat->get_dataFormat("BD", $dados['data_publicacao_noticia'], "DMA"), TRUE, $this->traducao->get_leg13(), "left");
        $lin[] = $colunas;

        /* DATA DE EXPIRAÇÃO */
//        $data_expira = ($dados['data_expiracao_noticia'] == '0000-00-00 00:00:00') ? "" : $this->dat->get_dataFormat("BD", $dados['data_expiracao_noticia'], "DMA");
//        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), FALSE);
//        $colunas[1] = $this->form->calendar("data_expiracao_noticia", $this->traducao->get_leg11(), $data_expira, TRUE, $this->traducao->get_leg14(), "left");
//        $lin[] = $colunas;

        $i = 0;
        $tr = "";
        while ($i < count($dados_rel_conteudo)) {
            $nome_link = $ctr_rel_conteudo->Pega_Pagina($dados_rel_conteudo[$i]['id_conteudo']);
            $tr .= '<tr>
                        <td>
                            <font size="2" color="#003399" face="Verdana, Arial, Helvetica, sans-serif">' . $nome_link . '</font>
                        </td>
                        <td>
                            <a href="javascript:submit_campo(' . $dados_rel_conteudo[$i]['id_rel_conteudo'] . ',\'' . $ac_excluir_relacao . '\');">
                                <img src="temas/' . $this->get_tema() . '/icones/desativar.png" width="25" height="25" align="center" border="0" hspace="2">
                            </a>
                        </td>
                    </tr>';
            $i++;
        }

        /* RELACIONAR CONTEUDO */
//        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), FALSE);
//        $colunas[1] = $this->form->select_multiple("id_conteudo[]", $this->traducao->get_leg21(), $dados_conteudo, $this->descricoes['paginas'], TRUE, $this->traducao->get_leg15(), "left", "");
//        $colunas[1] .= '<table width="400px" align="right" border="0">
//                            <tr>
//                                <td width="90%"><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">Paginas Relacionadas</font></td>
//                                <td width="10%"><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">Excluir</font></td>
//                            </tr>
//                            ' . $tr . '
//                       </table>
//                        ';
//        $lin[] = $colunas;


        /* CATEGORIA DA NOTICA */
        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), TRUE);
        $colunas[1] = $this->form->select("id_categoria_noticia", $this->traducao->get_leg21(), $dados['id_categoria_noticia'], $this->descricoes['categoria_noticia'], TRUE, 'Escolha uma categoria para a Notícia', "left", "");
        Array_push($validacao, $this->form->validar('id_categoria_noticia', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("id_categoria_noticia"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        /* TÍTULO DA NOTICIA */
        $colunas[0] = $this->form->texto($this->traducao->get_leg06(), TRUE); 
        $colunas[1] = $this->form->textarea("titulo_noticia", $dados['titulo_noticia'], 60, 1, FALSE, 250, FALSE, $this->traducao->get_leg23(), "left");        
        Array_push($validacao, $this->form->validar('titulo_noticia', 'value', '==', '""', $this->traducao->get_leg32(), Array("titulo_noticia"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        /* URL AMIGÁVEL */
        $colunas[0] = $this->form->texto($this->traducao->get_leg09(), TRUE);
        $colunas[1] = '<span style="float: left;">' . $this->form->textarea("url_amigavel", $dados['url_amigavel'], 60, 1, FALSE, 250, FALSE, $this->traducao->get_leg23(), "left") . '</span>';
        $colunas[1] .= '<span id="habilitado" style="float: left;"></span>';
        Array_push($validacao, $this->form->validar('url_amigavel', 'value', '==', '""', $this->traducao->get_leg32(), Array("url_amigavel"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;
        

        /* DESCRIPTION DA NOTÍCIA */
        $colunas[0] = $this->form->texto($this->traducao->get_leg07(), FALSE);
        $colunas[1] = $this->form->textarea("description_noticia", $dados['description_noticia'], 70, 2, true, 250, true, $this->traducao->get_leg23(), "left");
        Array_push($validacao, $this->form->validar('description_noticia', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("description_noticia"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        /* TEXTO DO POST */
        $colunas[0] = $this->form->texto($this->traducao->get_leg08(), FALSE);
        $colunas[1] = $this->form->textarea_TINYMCE("texto_noticia", $dados['texto_noticia']);
        $lin[] = $colunas;


        $botoes = Array();
        $botoes[0] = '<a href="sys.php?id_sessao=' . $this->get_id_sessao() . '&idioma=' . $this->get_idioma() . '&co=' . $co . '&ac=' . base64_encode("Noticia_Gerencia") . '">
                        ' . $this->form->button("center", "    Voltar  ", "button", FALSE, "botao", "margin:10px") . '
                     </a>';
        $botoes[1] = $this->form->button("center", "    Salvar  ", "button", "validar()", "botao", "margin:10px");


        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE. 
         */
        $tpl = new Template("../Templates/Formulario.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JS .= $criaJs;
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_noticia_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }

}

?>
