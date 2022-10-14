<?php

class VotoEleicao {


    private $id_voto_eleicao;
    private $id_associado;
    private $id_eleicao;
    private $id_chapa;
    private $data_voto;
    private $codigo;
    private $status_voto_eleicao;

    /**
     * @return mixed
     */
    public function get_id_voto_eleicao()
    {
        return $this->id_voto_eleicao;
    }

    /**
     * @param mixed $id_voto_eleicao
     * @return CategoriaArquivo
     */
    public function set_id_voto_eleicao($id_voto_eleicao)
    {
        $this->id_voto_eleicao = $id_voto_eleicao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_id_associado()
    {
        return $this->id_associado;
    }

    /**
     * @param mixed $id_associado
     * @return CategoriaArquivo
     */
    public function set_id_associado($id_associado)
    {
        $this->id_associado = $id_associado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_id_eleicao()
    {
        return $this->id_eleicao;
    }

    /**
     * @param mixed $id_eleicao
     * @return CategoriaArquivo
     */
    public function set_id_eleicao($id_eleicao)
    {
        $this->id_eleicao = $id_eleicao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_id_chapa()
    {
        return $this->id_chapa;
    }

    /**
     * @param mixed $id_chapa
     * @return CategoriaArquivo
     */
    public function set_id_chapa($id_chapa)
    {
        $this->id_chapa = $id_chapa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_data_voto()
    {
        return $this->data_voto;
    }

    /**
     * @param mixed $data_voto
     * @return
     */
    public function set_data_voto($data_voto)
    {
        $this->data_voto = $data_voto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_codigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     * @return
     */
    public function set_codigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_status_voto_eleicao()
    {
        return $this->status_voto_eleicao;
    }

    /**
     * @param mixed $status_voto_eleicao
     * @return CategoriaArquivo
     */
    public function set_status_voto_eleicao($status_voto_eleicao)
    {
        $this->status_voto_eleicao = $status_voto_eleicao;
        return $this;
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