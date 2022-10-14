<?php

class TipoMovimentacao {


    private $id_tipo_movimentacao;
    private $descricao;
//    private $rd;
    private $status_tipo_movimentacao;

    function get_id_tipo_movimentacao() {
        return $this->id_tipo_movimentacao;
    } 
    
    function set_id_tipo_movimentacao($id_tipo_movimentacao) {
        $this->id_tipo_movimentacao = $id_tipo_movimentacao;
    }

    function get_descricao() {
        return $this->descricao;
    }
    
    function set_descricao($descricao) {
        $this->descricao = $descricao;
    }
    
//    function get_rd() {
//        return $this->rd;
//    }
//
//    function set_rd($rd) {
//        $this->rd = $rd;
//    }
    
    function get_status_tipo_movimentacao() {
        return $this->status_tipo_movimentacao;
    }    

    function set_status_tipo_movimentacao($status_tipo_movimentacao) {
        $this->status_tipo_movimentacao = $status_tipo_movimentacao;
    }
    
    public function get_all_dados() {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach($props as $prop) {
            $f = $prop->getName();
            // pra nao voltar a conexao
            if($f != "conexao") {
                $exec = '$valor = $this->get_'.$f.'();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }


}

?>