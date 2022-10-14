<?php

class Colaborador {

    private $id_colaborador;
    private $id_gestao;
    private $nome;
    private $funcao;
    private $info;
    private $foto;
    private $ext_foto;
    private $ordem;
    private $status_colaborador;

    public function get_id_colaborador() {
        return $this->id_colaborador;
    }

    public function set_id_colaborador($id_colaborador) {
        $this->id_colaborador = $id_colaborador;
    }

    public function get_id_gestao() {
        return $this->id_gestao;
    }

    public function set_id_gestao($id_gestao) {
        $this->id_gestao = $id_gestao;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_funcao() {
        return $this->funcao;
    }

    public function set_funcao($funcao) {
        $this->funcao = $funcao;
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

    public function get_ordem() {
        return $this->ordem;
    }

    public function set_ordem($ordem) {
        $this->ordem = $ordem;
    }

    public function get_status_colaborador() {
        return $this->status_colaborador;
    }

    public function set_status_colaborador($status_colaborador) {
        $this->status_colaborador = $status_colaborador;
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