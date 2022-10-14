<?php

class TagNoticia {

    private $id_tag_noticia;
    private $id_noticia;
    private $id_tag;
    private $status_tag_noticia;

    public function get_id_tag_noticia() {
        return $this->id_tag_noticia;
    }

    public function set_id_tag_noticia($id_tag_noticia) {
        $this->id_tag_noticia = $id_tag_noticia;
    }

    public function get_id_noticia() {
        return $this->id_noticia;
    }

    public function set_id_noticia($id_noticia) {
        $this->id_noticia = $id_noticia;
    }

    public function get_id_tag() {
        return $this->id_tag;
    }

    public function set_id_tag($id_tag) {
        $this->id_tag = $id_tag;
    }

    public function get_status_tag_noticia() {
        return $this->status_tag_noticia;
    }

    public function set_status_tag_noticia($status_tag_noticia) {
        $this->status_tag_noticia = $status_tag_noticia;
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
