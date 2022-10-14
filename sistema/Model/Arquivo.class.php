<?php

class Arquivo {

    private $id_arquivo;
    private $id_categoria_arquivo;
    private $nome_arquivo;
    private $desc_arquivo;
    private $data_upload;
    private $ext_arquivo;
    private $tamanho;
    private $status_arquivo;

    public function get_id_arquivo() {
        return $this->id_arquivo;
    }

    public function set_id_arquivo($id_arquivo) {
        $this->id_arquivo = $id_arquivo;
    }
    
    public function get_id_categoria_arquivo() {
        return $this->id_categoria_arquivo;
    }

    public function set_id_categoria_arquivo($id_categoria_arquivo) {
        $this->id_categoria_arquivo = $id_categoria_arquivo;
    }

    public function get_nome_arquivo() {
        return $this->nome_arquivo;
    }

    public function set_nome_arquivo($nome_arquivo) {
        $this->nome_arquivo = $nome_arquivo;
    }

    public function get_desc_arquivo() {
        return $this->desc_arquivo;
    }

    public function set_desc_arquivo($desc_arquivo) {
        $this->desc_arquivo = $desc_arquivo;
    }

    public function get_data_upload() {
        return $this->data_upload;
    }

    public function set_data_upload($data_upload) {
        $this->data_upload = $data_upload;
    }

    function get_ext_arquivo() {
        return $this->ext_arquivo;
    }

    function set_ext_arquivo($ext_arquivo) {
        $this->ext_arquivo = $ext_arquivo;
    }

    function get_tamanho() {
        return $this->tamanho;
    }

    function set_tamanho($tamanho) {
        $this->tamanho = $tamanho;
    }

    public function get_status_arquivo() {
        return $this->status_arquivo;
    }

    public function set_status_arquivo($status_arquivo) {
        $this->status_arquivo = $status_arquivo;
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