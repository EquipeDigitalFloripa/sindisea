<?php

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

/**
 * View Gerencia Usu�rios Solicitantes, filho de View
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

class Usuario_Ger_Solicitante_View extends View{

/**
 * Configura e mostra a View
 *
 * @author Ricardo Ribeiro Assink
 * @param Classe $className Nome do arquivo da classe
 * @return void
 *
 */

   public function showView(){
        /*
         * ************************************************************************************************************
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         ****************INICIO
         */
        $this->traducao->loadTraducao("2047", $this->get_idioma());
        /*
         * ************************************************************************************************************
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         ****************INICIO
         */
        $co          = base64_encode("Usuario_Control"); // CONTROLLER
        $ac          = base64_encode("Usuario_Ger_Solicitante_V");
        $ac_apaga    = base64_encode("Usuario_Apaga_Solicitacao");
        $ac_analisa  = base64_encode("Usuario_Analisa_V");
        $post        = $ac;
        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         ****************INICIO
         */
        $hidden = Array();
        //$hidden['exemplo']    = $this->post_request['exemplo'];
        /*
         * ************************************************************************************************************
         * CONFIGURE OS CAMPOS HIDDEN
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         ****************INICIO
         */
        $componentes      = Array("TOOLTIP");
        /*
         * ************************************************************************************************************
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         ****************INICIO
         */
        $control_div      = "NAO"; // SIM quando � necess�rio esconder alguma div para mostrar modal
        // a linha de retorno � adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav      = "pagina=".$this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav     .= "&ac=$ac"; // ACAO
        $retorno_nav     .= "&co=$co"; // CONTROLADOR
        $retorno_nav     .= "&pesquisa=".$this->post_request['pesquisa']; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        /*
         * ************************************************************************************************************
         * CONFIGURE O NAV
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMA��ES
         ****************INICIO
         */
        $tam_infoacao      = 500; // tamanho em px do box de informa��es
        $titulo_infoacao   = $this->traducao->get_titulo_formulario01(); // t�tulo do box de informa��es
        $texto_infoacao    = $this->traducao->get_titulo_formulario02(); // texto do box de informa��es
        $mostrar_obrig     = false; // mostrar ou n�o o * de campos obrigat�rios
        $texto_obrig       = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio
        /*
         * ************************************************************************************************************
         * CONFIGURE O BOX DE INFORMA��ES
         ****************FIM
         */

           /*
             * ******************************************************************************************
             * CONFIGURE OS FILTROS. ATENCAO !!! � NECESS�RIO EFETUAR CONFIGURA��ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
             ****************INICIO
            */
            $filtros = Array();
            $filtros['pesquisa']["width"]       = "100%"; // tamanho do campo
            $filtros['pesquisa']["alinhamento"] = "center";
            $filtros['pesquisa']["texto"]       = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
            $filtros['pesquisa']["botao"]       = $this->traducao->get_titulo_formulario07();
            /*
             * ******************************************************************************************
             * CONFIGURE OS FILTROS. ATENCAO !!! � NECESS�RIO EFETUAR CONFIGURA��ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
             ****************FIM
            */
            
        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         ****************INICIO
         */
        $texto_pag          = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do n�mero de p�ginas
        $retorno_paginacao  = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=".$this->post_request['pesquisa']; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
        /*
         * ************************************************************************************************************
         * CONFIGURE A PAGINACAO
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         ****************INICIO
         */
        $tam_tab           = "850"; // tamanho da tabela que lista os itens em %
        $title_tab         = $this->traducao->get_titulo_formulario04(); // t�tulo da tabela que lista os itens
        /*
         * ************************************************************************************************************
         * CONFIGURE A LISTA DE ITENS
         ****************FIM
         */

        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         ****************INICIO
         */
            $campos = Array();
            $campos[0]["tamanho_celula"] = "15%";
            $campos[0]["texto"]          = $this->traducao->get_leg05();

            $campos[1]["tamanho_celula"] = "9%";
            $campos[1]["texto"]          = $this->traducao->get_leg01();

            $campos[2]["tamanho_celula"] = "52%";
            $campos[2]["texto"]          = $this->traducao->get_leg02();

            $campos[3]["tamanho_celula"] = "12%";
            $campos[3]["texto"]          = $this->traducao->get_leg03();

            $campos[4]["tamanho_celula"] = "12%";
            $campos[4]["texto"]          = $this->traducao->get_leg04();


        /*
         * ************************************************************************************************************
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         ****************FIM
         */

/*
* ************************************************************************************************************
* Seleciona os elementos que ser�o mostrados e configura as linhas da tabela
****************INICIO
*/
        $linhas = Array();
        $i      = 0;
        while ($i < count($this->objetos)) {

            $dados  = $this->objetos[$i]->get_all_dados();

            // aplica regra de recebimento no array de dados
            foreach ($dados as $chave => $valor){
                $dados[$chave] = htmlspecialchars(stripslashes($valor));
            }
            /*
             * ******************************************************************************************
             * CONFIGURE o tooltip de INFO
             ****************INICIO
             */
            $inf = Array();
            $inf["".$this->traducao->get_leg21().""] = $dados['nome_usuario'];
            $inf["".$this->traducao->get_leg22().""] = $this->descricoes['desc_perm_usuario'][$dados['perm_usuario']]; // pega a descri��o da permiss�o do usu�rio
            $inf["".$this->traducao->get_leg23().""] = $dados['login_usuario'];
            $inf["".$this->traducao->get_leg24().""] = $dados['email_usuario'];
            $inf["".$this->traducao->get_leg25().""] = $dados['cidade_usuario'];
            $inf["".$this->traducao->get_leg26().""] = $dados['pais_residencia_usuario'];
            $inf["".$this->traducao->get_leg27().""] = $dados['instituicao_usuario'];
            $inf["".$this->traducao->get_leg28().""] = $dados['local_instituicao_usuario'];

            $infos = $this->criaInfo($inf);
            /*
             * ******************************************************************************************
             * CONFIGURE o tooltip de INFO
             ****************FIM
             */

            /*
             * ******************************************************************************************
             * CONFIGURE OS MODAIS.
             ****************INICIO
            */
            $modais = Array();

            $modais[0]['campos']   = Array('ac'=>$ac_apaga);
            $modais[0]['acao']     = "apagar";
            $modais[0]['msg']      = $this->traducao->get_leg31();

            /*
             * ******************************************************************************************
             * CONFIGURE OS MODAIS.
             ****************FIM
            */

           /*
             * ******************************************************************************************
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             ****************INICIO
            */
             $dados['data_cadastro'] = $this->dat->get_dataFormat("BD",$dados['data_cadastro'],"PADRAO");
           /*
             * ******************************************************************************************
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             ****************FIM
            */

           /*
             * ******************************************************************************************
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR V�O ALGUNS TRATAMENTOS.
             ****************INICIO
            */
            $colunas = Array();
            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"]       = "<span class=\"texto_conteudo_tabela\">
                                         ".$dados['data_cadastro']."
                                         </span>";
            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"]       = "
                                            $infos";

            $colunas[2]["alinhamento"] = "left";
            $colunas[2]["texto"]       = "
                                            <strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$dados['nome_usuario']."</strong></font>
                                         ";

            $colunas[3]["alinhamento"] = "justify";
            $colunas[3]["texto"]       = "
                                            <span class=\"texto_conteudo_tabela\">
                                            <a href=\"javascript:submit_campo(".$dados['id_usuario'].",'$ac_analisa');\">
                                                <img src=\"temas/".$this->get_tema()."/icones/utilizadores_analisar.png\" width=\"15\" height=\"15\" align=\"left\" border=\"0\" hspace=\"2\">".$this->traducao->get_leg11()."
                                            </a>
                                            </span>";


            $colunas[4]["alinhamento"] = "left";
            $colunas[4]["texto"]       = "
                                            <span class=\"texto_conteudo_tabela\">
                                            <a href=\"javascript:certeza_0(".$dados['id_usuario'].")\">
                                                <img src=\"temas/".$this->get_tema()."/icones/del.png\" width=\"15\" height=\"15\" align=\"left\" border=\"0\" hspace=\"2\">".$this->traducao->get_leg12()."
                                            </a>
                                            </span>";
            $linhas[$i] = $colunas;
            /**
             * ******************************************************************************************
             * CONFIGURE as colunas de cada linha da tabela.
             ****************FIM
            */            
            $i++;
        }
        
/*
* ************************************************************************************************************
* Seleciona os elementos que ser�o mostrados e configura as linhas da tabela
****************FIM
*/

/*
* ************************************************************************************************************
* MONTA O HTML E MOSTRA
****************INICIO
*/

            /*
             * ******************************************************************************************
             * CONFIGURE O ARQUIVO DE TEMPLATE.
             ****************INICIO
            */
            $tpl = new Template("../Templates/Gerencia.html");
            /*
             * ******************************************************************************************
             * CONFIGURE O ARQUIVO DE TEMPLATE.
             ****************FIM
            */
            $tpl->CABECALHO   = $this->criaCabecalho();
            $tpl->META        = $this->criaMetaTags();
            $tpl->CSS         = $this->criaCss();
            $tpl->JS          = $this->criaJs();
            $tpl->JAVASCRIPT  = $this->criaJavascript();
            $tpl->VALIDACAO   = $this->criaValidacoes($validacao,$this->form->get_resetcampos(),$post,$this->form->get_ajax());
            $tpl->TITLE       = $this->criaTitulo();
            $tpl->COMPONENTES = $this->criaComponentes($componentes);
            $tpl->MODAIS      = $this->criaModalLista($modais);
            $tpl->NAV         = $this->criaNav($retorno_nav, $control_div);
            $tpl->MENU        = $this->criaMenu();
            //$tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
            $tpl->HIDDENS     = $this->criaHiddens($hidden);
            $tpl->FILTROS     = $this->criaFiltros($filtros);
            $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);

            $pagin            = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
            $tpl->PAGINACAO   = $pagin['nav_pesquisa'];
            
            $tpl->RODAPE      = $this->criaRodape();
            $tpl->MODALCOMP   = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

            $tpl->show();       
/*
* ************************************************************************************************************
* MONTA O HTML E MOSTRA
****************FIM
*/
    }// fim do showView()

    
}// Fim da classe
?>
