<?php

class Galeria {

    private $id_galeria;
    private $id_categoria_galeria;
    private $titulo;
    private $chamada;
    private $texto;
    private $tags;
    private $data_galeria;
    private $data_cadastro_galeria;
    private $destaque;
    private $status_galeria;

    public function get_id_galeria() {
        return $this->id_galeria;
    }

    public function set_id_galeria($id_galeria) {
        $this->id_galeria = $id_galeria;
    }

    public function get_id_categoria_galeria() {
        return $this->id_categoria_galeria;
    }

    public function set_id_categoria_galeria($id_categoria_galeria) {
        $this->id_categoria_galeria = $id_categoria_galeria;
    }

    public function get_titulo() {
        return $this->titulo;
    }

    public function set_titulo($titulo) {
        $this->titulo = $titulo;
    }

    public function get_chamada() {
        return $this->chamada;
    }

    public function set_chamada($chamada) {
        $this->chamada = $chamada;
    }

    public function get_texto() {
        return $this->texto;
    }

    public function set_texto($texto) {
        $this->texto = $texto;
    }

    public function get_tags() {
        return $this->tags;
    }

    public function set_tags($tags) {
        $this->tags = $tags;
    }
        
    public function get_data_galeria() {
        return $this->data_galeria;
    }

    public function set_data_galeria($data_galeria) {
        $this->data_galeria = $data_galeria;
    }
    
    public function get_data_cadastro_galeria() {
        return $this->data_cadastro_galeria;
    }

    public function set_data_cadastro_galeria($data_cadastro_galeria) {
        $this->data_cadastro_galeria = $data_cadastro_galeria;
    }

    
    public function get_destaque() {
        return $this->destaque;
    }

    public function set_destaque($destaque) {
        $this->destaque = $destaque;
    }

    public function get_status_galeria() {
        return $this->status_galeria;
    }

    public function set_status_galeria($status_galeria) {
        $this->status_galeria = $status_galeria;
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
