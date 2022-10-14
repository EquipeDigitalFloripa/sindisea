<?php

class Depoimento {

    private $id_depoimento;
    private $nome_depoimento;
    private $texto_depoimento;
    private $data_depoimento;
    private $status_depoimento;

    public function get_id_depoimento() {
        return $this->id_depoimento;
    }

    public function set_id_depoimento($id_depoimento) {
        $this->id_depoimento = $id_depoimento;
    }

    public function get_nome_depoimento() {
        return $this->nome_depoimento;
    }

    public function set_nome_depoimento($nome_depoimento) {
        $this->nome_depoimento = $nome_depoimento;
    }

    public function get_texto_depoimento() {
        return $this->texto_depoimento;
    }

    public function set_texto_depoimento($texto_depoimento) {
        $this->texto_depoimento = $texto_depoimento;
    }

    public function get_data_depoimento() {
        return $this->data_depoimento;
    }

    public function set_data_depoimento($data_depoimento) {
        $this->data_depoimento = $data_depoimento;
    }

    public function get_status_depoimento() {
        return $this->status_depoimento;
    }

    public function set_status_depoimento($status_depoimento) {
        $this->status_depoimento = $status_depoimento;
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
