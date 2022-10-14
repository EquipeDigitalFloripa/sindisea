<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Contato, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2017-2020, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 04/07/2017
 * @package Control
 */
class Contato_Control extends Control {

    private $contato_dao;

    public function __construct($post_request) {
        parent::__construct($post_request);
        $this->contato_dao = $this->config->get_DAO("Contato");
    }

    /**
     * Mostra a lista de Contatos, utilizado para gerar a tela Gerenciar e-mails
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Contato_Gerencia() {

        $condicao = '';
        if (isset($this->post_request['ano'])) {

            $condicao .= "AND DATE_FORMAT(data_contato, '%Y') = '" . $this->post_request['ano'] . "'";
            
            if (isset($this->post_request['mes']) && $this->post_request['mes'] > 0) {
                $condicao .= " AND DATE_FORMAT(data_contato, '%m') = '" . $this->post_request['mes'] . "'";
            }
            if ((isset($this->post_request['data_inicio']) && $this->post_request['data_inicio'] != "") && (isset($this->post_request['data_fim']) && $this->post_request['data_fim'] != "")) {
                $condicao .= " AND DATE_FORMAT(data_contato, '%Y-%m-%d') BETWEEN date('" . $this->post_request['data_inicio'] . "') AND date('" . $this->post_request['data_fim'] . "')";
            }
        }

        $total_reg = $this->contato_dao->get_Total("$condicao");        


        /* INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA */
        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }


        /* NÚMERO DE REGISTROS POR PÁGINAS */
        $pag_views = 500;


        /* CALCULA OS PARAMETROS DE PAGINACAO */
        $mat = $this->post_request['pagina'] - 1;
        $inicio = $mat * $pag_views;


        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "data_contato DESC";


        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->contato_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->contato_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Contato_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Inclui novo Contato
     * @author Marcio Figueredo
     * @return void
     */
    public function Contato_Add($dispositivo = NULL) {

        $objeto = new Contato();


        $objeto->set_nome(utf8_decode($this->post_request['nome']));
        $objeto->set_email($this->post_request['email']);
        $objeto->set_telefone(preg_replace("/[^0-9]/", "", $this->post_request['telefone']));
        $objeto->set_conteudo(utf8_decode($this->post_request['mensagem']));
        $objeto->set_dispositivo($dispositivo);
        $objeto->set_data_contato($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_contato('A');

        $this->contato_dao->Save($objeto);
    }

    public function Carrega_Dados($sql) {
        return $this->contato_dao->get_Dados($sql);
    }

    public function Lista_Array_Filtro() {
        return $this->contato_dao->get_Array_Filtro();
    }

}

?>
