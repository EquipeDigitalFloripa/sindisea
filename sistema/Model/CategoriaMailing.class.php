<?php

class CategoriaMailing {


    private $tipo_mailing;
    private $desc_tipo_mailing;
    private $status_tipo_mailing;

    public function get_tipo_mailing() {
        return $this->tipo_mailing;
    }

    public function set_tipo_mailing($tipo_mailing) {
        $this->tipo_mailing = $tipo_mailing;
    }

    public function get_desc_tipo_mailing() {
        return $this->desc_tipo_mailing;
    }

    public function set_desc_tipo_mailing($desc_tipo_mailing) {
        $this->desc_tipo_mailing = $desc_tipo_mailing;
    }

    public function get_status_tipo_mailing() {
        return $this->status_tipo_mailing;
    }

    public function set_status_tipo_mailing($status_tipo_mailing) {
        $this->status_tipo_mailing = $status_tipo_mailing;
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