<?php

class Noticia {

    private $id_noticia;
    private $id_categoria_noticia;
    private $titulo_noticia;
    private $url_amigavel;
    private $description_noticia;
    private $texto_noticia;
    private $data_noticia;
    private $data_cadastro_noticia;
    private $data_atualizacao_noticia;
    private $data_publicacao_noticia;
    private $data_expiracao_noticia;
    private $contador_noticia;
    private $destaque_slider;
    private $status_noticia;

    function get_id_noticia() {
        return $this->id_noticia;
    }

    function set_id_noticia($id_noticia) {
        $this->id_noticia = $id_noticia;
    }

    function get_id_categoria_noticia() {
        return $this->id_categoria_noticia;
    }

    function set_id_categoria_noticia($id_categoria_noticia) {
        $this->id_categoria_noticia = $id_categoria_noticia;
    }

    function get_titulo_noticia() {
        return $this->titulo_noticia;
    }

    function set_titulo_noticia($titulo_noticia) {
        $this->titulo_noticia = $titulo_noticia;
    }

    public function get_url_amigavel() {
        return $this->url_amigavel;
    }

    public function set_url_amigavel($url_amigavel) {
        $this->url_amigavel = $url_amigavel;
    }

    function get_description_noticia() {
        return $this->description_noticia;
    }

    function set_description_noticia($description_noticia) {
        $this->description_noticia = $description_noticia;
    }

    function get_texto_noticia() {
        return $this->texto_noticia;
    }

    function set_texto_noticia($texto_noticia) {
        $this->texto_noticia = $texto_noticia;
    }

    function get_data_noticia() {
        return $this->data_noticia;
    }

    function set_data_noticia($data_noticia) {
        $this->data_noticia = $data_noticia;
    }

    function get_data_cadastro_noticia() {
        return $this->data_cadastro_noticia;
    }

    function set_data_cadastro_noticia($data_cadastro_noticia) {
        $this->data_cadastro_noticia = $data_cadastro_noticia;
    }

    function get_data_atualizacao_noticia() {
        return $this->data_atualizacao_noticia;
    }

    function set_data_atualizacao_noticia($data_atualizacao_noticia) {
        $this->data_atualizacao_noticia = $data_atualizacao_noticia;
    }

    function get_data_publicacao_noticia() {
        return $this->data_publicacao_noticia;
    }

    function set_data_publicacao_noticia($data_publicacao_noticia) {
        $this->data_publicacao_noticia = $data_publicacao_noticia;
    }

    function get_data_expiracao_noticia() {
        return $this->data_expiracao_noticia;
    }

    function set_data_expiracao_noticia($data_expiracao_noticia) {
        $this->data_expiracao_noticia = $data_expiracao_noticia;
    }

    function get_contador_noticia() {
        return $this->contador_noticia;
    }

    function set_contador_noticia($contador_noticia) {
        $this->contador_noticia = $contador_noticia;
    }

    function get_destaque_slider() {
        return $this->destaque_slider;
    }

    function set_destaque_slider($destaque_slider) {
        $this->destaque_slider = $destaque_slider;
    }

    function get_status_noticia() {
        return $this->status_noticia;
    }

    function set_status_noticia($status_noticia) {
        $this->status_noticia = $status_noticia;
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