<?php

class FotoSlider {

    private $id_foto;
    private $id_slider;
    private $titulo_foto;
    private $legenda_foto;
    private $link_foto;
    private $ext_foto;
    private $ordem_foto;
    private $status_foto;

    public function get_id_foto() {
        return $this->id_foto;
    }

    public function set_id_foto($id_foto) {
        $this->id_foto = $id_foto;
    }

    public function get_id_slider() {
        return $this->id_slider;
    }

    public function set_id_slider($id_slider) {
        $this->id_slider = $id_slider;
    }

    public function get_titulo_foto() {
        return $this->titulo_foto;
    }

    public function set_titulo_foto($titulo_foto) {
        $this->titulo_foto = $titulo_foto;
    }

    public function get_legenda_foto() {
        return $this->legenda_foto;
    }

    public function set_legenda_foto($legenda_foto) {
        $this->legenda_foto = $legenda_foto;
    }

    public function get_link_foto() {
        return $this->link_foto;
    }

    public function set_link_foto($link_foto) {
        $this->link_foto = $link_foto;
    }

    public function get_ext_foto() {
        return $this->ext_foto;
    }

    public function set_ext_foto($ext_foto) {
        $this->ext_foto = $ext_foto;
    }

    public function get_ordem_foto() {
        return $this->ordem_foto;
    }

    public function set_ordem_foto($ordem_foto) {
        $this->ordem_foto = $ordem_foto;
    }

    public function get_status_foto() {
        return $this->status_foto;
    }

    public function set_status_foto($status_foto) {
        $this->status_foto = $status_foto;
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
