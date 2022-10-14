<?php

class Movimentacao {

    private $id_movimentacao;
    private $tipo_movimentacao;
    private $id_centro;
    private $descricao;
    private $valor_mov;
    private $forma_movimentacao;
    private $data_competencia;
    private $data_cadastro;
    private $status_movimentacao;

    function get_id_movimentacao() {
        return $this->id_movimentacao;
    }

    function set_id_movimentacao($id_movimentacao) {
        $this->id_movimentacao = $id_movimentacao;
    }

    function get_tipo_movimentacao() {
        return $this->tipo_movimentacao;
    }

    function set_tipo_movimentacao($tipo_movimentacao) {
        $this->tipo_movimentacao = $tipo_movimentacao;
    }
    
    function get_id_centro() {
        return $this->id_centro;
    }

    function set_id_centro($id_centro) {
        $this->id_centro = $id_centro;
    }

    function get_descricao() {
        return $this->descricao;
    }

    function set_descricao($descricao) {
        $this->descricao = $descricao;
    }

    function get_valor_mov() {
        return $this->valor_mov;
    }

    function set_valor_mov($valor_mov) {
        $this->valor_mov = $valor_mov;
    }

    function get_forma_movimentacao() {
        return $this->forma_movimentacao;
    }

    function set_forma_movimentacao($forma_movimentacao) {
        $this->forma_movimentacao = $forma_movimentacao;
    }

    function get_data_competencia() {
        return $this->data_competencia;
    }

    function set_data_competencia($data_competencia) {
        $this->data_competencia = $data_competencia;
    }

    function get_data_cadastro() {
        return $this->data_cadastro;
    }

    function set_data_cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }

    function get_status_movimentacao() {
        return $this->status_movimentacao;
    }

    function set_status_movimentacao($status_movimentacao) {
        $this->status_movimentacao = $status_movimentacao;
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