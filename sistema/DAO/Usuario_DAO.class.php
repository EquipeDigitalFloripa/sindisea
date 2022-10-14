<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Usuario_DAO extends Generic_DAO {

    public $chave = 'id_usuario';
    public $tabela = 'tb_usuario';

    public function __construct($factory) {
        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricao() {
        $desc = Array();
        $desc['desc_perm_usuario'] = parent::get_Descricoes('tb_perm_usuario');
        $desc['desc_status_usuario'] = parent::get_Descricoes('tb_status_usuario', 0, 1, "OR status_usuario = \"I\"");
        return $desc;
    }

}

?>