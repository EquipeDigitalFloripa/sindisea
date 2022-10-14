<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade arquivo, filho de Control
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Marcela Santana
 *
 *
 * @package Control
 *
 */
class Eleicao_Control extends Control {

    private $eleicao_dao;

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
     *       $this->arquivo_dao = $config->get_DAO("arquivo");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->eleicao_dao = $this->config->get_DAO("Eleicao");
    }

    /**
     * Mostra a lista de usuários, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Eleicao_Add_V() {
        $vw = new Eleicao_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Eleicao_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Eleicao();

        $this->traducao->loadTraducao("3035", $this->post_request['idioma']);
        $objeto->set_descricao($this->post_request['descricao']);
        $objeto->set_data_inicio($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_inicio'], "BD"));
        $objeto->set_data_fim($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_fim'], "BD"));
        $objeto->set_status_eleicao('A');
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->eleicao_dao->Save($objeto);
        $this->Eleicao_Add_V();
    }

    public function Eleicao_Resultado() {
        $ctr_chapas = new ChapaEleicao_Control($this->post_request);
        $ctr_votos = new VotoEleicao_Control($this->post_request);
        
        $condicao .= " and (status_eleicao = \"A\" or status_eleicao = \"I\")";
        $total_reg = $this->eleicao_dao->get_Total("$condicao");

        $ordem = "id_eleicao DESC";

        $objetos = $this->eleicao_dao->get_Objs($condicao, $ordem, 0, 10);
        
        $i = 0;
        $chapas = Array();
        while ($i < count($objetos)) {
            $dados = $objetos[$i]->get_all_dados();
            $chapa = $ctr_chapas->Lista_Chapas(""); 
            array_push($chapa, [ "id_chapa_eleicao" => -1, "nome" => "Branco" ]);            
            array_push($chapa, [ "id_chapa_eleicao" => 0, "nome" => "Nulo" ]);
            
            
            for($x = 0; $x < sizeof($chapa); $x++) {
                $chapas[$dados['id_eleicao']][$chapa[$x]['nome']] = $ctr_votos->Conta_Votos($dados['id_eleicao'], $chapa[$x]['id_chapa_eleicao']);
            }
            $i++;
        }
        
        $descricoes = $chapas;
        //CARREGA A VIEW E MOSTRA
        $vw = new Eleicao_Resultado_View($this->post_request, $objetos, $descricoes, $total_reg, 10);
        $vw->showView();
    }

    public function Eleicao_Gerencia() {
        /*         * ************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $condicao .= " and (status_eleicao = \"A\" or status_eleicao = \"I\")";
        $total_reg = $this->eleicao_dao->get_Total("$condicao");
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
        $pag_views = 20; // número de registros por página
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
        $ordem = "data_fim DESC";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->eleicao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->eleicao_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Eleicao_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

// fim do Usuario_Gerencia

    public function Eleicao_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_eleicao("D");
        $this->eleicao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Eleicao_Gerencia();
    }

    /**
     *
     * Desativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Eleicao_Desativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_eleicao("I");
        $this->eleicao_dao->Save($objeto);
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Eleicao_Gerencia();
    }

    /**
     *
     * Ativa E-mails
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Eleicao_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_eleicao("A");
        $this->eleicao_dao->Save($objeto);
        $this->traducao->loadTraducao("3036", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Eleicao_Gerencia();
    }

    /**
     *
     * Altera dados de e-mail
     *
     * @author Marcela Santana
     * @return void
     *
     */
    public function Eleicao_Altera() {

        $objeto = $this->eleicao_dao->loadObjeto($this->post_request['id']);
        $objeto->set_descricao($this->post_request['descricao']);
        $objeto->set_data_inicio($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_inicio'], "BD"));
        $objeto->set_data_fim($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_fim'], "BD"));
        $this->eleicao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3037", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Eleicao_Gerencia();
    }

    public function Eleicao_Altera_V() {

        $objeto = $this->eleicao_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->eleicao_dao->get_Descricao();
        $vw = new Eleicao_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Lista_Eleicoes($qtde = 999, $inicio = 0, $ordem = 'descricao ASC') {

        $objetos = $this->eleicao_dao->get_Objs(" AND status_eleicao = 'A'", $ordem, $inicio, $qtde);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }

    public function Pega_Eleicao($id_eleicao) {
        $condicao = "AND id_eleicao = $id_eleicao";

        $objetos = $this->eleicao_dao->get_Objs(" AND status_eleicao = 'A' $condicao", 'id_eleicao DESC', 0, 1);
        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados[0];
    }

}

// fim da classe
?>
