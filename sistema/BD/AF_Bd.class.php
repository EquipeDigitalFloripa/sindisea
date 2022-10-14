<?php

/**
 * Abstract Factory para BD
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


abstract class AF_Bd {


/**
 * Nenhuma
 *
 * @author Ricardo Ribeiro Assink
 * @return void
 * @Exemplo
 * <code>
 *
 *   public function __construct() {
 *      
 *   }
 *
 * </code>
 *
 */
    protected function __construct() {

    }





/**
 * Definição abstrata de criação de Instância.
 *
 * @author Ricardo Ribeiro Assink
 * @return void
 * @Exemplo
 * <code>
 *
 * <?php
 *
 *
 *  $objeto = new AF_bd();
 *  $banco  = $objeto->criarInstancia();
 *
 * ?>
 * </code>
 *
 */
    abstract public function getInstance();


    
}


?>
