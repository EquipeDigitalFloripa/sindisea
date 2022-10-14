<?php

class CategoriaArquivo {


    private $id_categoria;
    private $nome_categoria;
    private $status_categoria;

    public function get_id_categoria() {
        return $this->id_categoria;
    }

    public function set_id_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    public function get_nome_categoria() {
        return $this->nome_categoria;
    }

    public function set_nome_categoria($nome_categoria) {
        $this->nome_categoria = $nome_categoria;
    }

    public function get_status_categoria() {
        return $this->status_categoria;
    }

    public function set_status_categoria($status_categoria) {
        $this->status_categoria = $status_categoria;
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