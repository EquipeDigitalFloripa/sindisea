<?php

class Contato {

    private $id_contato;
    private $nome;
    private $email;
    private $telefone;
    private $conteudo;
    private $dispositivo;
    private $data_contato;
    private $status_contato;

    public function get_id_contato() {
        return $this->id_contato;
    }

    public function set_id_contato($id_contato) {
        $this->id_contato = $id_contato;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function get_telefone() {
        return $this->telefone;
    }

    public function set_telefone($telefone) {
        $this->telefone = $telefone;
    }

    public function get_conteudo() {
        return $this->conteudo;
    }

    public function set_conteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function get_dispositivo() {
        return $this->dispositivo;
    }

    public function set_dispositivo($dispositivo) {
        $this->dispositivo = $dispositivo;
    }

    public function get_data_contato() {
        return $this->data_contato;
    }

    public function set_data_contato($data_contato) {
        $this->data_contato = $data_contato;
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