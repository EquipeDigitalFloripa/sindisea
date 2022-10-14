<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Associado_DAO extends Generic_DAO {

    public $chave = 'id_associado';
    public $tabela = 'tb_associado';

    public function __construct($factory) {
        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {
        $desc = Array();
        return $desc;
    }

}

?>