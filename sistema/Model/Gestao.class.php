<?php

class Gestao{

    private $id_gestao;
    private $desc_gestao;
    private $destaque_gestao;
    private $data_cadastro_gestao;
    private $status_gestao;

    public function get_id_gestao() {
        return $this->id_gestao;
    }

    public function set_id_gestao($id_gestao) {
        $this->id_gestao = $id_gestao;
    }

    public function get_desc_gestao() {
        return $this->desc_gestao;
    }

    public function set_desc_gestao($desc_gestao) {
        $this->desc_gestao = $desc_gestao;
    }

    public function get_destaque_gestao() {
        return $this->destaque_gestao;
    }

    public function set_destaque_gestao($destaque_gestao) {
        $this->destaque_gestao = $destaque_gestao;
    }

    public function get_data_cadastro_gestao() {
        return $this->data_cadastro_gestao;
    }

    public function set_data_cadastro_gestao($data_cadastro_gestao) {
        $this->data_cadastro_gestao = $data_cadastro_gestao;
    }

    public function get_status_gestao() {
        return $this->status_gestao;
    }

    public function set_status_gestao($status_gestao) {
        $this->status_gestao = $status_gestao;
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
