<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Valor_Centro, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Marcio Figueredo
 *
 * @package Control
 *
 */
class ValorCentro_Control extends Control {

    private $valor_centro_dao;

    /*     * $centro_dao
     * Carrega o contrutor do pai.
     *
     * @author Marcio Figueredo
     * @param Array $post_request Parâmetros de _POST e _REQUEST
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       parent::__construct();
     *       $config = new Config();
     *       $this->centro_dao = $config->get_DAO("Valor_Centro");
     *   }
     *
     * </code>
     *
     */

    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->valor_centro_dao = $this->config->get_DAO("ValorCentro");
    }

    public function Pegar_Valores($data) {
        $ctr_centro = new Centro_Control($post_request);

        $array = $ctr_centro->Listar_Centros("");
        
        $valores = Array();
        
        foreach ($array as $value) {           
            
            $condicao = " AND mes < '$data' AND id_centro = $value[id_centro]";
            $objetos = $this->valor_centro_dao->get_Objs($condicao, "mes DESC", 0, 1);
            $dados = array();
            $i = 0;
            
            while ($i < count($objetos)) {
                $dados[$i] = $objetos[$i]->get_all_dados();
                $valores[$value[id_centro]] = $valores[$value[id_centro]] + $dados[$i]['valor'];
                $i++;
            }
            
            
        }
        
        return $valores;
    }

}

?>
