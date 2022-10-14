<?php
require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");;

/**
 * DAO da entidade Mailing, acessa todas as operações de banco de dados referentes ao Model Mailing
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 13/10/2009
 * @Ultima_Modif 13/10/2009 por Marcela Santana
 *
 *
 * @package DAO
 *
 */
class Candidato_DAO extends Generic_DAO {

    public $chave = 'id_candidato';
    public $tabela = 'tb_candidato';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }


    /**
     *
     * Retorna as descrições de campos
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return Array Array com as descrições de campos
     *
     * @exemplo
     * <code>
     *
     * Array
     *      (
     *          [desc_perm_usuario] => Array
     *              (
     *                  [R] => Root
     *                  [W] => Webmaster
     *                  [A] => Autor
     *                  [D] => Diretor do Portal
     *                  [C] => Consultor
     *                  [S] => Salva Vidas
     *              )
     *
     *          [desc_status_usuario] => Array
     *              (
     *                  [P] => Aguardando aprovação
     *                  [N] => Negada a entrada na Comunidade
     *                  [A] => Ativo
     *                  [I] => Inativo
     *              )
     *
     *      )
     *
     *
     * </code>
     *
     */
    public function get_Descricao(){

        $desc = Array();
        $desc['eleicao'] = parent::get_Descricoes('tb_eleicao');
        $desc['cargo'] = parent::get_Descricoes('tb_cargo_eleicao');
        $desc['chapa'] = parent::get_Descricoes('tb_chapa_eleicao');
        $desc['chapa2'] = parent::get_Descricoes('tb_chapa_eleicao', 0, 2);
        return $desc;

    }

}
?>
