<?php

class Tags {

    private $id_tag;
    private $desc_tag;
    private $data_cadastro_tag;
    private $status_tag;

    public function get_id_tag() {
        return $this->id_tag;
    }

    public function set_id_tag($id_tag) {
        $this->id_tag = $id_tag;
    }

    public function get_desc_tag() {
        return $this->desc_tag;
    }

    public function set_desc_tag($desc_tag) {
        $this->desc_tag = $desc_tag;
    }

    public function get_data_cadastro_tag() {
        return $this->data_cadastro_tag;
    }

    public function set_data_cadastro_tag($data_cadastro_tag) {
        $this->data_cadastro_tag = $data_cadastro_tag;
    }

    public function get_status_tag() {
        return $this->status_tag;
    }

    public function set_status_tag($status_tag) {
        $this->status_tag = $status_tag;
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
