<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Colaborador_DAO extends Generic_DAO {

    public $chave = 'id_colaborador';
    public $tabela = 'tb_colaborador';

    public function __construct($factory) {
        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_max_id() {
        $sql = "SELECT MAX($this->chave) FROM $this->tabela";

        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);

        return $row[0][0];
    }

    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {
        $desc = Array();
        $desc['gestao'] = parent::get_Descricoes('tb_gestao');
        return $desc;
    }

}

?>