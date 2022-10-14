<?php

class CategoriaNoticia{

    private $id_categoria_noticia;
    private $desc_categoria_noticia;
    private $data_cadastro_categoria_noticia;
    private $status_categoria_noticia;

    public function get_id_categoria_noticia() {
        return $this->id_categoria_noticia;
    }

    public function set_id_categoria_noticia($id_categoria_noticia) {
        $this->id_categoria_noticia = $id_categoria_noticia;
    }

    public function get_desc_categoria_noticia() {
        return $this->desc_categoria_noticia;
    }

    public function set_desc_categoria_noticia($desc_categoria_noticia) {
        $this->desc_categoria_noticia = $desc_categoria_noticia;
    }

    public function get_data_cadastro_categoria_noticia() {
        return $this->data_cadastro_categoria_noticia;
    }

    public function set_data_cadastro_categoria_noticia($data_cadastro_categoria_noticia) {
        $this->data_cadastro_categoria_noticia = $data_cadastro_categoria_noticia;
    }

    public function get_status_categoria_noticia() {
        return $this->status_categoria_noticia;
    }

    public function set_status_categoria_noticia($status_categoria_noticia) {
        $this->status_categoria_noticia = $status_categoria_noticia;
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
