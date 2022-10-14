<?php

class RelacaoConteudo {

    private $id_rel_conteudo;
    private $id_noticia;
    private $id_conteudo;
    private $status_rel_conteudo;

    public function get_id_rel_conteudo() {
        return $this->id_rel_conteudo;
    }

    public function set_id_rel_conteudo($id_rel_conteudo) {
        $this->id_rel_conteudo = $id_rel_conteudo;
    }

    public function get_id_noticia() {
        return $this->id_noticia;
    }

    public function set_id_noticia($id_noticia) {
        $this->id_noticia = $id_noticia;
    }

    public function get_id_conteudo() {
        return $this->id_conteudo;
    }

    public function set_id_conteudo($id_conteudo) {
        $this->id_conteudo = $id_conteudo;
    }

    public function get_status_rel_conteudo() {
        return $this->status_rel_conteudo;
    }

    public function set_status_rel_conteudo($status_rel_conteudo) {
        $this->status_rel_conteudo = $status_rel_conteudo;
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
