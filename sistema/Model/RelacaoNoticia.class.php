<?php

class RelacaoNoticia {

    private $id_relacao;
    private $id_noticia;
    private $id_noticia_relacionado;
    private $status_relacao;

    public function get_id_relacao() {
        return $this->id_relacao;
    }

    public function set_id_relacao($id_relacao) {
        $this->id_relacao = $id_relacao;
    }

    public function get_id_noticia() {
        return $this->id_noticia;
    }

    public function set_id_noticia($id_noticia) {
        $this->id_noticia = $id_noticia;
    }

    public function get_id_noticia_relacionado() {
        return $this->id_noticia_relacionado;
    }

    public function set_id_noticia_relacionado($id_noticia_relacionado) {
        $this->id_noticia_relacionado = $id_noticia_relacionado;
    }

    public function get_status_relacao() {
        return $this->status_relacao;
    }

    public function set_status_relacao($status_relacao) {
        $this->status_relacao = $status_relacao;
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
