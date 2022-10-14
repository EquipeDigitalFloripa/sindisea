<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Mailing, filho de Control
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 04/08/2015 por Marcio Figueredo
 *
 *
 * @package Control
 *
 */
class Arquivo_Control extends Control {

    private $arquivo_dao;

    public function __construct($post_request) {
        parent::__construct($post_request);
        $this->arquivo_dao = $this->config->get_DAO("Arquivo");
    }

    /**
     * Mostra a lista de usuários, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Arquivo_Gerencia() {
        /*         * ************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $pesquisa = $this->post_request['pesquisa'];
        if ($pesquisa != "") {
            $condicao = " and status_arquivo = \"A\" and nome_arquivo LIKE '%$pesquisa%' ";
        } else {
            $condicao = " and status_arquivo = \"A\" ";
        }

        $total_reg = $this->arquivo_dao->get_Total("$condicao");


        /*
         * ****************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************FIM
         */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 15; // número de registros por página
        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************FIM
         */

        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "data_upload DESC";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->arquivo_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->arquivo_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Arquivo_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /*
     * Chama a View de Inclusão de Arquivos
     * @author Marcio Figueredo
     */

    public function Arquivo_Add_V() {
        $descricoes = $this->arquivo_dao->get_Descricao();

        $vw = new Arquivo_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /*
     * Inclui novo arquivo
     * @author Marcio Figueredo
     */

    public function Arquivo_Add() {

        $objeto = new Arquivo();

        $diretorio = "arquivos/arquivos/";
        $nome_arquivo = trim(strtolower($this->post_request['arquivo']['name']));
        $nome_arquivo = $this->string_helper->remove_caracteres($nome_arquivo);
        $ext = trim(strtolower(substr($nome_arquivo, -3)));

        $this->traducao->loadTraducao("3031", $this->post_request['idioma']);

        if ($ext <> 'doc' && $ext <> 'docx' && $ext <> 'pdf' && $ext <> 'jpg' && $ext <> 'jpeg' && $ext <> 'png' && $ext <> 'zip' && $ext <> 'rar') {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            $this->Arquivo_Add_V();
        } else {
            if (!file_exists($diretorio . "$nome_arquivo")) {

                $objeto->set_id_categoria_arquivo($this->post_request['id_categoria_arquivo']);
                $objeto->set_nome_arquivo($nome_arquivo);
                $objeto->set_desc_arquivo($this->post_request['descricao']);
                $objeto->set_data_upload($this->data->get_dataFormat("CALENDARHORA", $this->post_request['data_upload'], "BD"));
                $objeto->set_ext_arquivo($ext);
                $objeto->set_status_arquivo('A');

                if (!copy($this->post_request['arquivo']['tmp_name'], $diretorio . $nome_arquivo)) {
                    $this->post_request['msg_tp'] = "erro";
                    $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37()); //
                    $this->Arquivo_Add_V();
                } else {
                    $tamanho = filesize($diretorio . "$nome_arquivo");
                    $tamanho = round(($tamanho / 1024), 1);
                    $objeto->set_tamanho($tamanho);

                    $id_arquivo_new = $this->arquivo_dao->Save($objeto);
                    $this->post_request['msg_tp'] = "sucesso";
                    $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
                    $this->Arquivo_Add_V();
                }
            } else {
                $this->post_request['msg_tp'] = "erro";
                $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
                $this->Arquivo_Add_V();
            }
        }
    }

    /**
     *
     * Deleta E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Arquivo_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $this->traducao->loadTraducao("3032", $this->post_request['idioma']);
        $diretorio = "arquivos/arquivos/";
        $objeto = $this->arquivo_dao->loadObjeto($this->post_request['id']);
        $nome = $objeto->get_nome_arquivo();
        if (!unlink($diretorio . $nome)) {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        } else {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            $objeto->set_status_arquivo("D");
            $this->arquivo_dao->Save($objeto);
        }
        $this->Arquivo_Gerencia();
    }

    function remove_acentos($string) {
        // Remove acentos sobre a string
        $string = ereg_replace("[ÁÀÂÃÄ]", "A", $string);
        $string = ereg_replace("[áàâãäª]", "a", $string);
        $string = ereg_replace("[ÉÈÊË]", "E", $string);
        $string = ereg_replace("[éèêë]", "e", $string);
        $string = ereg_replace("[ÍÌÎÏ]", "I", $string);
        $string = ereg_replace("[íìîï]", "i", $string);
        $string = ereg_replace("[ÓÒÔÕÖ]", "O", $string);
        $string = ereg_replace("[óòôõöº]", "o", $string);
        $string = ereg_replace("[ÚÙÛÜ]", "U", $string);
        $string = ereg_replace("[úùûü]", "u", $string);
        $string = str_replace("Ç", "C", $string);
        $string = str_replace("ç", "c", $string);

        // Remove acentos
        $string = str_replace("´", "", $string);
        $string = str_replace("`", "", $string);
        $string = str_replace("~", "", $string);
        $string = str_replace("^", "", $string);
        $string = str_replace("¨", "", $string);

        $string = preg_replace("/[^\w\.-]+/", "_", $string);
        $string = trim(strtolower($string));


        return $string;
    }

    public function Arquivo_Altera() {

        $objeto = $this->arquivo_dao->loadObjeto($this->post_request['id']);
        $objeto->set_id_categoria_arquivo($this->post_request['id_categoria_arquivo']);
        $objeto->set_desc_arquivo($this->post_request['descricao']);
        $objeto->set_data_upload($this->data->get_dataFormat("CALENDARHORA", $this->post_request['data_upload'], "BD"));
        $this->arquivo_dao->Save($objeto);
        $this->traducao->loadTraducao("3033", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Arquivo_Gerencia();
    }

    /**
     *
     * Chama a View de Alteração de dados de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Arquivo_Altera_V() {

        // PEGA OBJETO

        $objeto = $this->arquivo_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->arquivo_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Arquivo_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Numero_Registros() {
        return $this->arquivo_dao->get_Total(" AND status_arquivo = \"A\"");
    }

    public function Lista_Arquivos($qtd, $inicio, $ordem, $condicao = "") {

        $objetos = $this->arquivo_dao->get_Objs(" AND status_arquivo = \"A\" $condicao", $ordem, $inicio, $qtd);
        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

}

// fim da classe
?>
