<?php

class Candidato {


    private $id_candidato;
    private $nome;
    private $id_cargo;
    private $id_chapa;
    private $status_candidato;

    /**
     * @return mixed
     */
    public function get_id_candidato()
    {
        return $this->id_candidato;
    }

    /**
     * @param mixed $id_candidato
     * @return Candidato
     */
    public function set_id_candidato($id_candidato)
    {
        $this->id_candidato = $id_candidato;
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
     * @return Candidato
     */
    public function set_nome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_id_cargo()
    {
        return $this->id_cargo;
    }

    /**
     * @param mixed $id_cargo
     * @return Candidato
     */
    public function set_id_cargo($id_cargo)
    {
        $this->id_cargo = $id_cargo;
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
     * @return Candidato
     */
    public function set_id_chapa($id_chapa)
    {
        $this->id_chapa = $id_chapa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_status_candidato()
    {
        return $this->status_candidato;
    }

    /**
     * @param mixed $status_candidato
     * @return Candidato
     */
    public function set_status_candidato($status_candidato)
    {
        $this->status_candidato = $status_candidato;
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