<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade CategoriaNoticia, acessa todas as operações de banco de dados referentes ao Model CategoriaNoticia que está em Libs
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 06/07/2016
 * @package DAO
 *
 */
class CategoriaNoticia_DAO extends Generic_DAO {

    public $chave = 'id_categoria_noticia';
    public $tabela = 'tb_categoria_noticia';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    /**
     * Retorna a descrição de uma tabela, campo retornado deve ser informado
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return Array Array com as descrições de campos
     */
    public function get_Descricao() {

        $desc = Array();

        $desc['tipo_noticia'] = parent::get_Descricoes('tb_tipo_noticia');

        return $desc;
    }

}

?>
