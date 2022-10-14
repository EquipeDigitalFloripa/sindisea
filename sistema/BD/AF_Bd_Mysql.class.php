<?php

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

/**
 * Fábrica concreta de objetos
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package BD
 *
 */




class AF_Bd_Mysql extends AF_Bd {

/**
 * Carrega o contrutor do pai.
 *
 * @author Ricardo Ribeiro Assink
 * @return void
 * @Exemplo
 * <code>
 *
 *   public function __construct() {
 *      parent::__construct();
 *   }
 *
 * </code>
 *
 */
    public function __construct() {
        
        parent::__construct();
    }


/**
 *
 * Criar uma instância do banco de dados.
 *
 * @author Ricardo Ribeiro Assink
 * @return objeto Instância do banco de Dados
 * @Exemplo
 * <code>
 *
 * <?php
 *  $objeto = new AF_Bd_Mysql();
 *  $objeto->getInstance();
 *
 * ?>
 * </code>
 *
 */

   public function getInstance() {
        return Mysql::getInstance();
    }

}






?>
