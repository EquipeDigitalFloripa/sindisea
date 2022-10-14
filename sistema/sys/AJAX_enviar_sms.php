<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
$post_request = array_merge($_POST, $_REQUEST);

$sms = new SMS();

$telefone = preg_replace("/[^0-9]/", "", $post_request['c']);

$result = $sms->Send($telefone, $post_request['t']);

echo json_encode($result);

?>