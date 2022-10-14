<?php

class Convenio {

    private $id_convenio;
    private $nome;
    private $info;
    private $foto;
    private $ext_foto;
    private $status_convenio;

    public function get_id_convenio() {
        return $this->id_convenio;
    }

    public function set_id_convenio($id_convenio) {
        $this->id_convenio = $id_convenio;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_info() {
        return $this->info;
    }

    public function set_info($info) {
        $this->info = $info;
    }

    public function get_foto() {
        return $this->foto;
    }

    public function set_foto($foto) {
        $this->foto = $foto;
    }

    public function get_ext_foto() {
        return $this->ext_foto;
    }

    public function set_ext_foto($ext_foto) {
        $this->ext_foto = $ext_foto;
    }

    public function get_status_convenio() {
        return $this->status_convenio;
    }

    public function set_status_convenio($status_convenio) {
        $this->status_convenio = $status_convenio;
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