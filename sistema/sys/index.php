<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * INDEX
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
 * @package sys
 *
 */
$objeto = new Encripta();

$co = $objeto->md5_encrypt("Login_Control");
$ac = $objeto->md5_encrypt("Login_V");

header("Location: login.php?ac=$ac&co=$co");
exit();
?>