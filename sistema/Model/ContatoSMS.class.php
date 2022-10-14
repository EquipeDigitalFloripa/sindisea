<?php

class ContatoSMS {

    private $id_contato;
    private $id_grupo_sms;
    private $telefone_contato;
    private $nome_contato;
    private $data_cadastro;
    private $status_contato;

    public function get_id_contato() {
        return $this->id_contato;
    }

    public function set_id_contato($id_contato) {
        $this->id_contato = $id_contato;
    }

    public function get_id_grupo_sms() {
        return $this->id_grupo_sms;
    }

    public function set_id_grupo_sms($id_grupo_sms) {
        $this->id_grupo_sms = $id_grupo_sms;
    }

    public function get_telefone_contato() {
        return $this->telefone_contato;
    }

    public function set_telefone_contato($telefone_contato) {
        $this->telefone_contato = $telefone_contato;
    }

    public function get_nome_contato() {
        return $this->nome_contato;
    }

    public function set_nome_contato($nome_contato) {
        $this->nome_contato = $nome_contato;
    }

    public function get_data_cadastro() {
        return $this->data_cadastro;
    }

    public function set_data_cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }

    public function get_status_contato() {
        return $this->status_contato;
    }

    public function set_status_contato($status_contato) {
        $this->status_contato = $status_contato;
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