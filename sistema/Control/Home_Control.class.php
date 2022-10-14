<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da Home do sistema
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
 * @package Control
 *
 */
class Home_control extends Control {

    /**
     *
     * Chama a View da Home do Sistema
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Home_V() {

        //CARREGA A VIEW E MOSTRA
        $this->post_request['ultimo_acesso'] = $this->sessao->get_ultimo_acesso();
        
        $vw = new Home_View($this->post_request, "", "");
        $vw->showView();
    }

}

// fim da classe
?>
