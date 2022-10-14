<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle de Login
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
class Login_control extends Control {

    /**
     *
     * Login no sistema
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Login() {

        $id_sessao = $this->sessao->login($this->post_request['login'], $this->post_request['senha']);
        if ($id_sessao != "ERRO") {

            $co = base64_encode("Home_Control");
            $ac = base64_encode("Home_V");

            $url = "sys.php?id_sessao=$id_sessao&ac=$ac&co=$co";
            $this->redirect($url);
        } else {
            // CONFIGURA MENSAGEM DE ERRO E RETORNA PARA A TELA DE LOGIN
            $this->traducao->loadTraducao("2000", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            $this->Login_V();
        }
    }

    /**
     *
     * Chama a View de Login
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Login_V() {

        //CARREGA A VIEW E MOSTRA
        $vw = new Login_View($this->post_request);
        $vw->showView();
    }

}

// fim da classe
?>
