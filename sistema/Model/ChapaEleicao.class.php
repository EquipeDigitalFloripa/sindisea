<?php

class ChapaEleicao {


    private $id_chapa_eleicao;
    private $nome;
    private $id_eleicao;
    private $status_chapa_eleicao;

    /**
     * @return mixed
     */
    public function get_id_chapa_eleicao()
    {
        return $this->id_chapa_eleicao;
    }

    /**
     * @param mixed $id_chapa_eleicao
     * @return ChapaEleicao
     */
    public function set_id_chapa_eleicao($id_chapa_eleicao)
    {
        $this->id_chapa_eleicao = $id_chapa_eleicao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_nome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return ChapaEleicao
     */
    public function set_nome($nome)
    {
        $this->nome = $nome;
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
     * @return ChapaEleicao
     */
    public function set_id_eleicao($id_eleicao)
    {
        $this->id_eleicao = $id_eleicao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_status_chapa_eleicao()
    {
        return $this->status_chapa_eleicao;
    }

    /**
     * @param mixed $status_chapa_eleicao
     * @return ChapaEleicao
     */
    public function set_status_chapa_eleicao($status_chapa_eleicao)
    {
        $this->status_chapa_eleicao = $status_chapa_eleicao;
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