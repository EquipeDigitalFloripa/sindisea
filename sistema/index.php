<?php

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");
header ('Content-type: text/html; charset=iso-8859-1');

$objeto = new Encripta();

$co = $objeto->md5_encrypt("Login_Control");
$ac = $objeto->md5_encrypt("Login_V");

header("Location: sys/login.php?ac=$ac&co=$co");
exit();

?>