<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 *
 * @author Marcio Figueredo
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 25/03/2015
 *
 */
class Video_DAO extends Generic_DAO {

    public $chave = 'id_video';
    public $tabela = 'tb_video';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {
        
    }

}

?>
