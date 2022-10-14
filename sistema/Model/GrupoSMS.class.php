<?php

class GrupoSMS {

    private $id_grupo_sms;
    private $descricao_grupo_sms;
    private $data_cadastro;
    private $status_grupo_sms;

    public function get_id_grupo_sms() {
        return $this->id_grupo_sms;
    }

    public function set_id_grupo_sms($id_grupo_sms) {
        $this->id_grupo_sms = $id_grupo_sms;
    }

    public function get_descricao_grupo_sms() {
        return $this->descricao_grupo_sms;
    }

    public function set_descricao_grupo_sms($descricao_grupo_sms) {
        $this->descricao_grupo_sms = $descricao_grupo_sms;
    }

    public function get_data_cadastro() {
        return $this->data_cadastro;
    }

    public function set_data_cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }

    public function get_status_grupo_sms() {
        return $this->status_grupo_sms;
    }

    public function set_status_grupo_sms($status_grupo_sms) {
        $this->status_grupo_sms = $status_grupo_sms;
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