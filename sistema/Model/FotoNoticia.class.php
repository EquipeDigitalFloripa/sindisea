<?php

class FotoNoticia {

    private $id_foto;
    private $id_noticia;
    private $leg_foto;
    private $ext_foto;
    private $destaque_foto;
    private $ordem_foto;
    private $status_foto;

    public function get_id_foto() {
        return $this->id_foto;
    }

    public function set_id_foto($id_foto) {
        $this->id_foto = $id_foto;
    }

    public function get_id_noticia() {
        return $this->id_noticia;
    }

    public function set_id_noticia($id_noticia) {
        $this->id_noticia = $id_noticia;
    }

    public function get_leg_foto() {
        return $this->leg_foto;
    }

    public function set_leg_foto($leg_foto) {
        $this->leg_foto = $leg_foto;
    }

    public function get_ext_foto() {
        return $this->ext_foto;
    }

    public function set_ext_foto($ext_foto) {
        $this->ext_foto = $ext_foto;
    }

    public function get_destaque_foto() {
        return $this->destaque_foto;
    }

    public function set_destaque_foto($destaque_foto) {
        $this->destaque_foto = $destaque_foto;
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

?>