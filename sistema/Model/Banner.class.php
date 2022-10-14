<?php

    class Banner {

    private $id_banner;
    private $nome;
    private $ext;
    private $link;
    private $regiao;
    private $status_banner;

    public function get_id_banner() {
        return $this->id_banner;
    }

    public function set_id_banner($id_banner) {
        $this->id_banner = $id_banner;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_ext() {
        return $this->ext;
    }

    public function set_ext($ext) {
        $this->ext = $ext;
    }

    public function get_link() {
        return $this->link;
    }

    public function set_link($link) {
        $this->link = $link;
    }

    public function get_regiao() {
        return $this->regiao;
    }

    public function set_regiao($regiao) {
        $this->regiao = $regiao;
    }

    public function get_status_banner() {
        return $this->status_banner;
    }

    public function set_status_banner($status_banner) {
        $this->status_banner = $status_banner;
    }



    public function get_all_dados() {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach($props as $prop){
            $f = $prop->getName();
            // pra nao voltar a conexao
            if($f != "conexao"){
                $exec = '$valor = $this->get_'.$f.'();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }


}

?>