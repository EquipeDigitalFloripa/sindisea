<?php

class Eleicao {

    private $id_eleicao;
    private $descricao;
    private $data_inicio;
    private $data_fim;
    private $status_eleicao;

    function get_id_eleicao() {
        return $this->id_eleicao;
    }

    function set_id_eleicao($id_eleicao) {
        $this->id_eleicao = $id_eleicao;
    }

    function get_descricao() {
        return $this->descricao;
    }

    function set_descricao($descricao) {
        $this->descricao = $descricao;
    }

    function get_data_inicio() {
        return $this->data_inicio;
    }

    function set_data_inicio($data_inicio) {
        $this->data_inicio = $data_inicio;
    }

    function get_data_fim() {
        return $this->data_fim;
    }

    function set_data_fim($data_fim) {
        $this->data_fim = $data_fim;
    }

    function get_status_eleicao() {
        return $this->status_eleicao;
    }

    function set_status_eleicao($status_eleicao) {
        $this->status_eleicao = $status_eleicao;
    }

    public function get_all_dados() {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach ($props as $prop) {
            $f = $prop->getName();
            // pra nao voltar a conexao
            if ($f != "conexao") {
                $exec = '$valor = $this->get_' . $f . '();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }

}

?>