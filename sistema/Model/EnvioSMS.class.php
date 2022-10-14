<?php

class EnvioSMS {

    private $id_envio;
    private $id_grupo_sms;
    private $texto_envio;
    private $data_envio;

    public function get_id_envio() {
        return $this->id_envio;
    }

    public function set_id_envio($id_envio) {
        $this->id_envio = $id_envio;
    }

    public function get_id_grupo_sms() {
        return $this->id_grupo_sms;
    }

    public function set_id_grupo_sms($id_grupo_sms) {
        $this->id_grupo_sms = $id_grupo_sms;
    }

    public function get_texto_envio() {
        return $this->texto_envio;
    }

    public function set_texto_envio($texto_envio) {
        $this->texto_envio = $texto_envio;
    }

    public function get_data_envio() {
        return $this->data_envio;
    }

    public function set_data_envio($data_envio) {
        $this->data_envio = $data_envio;
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