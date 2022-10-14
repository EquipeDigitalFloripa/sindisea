<?php

class Slider {

    private $id_slider;
    private $desc_slider;
    private $data_slider;
    private $status_slider;

    public function get_id_slider() {
        return $this->id_slider;
    }

    public function set_id_slider($id_slider) {
        $this->id_slider = $id_slider;
    }

    public function get_desc_slider() {
        return $this->desc_slider;
    }

    public function set_desc_slider($desc_slider) {
        $this->desc_slider = $desc_slider;
    }

    public function get_data_slider() {
        return $this->data_slider;
    }

    public function set_data_slider($data_slider) {
        $this->data_slider = $data_slider;
    }

    public function get_status_slider() {
        return $this->status_slider;
    }

    public function set_status_slider($status_slider) {
        $this->status_slider = $status_slider;
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
