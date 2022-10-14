<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Centro_DAO extends Generic_DAO {

    public $chave = 'id_centro';
    public $tabela = 'tb_centro';

    public function __construct($factory) {
        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {

        $desc = Array();
        return $desc;
    }

}

?>