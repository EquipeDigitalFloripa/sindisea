<?php

class Portfolio {

    private $id_portfolio;
    private $nome_portfolio;
    private $site_portfolio;
    private $ext_img_portfolio;
    private $status_portfolio;

    public function get_id_portfolio() {
        return $this->id_portfolio;
    }

    public function set_id_portfolio($id_portfolio) {
        $this->id_portfolio = $id_portfolio;
    }

    public function get_nome_portfolio() {
        return $this->nome_portfolio;
    }

    public function set_nome_portfolio($nome_portfolio) {
        $this->nome_portfolio = $nome_portfolio;
    }

    public function get_site_portfolio() {
        return $this->site_portfolio;
    }

    public function set_site_portfolio($site_portfolio) {
        $this->site_portfolio = $site_portfolio;
    }

    public function get_ext_img_portfolio() {
        return $this->ext_img_portfolio;
    }

    public function set_ext_img_portfolio($ext_img_portfolio) {
        $this->ext_img_portfolio = $ext_img_portfolio;
    }

    public function get_status_portfolio() {
        return $this->status_portfolio;
    }

    public function set_status_portfolio($status_portfolio) {
        $this->status_portfolio = $status_portfolio;
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
