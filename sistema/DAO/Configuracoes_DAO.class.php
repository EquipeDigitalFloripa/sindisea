<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Configuracoes_DAO extends Generic_DAO {

    public $chave = 'id_config';
    public $tabela = 'tb_configuracoes';

    public function __construct($factory) {
        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function Save($objeto) {
        $dados = array_map("addslashes", $objeto->get_all_dados());

        $campos = array_keys($dados);

        $limite = count($dados);
        for ($i = 0; $i < $limite; $i++) {
            $str_insert[] = "\"" . $dados[$campos[$i]] . "\"";
            $arr_update[] = $campos[$i] . " = \"" . $dados[$campos[$i]] . "\"";
        }

        $sql = "SELECT $this->chave FROM $this->tabela";
        $result = $this->conexao->consulta($sql);
        $row = $this->conexao->criaArray($result);
        if ($row[0][0] > 0) {
            $str_update = implode(",", $arr_update);
            $sql = "UPDATE $this->tabela SET $str_update WHERE $this->chave = " . $dados[$this->chave] . "";
            $this->conexao->consulta($sql);
            return true;
        } else {
            $insere = implode(",", $str_insert);
            $sql = "INSERT INTO $this->tabela VALUES($insere)";
            $this->conexao->consulta($sql);
            return true;
        }
    }

    public function get_Descricao() {
        $desc = Array();
        $desc['desc_perm_usuario'] = parent::get_Descricoes('tb_perm_usuario');
        $desc['desc_status_usuario'] = parent::get_Descricoes('tb_status_usuario', 0, 1, "OR status_usuario = \"I\"");
        return $desc;
    }

}

?>
