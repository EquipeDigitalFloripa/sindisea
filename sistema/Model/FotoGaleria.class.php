<?php

class FotoGaleria {

    private $id_foto;
    private $id_galeria;
    private $leg;
    private $ext_img;
    private $destaque;
    private $ordem;
    private $status_foto;

    public function get_id_foto() {
        return $this->id_foto;
    }

    public function set_id_foto($id_foto) {
        $this->id_foto = $id_foto;
    }

    public function get_id_galeria() {
        return $this->id_galeria;
    }

    public function set_id_galeria($id_galeria) {
        $this->id_galeria = $id_galeria;
    }

    public function get_leg() {
        return $this->leg;
    }

    public function set_leg($leg) {
        $this->leg = $leg;
    }
    
    public function get_ext_img() {
        return $this->ext_img;
    }

    public function set_ext_img($ext_img) {
        $this->ext_img = $ext_img;
    }

    public function get_destaque() {
        return $this->destaque;
    }

    public function set_destaque($destaque) {
        $this->destaque = $destaque;
    }

    public function get_ordem() {
        return $this->ordem;
    }

    public function set_ordem($ordem) {
        $this->ordem = $ordem;
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
