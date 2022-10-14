<?php
   require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

   $tam = $_REQUEST['tamanho'];
   if(!isset($_REQUEST['tamanho'])){
       $tam = '50';
   }
   $diretorio  = $_REQUEST['diretorio'];
   $arquivo  = $_REQUEST['arquivo'];
   $imagem = new Imagem();
   $imagem->makeThumb($diretorio,$arquivo,$tam);
?>