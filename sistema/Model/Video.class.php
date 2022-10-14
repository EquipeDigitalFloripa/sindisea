<?php

class Video {

    private $id_video;
    private $titulo_video;
    private $texto_video;
    private $iframe_video;
    private $data_video;
    private $status_video;

    public function get_id_video() {
        return $this->id_video;
    }

    public function set_id_video($id_video) {
        $this->id_video = $id_video;
    }

    public function get_titulo_video() {
        return $this->titulo_video;
    }

    public function set_titulo_video($titulo_video) {
        $this->titulo_video = $titulo_video;
    }

    public function get_texto_video() {
        return $this->texto_video;
    }

    public function set_texto_video($texto_video) {
        $this->texto_video = $texto_video;
    }

    public function get_iframe_video() {
        return $this->iframe_video;
    }

    public function set_iframe_video($iframe_video) {
        $this->iframe_video = $iframe_video;
    }

    public function get_data_video() {
        return $this->data_video;
    }

    public function set_data_video($data_video) {
        $this->data_video = $data_video;
    }

    public function get_status_video() {
        return $this->status_video;
    }

    public function set_status_video($status_video) {
        $this->status_video = $status_video;
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