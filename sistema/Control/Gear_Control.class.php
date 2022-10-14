<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Gear, filho de Control
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2019-2022, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 20/08/2019
 * @package Control
 */
class Gear_Control extends Control {

    private $gear_dao;
    private $tag_gear_dao;
    private $foto_gear_dao;

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
     *       $this->gear_dao = $config->get_DAO("Post");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->gear_dao = $this->config->get_DAO("Gear");

    }



    /**
     * Chama View para inclusão de uma novo Gear
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function Gear_Add_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->gear_dao->get_Descricoes();
        

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Gear_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

}

?>
