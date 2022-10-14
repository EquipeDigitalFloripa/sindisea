<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class ValorCentro_DAO extends Generic_DAO {

    public $chave = 'id_valor_centro';
    public $tabela = 'tb_valor_centro';

    public function __construct($factory) {
        parent::__construct($factory, $this->chave, $this->tabela);
    }

    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {
        
        $desc = Array();
        
        $desc['centro'] = parent::get_Descricoes('tb_tipo_noticia');
        return $desc;
    }

}

?>