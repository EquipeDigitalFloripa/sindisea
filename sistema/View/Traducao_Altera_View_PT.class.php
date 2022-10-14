<?php

/**
 * View de alteração de Dados de Tradução
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
class Traducao_Altera_View_PT extends View {

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
        $this->traducao->loadTraducao("2029", $this->get_idioma());
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
        $co = base64_encode("Traducao_Control"); // CONTROLLER
        $ac = base64_encode("Traducao_Gerencia");
        $ac_01 = base64_encode("Traducao_Altera_PT");
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
        $componentes = array();

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
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $pesquisa = isset($this->post_request['pesquisa']) ? $this->post_request['pesquisa'] : "";
        $control_div = "NAO"; // SIM quando é necessário esconder alguma div para mostrar modal        
        $retorno_nav = "pagina=$pagina"; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=$pesquisa"; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO
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
        $tam_tab = "990"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // título da tabela
        $col[0]['color'] = "#EBEBEB";
        $col[0]['nowrap'] = false;
        $col[0]['valign'] = "center";
        $col[0]['width'] = "30%";
        $col[1]['color'] = "#F2FBFF";
        $col[1]['nowrap'] = false;
        $col[1]['valign'] = "center";
        $col[1]['width'] = "30%";
        $col[2]['color'] = "#FFFFFF";
        $col[2]['nowrap'] = false;
        $col[2]['valign'] = "center";
        $col[2]['width'] = "40%";
        /*
         * ************************************************************************************************************
         * CONFIGURE A TABELA
         * ***************FIM
         */

        $dadospt = $this->objetos[0]->get_all_dados();
        $dadosen = $this->objetos[1]->get_all_dados();

        // aplica regra de recebimento no array de dados
        foreach ($dadospt as $chave => $valor) {
            $dadospt[$chave] = stripslashes($valor);
        }

        // aplica regra de recebimento no array de dados
        foreach ($dadosen as $chave => $valor) {
            $dadosen[$chave] = stripslashes($valor);
        }
        /*
         * ******************************************************************************************
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         * ***************INICIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();

        $colunas[0] = $this->form->texto("ID :", false);
        $colunas[1] = "<h2  style=\"text-align:center;\"><strong>" . $dadospt['id_arquivo'] . "</strong></h2>";
        $colunas[2] = "";

        $lin[0] = $colunas;

        $colunas[0] = $this->form->texto("Nome do Arquivo :", false);
        $colunas[1] = "<h2 style=\"text-align:center;\"><strong>" . $dadospt['nome_arquivo'] . "</strong></h2>";
        $colunas[2] = "";
        $lin[1] = $colunas;

        $colunas[0] = $this->form->texto("Lingua :", false);
        $colunas[1] = "<h2 style=\"text-align:center;\"><strong>INGLÊS</strong></h2>";
        $colunas[2] = '<h2 style="text-align:center;"><strong>PORTUGUÊS</strong></h2>';
        $lin[2] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario01: (titulo_infoacao)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario01'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario01", $dadospt['titulo_formulario01'], 70, 1);
        $lin[3] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario02: (texto_infoacao)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario02'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario02", $dadospt['titulo_formulario02'], 70, 1);
        $lin[4] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario03: (texto_obrig) ', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario03'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario03", $dadospt['titulo_formulario03'], 70, 1);
        $lin[5] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario04: (title_tab) ', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario04'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario04", $dadospt['titulo_formulario04'], 70, 1);
        $lin[6] = $colunas;


        $colunas[0] = $this->form->texto('titulo_formulario05: (texto_pag)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario05'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario05", $dadospt['titulo_formulario05'], 70, 1);
        $lin[7] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario06: (["pesquisa"]["texto"])', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario06'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario06", $dadospt['titulo_formulario06'], 70, 1);
        $lin[8] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario07: (["pesquisa"]["botao"])', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario07'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario07", $dadospt['titulo_formulario07'], 70, 1);
        $lin[9] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario08:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario08'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario08", $dadospt['titulo_formulario08'], 70, 1);
        $lin[10] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario09:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario09'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario09", $dadospt['titulo_formulario09'], 70, 1);
        $lin[11] = $colunas;

        $colunas[0] = $this->form->texto('titulo_formulario10:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['titulo_formulario10'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("titulo_formulario10", $dadospt['titulo_formulario10'], 70, 1);
        $lin[12] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg01: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg01'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg01", $dadospt['leg01'], 70, 1);
        $lin[13] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg02: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg02'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg02", $dadospt['leg02'], 70, 1);
        $lin[14] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg03: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg03'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg03", $dadospt['leg03'], 70, 1);
        $lin[15] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg04: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg04'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg04", $dadospt['leg04'], 70, 1);
        $lin[16] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg05: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg05'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg05", $dadospt['leg05'], 70, 1);
        $lin[17] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg06: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg06'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg06", $dadospt['leg06'], 70, 1);
        $lin[18] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg07: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg07'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg07", $dadospt['leg07'], 70, 1);
        $lin[19] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg08: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg08'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg08", $dadospt['leg08'], 70, 1);
        $lin[20] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg09: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg09'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg09", $dadospt['leg09'], 70, 1);
        $lin[21] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg10: (colunas_tabela)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg10'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg10", $dadospt['leg10'], 70, 1);
        $lin[22] = $colunas;

        $colunas[0] = $this->form->texto('leg11: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg11'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg11", $dadospt['leg11'], 70, 1);
        $lin[23] = $colunas;

        $colunas[0] = $this->form->texto('leg12: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg12'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg12", $dadospt['leg12'], 70, 1);
        $lin[24] = $colunas;

        $colunas[0] = $this->form->texto('leg13: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg13'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg13", $dadospt['leg13'], 70, 1);
        $lin[25] = $colunas;

        $colunas[0] = $this->form->texto('leg14: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg14'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg14", $dadospt['leg14'], 70, 1);
        $lin[26] = $colunas;

        $colunas[0] = $this->form->texto('leg15: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg15'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg15", $dadospt['leg15'], 70, 1);
        $lin[27] = $colunas;

        $colunas[0] = $this->form->texto('leg16: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg16'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg16", $dadospt['leg16'], 70, 1);
        $lin[28] = $colunas;

        $colunas[0] = $this->form->texto('leg17: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg17'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg17", $dadospt['leg17'], 70, 1);
        $lin[29] = $colunas;

        $colunas[0] = $this->form->texto('leg18: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg18'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg18", $dadospt['leg18'], 70, 1);
        $lin[30] = $colunas;

        $colunas[0] = $this->form->texto('leg19: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg19'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg19", $dadospt['leg19'], 70, 1);
        $lin[31] = $colunas;

        $colunas[0] = $this->form->texto('leg20: (linhas_tabela)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg20'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg20", $dadospt['leg20'], 70, 1);
        $lin[32] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg21: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg21'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg21", $dadospt['leg21'], 70, 1);
        $lin[33] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg22: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg22'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg22", $dadospt['leg22'], 70, 1);
        $lin[34] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg23: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg23'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg23", $dadospt['leg23'], 70, 1);
        $lin[35] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg24: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg24'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg24", $dadospt['leg24'], 70, 1);
        $lin[36] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg25: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg25'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg25", $dadospt['leg25'], 70, 1);
        $lin[37] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg26: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg26'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg26", $dadospt['leg26'], 70, 1);
        $lin[38] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg27: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg27'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg27", $dadospt['leg27'], 70, 1);
        $lin[39] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg28: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg28'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg28", $dadospt['leg28'], 70, 1);
        $lin[40] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg29: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg29'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg29", $dadospt['leg29'], 70, 1);
        $lin[41] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg30: (info)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg30'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg30", $dadospt['leg30'], 70, 1);
        $lin[42] = $colunas;

        $colunas[0] = $this->form->texto('leg31: (modais)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg31'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg31", $dadospt['leg31'], 70, 1);
        $lin[43] = $colunas;

        $colunas[0] = $this->form->texto('leg32: (modais)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg32'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg32", $dadospt['leg32'], 70, 1);
        $lin[44] = $colunas;

        $colunas[0] = $this->form->texto('leg33: (modais)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg33'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg33", $dadospt['leg33'], 70, 1);
        $lin[45] = $colunas;

        $colunas[0] = $this->form->texto('leg34: (modais)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg34'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg34", $dadospt['leg34'], 70, 1);
        $lin[46] = $colunas;

        $colunas[0] = $this->form->texto('leg35: (modais)', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg35'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg35", $dadospt['leg35'], 70, 1);
        $lin[47] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg36: (msg_modal)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg36'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg36", $dadospt['leg36'], 70, 1);
        $lin[48] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg37: (msg_modal)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg37'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg37", $dadospt['leg37'], 70, 1);
        $lin[49] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg38: (msg_modal)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg38'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg38", $dadospt['leg38'], 70, 1);
        $lin[50] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg39: (msg_modal)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg39'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg39", $dadospt['leg39'], 70, 1);
        $lin[51] = $colunas;

        $colunas[0] = $this->form->texto('<b>leg40: (msg_modal)</b>', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg40'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg40", $dadospt['leg40'], 70, 1);
        $lin[52] = $colunas;

        $colunas[0] = $this->form->texto('leg41:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg41'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg41", $dadospt['leg41'], 70, 1);
        $lin[53] = $colunas;

        $colunas[0] = $this->form->texto('leg42:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg42'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg42", $dadospt['leg42'], 70, 1);
        $lin[54] = $colunas;

        $colunas[0] = $this->form->texto('leg43:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg43'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg43", $dadospt['leg43'], 70, 1);
        $lin[55] = $colunas;

        $colunas[0] = $this->form->texto('leg44:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg44'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg44", $dadospt['leg44'], 70, 1);
        $lin[56] = $colunas;

        $colunas[0] = $this->form->texto('leg45:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg45'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg45", $dadospt['leg45'], 70, 1);
        $lin[57] = $colunas;

        $colunas[0] = $this->form->texto('leg46:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg46'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg46", $dadospt['leg46'], 70, 1);
        $lin[58] = $colunas;

        $colunas[0] = $this->form->texto('leg47:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg47'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg47", $dadospt['leg47'], 70, 1);
        $lin[59] = $colunas;

        $colunas[0] = $this->form->texto('leg48:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg48'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg48", $dadospt['leg48'], 70, 1);
        $lin[60] = $colunas;

        $colunas[0] = $this->form->texto('leg49:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg49'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg49", $dadospt['leg49'], 70, 1);
        $lin[61] = $colunas;

        $colunas[0] = $this->form->texto('leg50:', false);
        $colunas[1] = "<h2 style=\"text-align:center;\">" . $dadosen['leg50'] . "</h2>";
        $colunas[2] = $this->form->textarea_resize("leg50", $dadospt['leg50'], 70, 1);
        $lin[62] = $colunas;

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
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "") . '<script type="text/JavaScript">resizeTextArea();</script>';


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
