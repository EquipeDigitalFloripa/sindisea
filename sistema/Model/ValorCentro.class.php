<?php

class ValorCentro {

    private $id_valor_centro;
    private $id_centro;
    private $mes;
    private $valor;
    private $status_valor_centro;

    function get_id_valor_centro() {
        return $this->id_valor_centro;
    }

    function set_id_valor_centro($id_valor_centro) {
        $this->id_valor_centro = $id_valor_centro;
    }

    function get_id_centro() {
        return $this->id_centro;
    }

    function set_id_centro($id_centro) {
        $this->id_centro = $id_centro;
    }

    function get_mes() {
        return $this->mes;
    }

    function set_mes($mes) {
        $this->mes = $mes;
    }

    function get_valor() {
        return $this->valor;
    }

    function set_valor($valor) {
        $this->valor = $valor;
    }

    function get_status_valor_centro() {
        return $this->status_valor_centro;
    }

    function set_status_valor_centro($status_valor_centro) {
        $this->status_valor_centro = $status_valor_centro;
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