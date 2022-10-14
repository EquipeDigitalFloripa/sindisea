<?php

class Centro {


    private $id_centro;
    private $descricao;
    private $status_centro;
    
    function get_id_centro() {
        return $this->id_centro;
    }
    
    function set_id_centro($id_centro) {
        $this->id_centro = $id_centro;
    }

    function get_descricao() {
        return $this->descricao;
    }
    
    function set_descricao($descricao) {
        $this->descricao = $descricao;
    }

    function get_status_centro() {
        return $this->status_centro;
    }    

    function set_status_centro($status_centro) {
        $this->status_centro = $status_centro;
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