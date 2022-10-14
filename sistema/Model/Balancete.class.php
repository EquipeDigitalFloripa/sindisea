<?php

class Balancete {

    private $id_balancete;
    private $completo;
    private $movimento_caixa;
    private $resumido;
    private $data;
    private $data_cadastro;
    private $status_balancete;

    public function get_id_balancete() {
        return $this->id_balancete;
    }

    public function set_id_balancete($id_balancete) {
        $this->id_balancete = $id_balancete;
    }
    
    public function get_completo() {
        return $this->completo;
    }

    public function set_completo($completo) {
        $this->completo = $completo;
    }

    public function get_movimento_caixa() {
        return $this->movimento_caixa;
    }

    public function set_movimento_caixa($movimento_caixa) {
        $this->movimento_caixa = $movimento_caixa;
    }
    
    public function get_resumido() {
        return $this->resumido;
    }

    public function set_resumido($resumido) {
        $this->resumido = $resumido;
    }

    public function get_data() {
        return $this->data;
    }

    public function set_data($data) {
        $this->data = $data;
    }

    public function get_data_cadastro() {
        return $this->data_cadastro;
    }

    public function set_data_cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }

    public function get_status_balancete() {
        return $this->status_balancete;
    }

    public function set_status_balancete($status_balancete) {
        $this->status_balancete = $status_balancete;
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
