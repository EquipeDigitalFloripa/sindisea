<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de alteração de Galerias
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
class Galeria_Altera_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {
        $this->traducao->loadTraducao("3047", $this->get_idioma());

        $co = base64_encode("Galeria_Control"); // CONTROLLER
        $ac = base64_encode("Galeria_Gerencia");
        $ac_01 = base64_encode("Galeria_Altera");
        $ac_01v = base64_encode("Galeria_Altera_V");
        $post = $ac_01;

      
        $hidden = Array();
        

        $componentes = Array("COUNTER");
        $componentes[1] = "CALENDAR";
        $componentes[2] = "TINYMCE_EXACT";
       
        
        $control_div = "NAO"; 
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR

        
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // tï¿½tulo do box de informaï¿½ï¿½es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informaï¿½ï¿½es


        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // tï¿½tulo da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['width'] = "75%";

        
        $dados = $this->objetos->get_all_dados();
        foreach ($dados as $chave => $valor) {
            $dados[$chave] = stripslashes($valor);
        }


        $lin = Array();
        $colunas = Array();
        $validacao = Array();
        
        // Categoria
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(),true);
        $colunas[1] = $this->form->select("id_categoria_galeria",$this->traducao->get_leg21(), $dados["id_categoria_galeria"],$this->descricoes['nome_categoria']);
        array_push($validacao, $this->form->validar('id_categoria_galeria','value', '==', '"0"',$this->traducao->get_leg31(),Array("id_categoria_galeria"),$this->get_tema(),$this->get_idioma()));
        $lin[0] = $colunas;
        
        // Data
        $data_galeria = $this->dat->get_dataFormat("BD", $dados['data_galeria'], "DMA");
        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), FALSE);
        $colunas[1] = $this->form->calendar("data_galeria", $this->traducao->get_leg11(), $data_galeria, "");
        $lin[] = $colunas;

        // Nome
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), FALSE);
        $colunas[1] = $this->form->textfield("titulo", $dados['titulo'], 60, false, $this->traducao->get_leg24(), null, "left");
        array_push($validacao, $this->form->validar('titulo', 'value', '==', '""', $this->traducao->get_leg32(), Array("titulo"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        // Chamada
//        $colunas[0] = $this->form->texto($this->traducao->get_leg04(),true);
//        $colunas[1] = $this->form->textarea("chamada", $dados['chamada'],70,2,true, 250,true,$this->traducao->get_leg23(),"left");
//        array_push($validacao, $this->form->validar('chamada','value', '==', '""',$this->traducao->get_leg33(),Array("chamada"),$this->get_tema(),$this->get_idioma()));
//        $lin[] = $colunas;
//        
//        // Texto
//        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), FALSE);
//        $colunas[1] = $this->form->textarea_TINYMCE("texto", $dados['texto']);
//        $lin[] = $colunas;
//        
//        // Tags
//        $max_caract2 = 180;
//        $colunas[0] = $this->form->texto($this->traducao->get_leg09(), TRUE);
//        $colunas[1] = $this->form->textarea("tags", $dados['tags'], 70, 2, true, $max_caract2, true, $this->traducao->get_leg24(), "left");
//        array_push($validacao, $this->form->validar('tags', 'value', '==', '""', $this->traducao->get_leg34(), array("tags"), $this->get_tema(), $this->get_idioma()));
//        $lin[] = $colunas;
        
        // Destacar notícia
//        $colunas[0] = $this->form->texto($this->traducao->get_leg07(), FALSE); //                                                   
//        if ($dados['destaque'] == 0) {
//            $colunas[1] = $this->form->checkbox("destaque", $this->traducao->get_leg08(), 1, FALSE, "left");
//        } else {
//            $colunas[1] = $this->form->checkbox("destaque", $this->traducao->get_leg08(), 1, TRUE, "left");
//        }
//        $lin[] = $colunas;
//                
        // Submit
        $botoes = Array();
        $botoes[0] = $this->form->button("center");

        
        $tpl = new Template("../Templates/Formulario.html");
        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
    }
}

?>
