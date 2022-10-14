<?php

//if (isset($_SERVER['PWD'])) {
//    include_once '../Control/Configuracoes_Control.class.php';
//    include_once '/sistema/Control/Configuracoes_Control.class.php';
//    $ctr_config = new Configuracoes_Control($post_request);
//    $endereco = $ctr_config->Pega_Dir_Adress();
//    require_once($endereco . "/sistema/AutoLoaderCmd.php");
//} else {
//    require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
//}

/**
 * Classe de controle da entidade Movimentacao
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Marcela Santana
 *
 * @package Control
 *
 */
class Movimentacao_Control extends Control {

    /**
     * DAO da Entidade CategoriaGaleria
     * @var Movimentacao_Dao 
     */
    private $movimentacao_dao;

    /**
     * Carrega o contrutor do pai.
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $post_request Parâmetros de _POST e _REQUEST
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       parent::__construct();
     *       $config = new Config();
     *       $this->mailing_dao = $config->get_DAO("Mailing");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->movimentacao_dao = $this->config->get_DAO("Movimentacao");
    }

    /**
     * Chama a view com a lista de Categorias a serem gerenciadas
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Movimentacao_Gerencia() {

        /*         * ********************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        // pega o filtro
        $mostrar = 0;
        $pesquisa = $this->post_request['pesquisa'];

        if (!isset($this->post_request['selecao03'])) {
            $mes = date('m');
            $ano = date('Y');
        } else {
            $ano = $this->post_request['selecao03'];
            $mes = $this->post_request['selecao04'];
        }
        $data_inicio = $ano . "-" . $mes . "-01 00:00:00";
        $data_fim = $ano . "-" . $mes . "-31 23:59:59";
        $condicao .= " AND data_competencia >= '" . $data_inicio . "' AND data_competencia <= '" . $data_fim . "'";

        $condicao .= isset($this->post_request['pesquisa']) ? ' AND (descricao LIKE "%' . $this->post_request['pesquisa'] . '%")' : '';
        if ($this->post_request['selecao01'] != 0) {
            $condicao .= ' AND (tipo_movimentacao =' . $this->post_request['selecao01'] . ')';
        }

        if ($this->post_request['selecao02'] != 0) {
            $condicao .= ' AND (id_centro =' . $this->post_request['selecao02'] . ')';
        }
        $condicao .= " and (status_movimentacao = \"A\" or status_movimentacao = \"I\")";

        //echo $condicao;

        $total_reg = $this->movimentacao_dao->get_Total("$condicao");


        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
         * *********************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 20; // número de registros por página
        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * *********************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "data_competencia DESC";


        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->movimentacao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->movimentacao_dao->get_Descricoes();


        //CARREGA A VIEW E MOSTRA
        $vw = new Movimentacao_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a view com a lista de Categorias a serem gerenciadas
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Movimentacao_Gerencia_Data() {

        /*         * ********************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        // pega o filtro
        $mostrar = 0;
        $pesquisa = $this->post_request['pesquisa'];

        $condicao .= " and (status_movimentacao = \"A\" or status_movimentacao = \"I\")";

        $total_reg = $this->movimentacao_dao->get_Total("$condicao");


        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
         * *********************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 20; // número de registros por página
        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * *********************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "data_competencia DESC";


        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->movimentacao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->movimentacao_dao->get_Descricoes();


        //CARREGA A VIEW E MOSTRA
        $vw = new Movimentacao_Gerencia_Data_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a view de inclusão de categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Movimentacao_Add_V() {

        $descricoes = $this->movimentacao_dao->get_Descricoes();

        $vw = new Movimentacao_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa de inclusão da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Movimentacao_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Movimentacao();

        $this->traducao->loadTraducao("5071", $this->post_request['idioma']);

        $objeto->set_tipo_movimentacao($this->post_request['tipo_movimentacao']);
        $objeto->set_descricao($this->post_request['descricao']);
        $valor = str_replace('.', '', $this->post_request['valor_mov']);
        $valor = str_replace(',', '.', $valor);
        $objeto->set_valor_mov($valor);
        $objeto->set_forma_movimentacao($this->post_request['forma_movimentacao']);
        $objeto->set_id_centro($this->post_request['id_centro']);
        $objeto->set_data_competencia($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data'], "BD"));
        $objeto->set_data_cadastro($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_movimentacao('A');

        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $id = $this->movimentacao_dao->Save($objeto);
        $this->Movimentacao_Gerencia();
    }

    /**
     * Chama a view de alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Movimentacao_Altera_V() {

        $objeto = $this->movimentacao_dao->loadObjeto($this->post_request['id']);

        $descricoes = $this->movimentacao_dao->get_Descricoes();

        $vw = new Movimentacao_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a alteração dos dados da categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Movimentacao_Altera() {

        $this->traducao->loadTraducao("5073", $this->post_request['idioma']);
        $objeto = $this->movimentacao_dao->loadObjeto($this->post_request['id']);

        $objeto->set_tipo_movimentacao($this->post_request['tipo_movimentacao']);
        $objeto->set_descricao($this->post_request['descricao']);
        $valor = str_replace('.', '', $this->post_request['valor_mov']);
        $valor = str_replace(',', '.', $valor);
        $objeto->set_valor_mov($valor);
        $objeto->set_forma_movimentacao($this->post_request['forma_movimentacao']);
        $objeto->set_id_centro($this->post_request['id_centro']);
        $objeto->set_data_competencia($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data'], "BD"));

        $update = $this->movimentacao_dao->Save($objeto);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        if ($update) {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        }
        $this->Movimentacao_Gerencia();
    }

    /**
     * Executa a exclusão de uma categoria
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Movimentacao_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->movimentacao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_movimentacao("D");

        $apaga = $this->movimentacao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5072", $this->post_request['idioma']);

        if ($apaga) {
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        } else {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        }
        $this->Movimentacao_Gerencia();
    }

    /**
     * Aesativada uma categoria que estava ativada
     *
     * @return void
     */
    public function Movimentacao_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->movimentacao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_movimentacao("I");

        $this->movimentacao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5072", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Movimentacao_Gerencia();
    }

    /**
     * Ativa uma categoria que estava desativada
     *
     * @return void
     */
    public function Movimentacao_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->movimentacao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_movimentacao("A");

        $this->movimentacao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5072", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Movimentacao_Gerencia();
    }

    public function Lista_Movimentacaos($qtde, $inicio, $ordem, $condicao = "") {

        $objetos = $this->movimentacao_dao->get_Objs(" $condicao AND status_movimentacao = 'A'", $ordem, $inicio, $qtde);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }

    public function Pega_Movimentacao($id_movimentacao) {

        $condicao = "AND id_movimentacao = $id_movimentacao";

        $objetos = $this->movimentacao_dao->get_Objs(" AND status_movimentacao = 'A' $condicao", 'data_competencia DESC', 0, 1);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados[0];
    }

    public function get_Total() {
        $total = $this->movimentacao_dao->get_Total(" AND status_movimentacao = 'A'");
        return $total;
    }

    public function Movimentacao_Imprimir() {

        date_default_timezone_set("America/Sao_Paulo");
        require_once("../Libs/tcpdf/tcpdf.php");
        require_once("../Libs/tcpdf/mypdf.php");

        unlink('../sys/arquivos/pdf/file_balancete.pdf');

        $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                <html>
                    <head><meta http-equiv=Content-Type content=text/html charset=ISO-8859-1/></head>
                    <style>
                        .valores tr{padding: 20px;}
                        .valores td{border-bottom: 1px solid black}
                    </style>
                    <body>       
                    ' . utf8_decode($this->post_request['html']) . '
                    <br><br><br><br><br><br><br><br>
                    <table width="50%" cellspacing="0" style="padding-top: 10px; font-size: 9px; border-top: 1px solid black; text-align: center; margin-top: 40px;">
                        <tr>
                            <td style="">MARCELO EDUARDO SCHUBERT<br>Diretor Financeiro</td>
                        </tr>
                    </table>
                    </body>
                </html>';

        $pdf->SetHeaderData("logo.png", 50, utf8_encode(PDF_HEADER_TITLE), utf8_encode(PDF_HEADER_STRING), array(0, 0, 0), array(255, 255, 255));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 8));
        $pdf->SetHeaderMargin(5);

        $pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 7));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(1);
        $pdf->SetFont('dejavusans', '', 7, '', true);
        $pdf->AddPage();
        $pdf->writeHTML(utf8_encode($html), true, false, true, false, '');

        $pdf->Output('../sys/arquivos/pdf/file_balancete.pdf', 'F'); //F salva, D download, I abre no navegador  
        chmod('../sys/arquivos/pdf/file_balancete.pdf', 0777);
    }

}
