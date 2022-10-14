<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");


/**
 * LOGIN
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
$post_request = array_merge($_POST, $_REQUEST);


$enc = new Encripta();

$co = $enc->md5_decrypt($post_request['co']);
$ac = $enc->md5_decrypt($post_request['ac']);

$config = new Config();
$objeto = new $co($post_request, $config);


call_user_func(Array($objeto, $ac), $post_request);
?>
