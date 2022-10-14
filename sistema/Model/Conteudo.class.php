<?php

class Conteudo {

    private $id_conteudo;
    private $nome_link;
    private $conteudo;
    private $ordem_menu;
    private $status_conteudo;
    private $menu;
    private $keywords;
    private $title_url;
    private $url_amigavel;
    private $arquivo_pagina;

    public function get_id_conteudo() {
        return $this->id_conteudo;
    }

    public function set_id_conteudo($id_conteudo) {
        $this->id_conteudo = $id_conteudo;
    }

    public function get_nome_link() {
        return $this->nome_link;
    }

    public function set_nome_link($nome_link) {
        $this->nome_link = $nome_link;
    }

    public function get_conteudo() {
        return $this->conteudo;
    }

    public function set_conteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function get_ordem_menu() {
        return $this->ordem_menu;
    }

    public function set_ordem_menu($ordem_menu) {
        $this->ordem_menu = $ordem_menu;
    }

    public function get_status_conteudo() {
        return $this->status_conteudo;
    }

    public function set_status_conteudo($status_conteudo) {
        $this->status_conteudo = $status_conteudo;
    }

    public function get_menu() {
        return $this->menu;
    }

    public function set_menu($menu) {
        $this->menu = $menu;
    }

    public function get_keywords() {
        return $this->keywords;
    }

    public function set_keywords($keywords) {
        $this->keywords = $keywords;
    }

    public function get_title_url() {
        return $this->title_url;
    }

    public function set_title_url($title_url) {
        $this->title_url = $title_url;
    }

    public function get_url_amigavel() {
        return $this->url_amigavel;
    }

    public function set_url_amigavel($title_url) {
        $this->url_amigavel = $title_url;
    }

    public function get_arquivo_pagina() {
        return $this->arquivo_pagina;
    }

    public function set_arquivo_pagina($title_url) {
        $this->arquivo_pagina = $title_url;
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