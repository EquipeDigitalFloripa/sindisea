<?php

// Work-around for setting up a session because Flash Player doesn't send the cookies
if (isset($_POST["PHPSESSID"])) {
    session_id($_POST["PHPSESSID"]);
}
session_start();
// The Demos don't save files

if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
    echo "Problema durante o UPLOAD";
}

//-------------------------------------------------------------
require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$config = new Config();
$factory = $config->get_banco();
$banco = new $factory();
$conexao = $banco->getInstance();


$id_noticia = trim($_REQUEST['id_noticia']);
$arquivo = $_FILES['Filedata']['name'];
$ext_foto = trim(strtolower(substr($arquivo, -3)));
$diretorio = "arquivos/img_noticias/";

$sql = "LOCK TABLES tb_foto_noticia WRITE";
$result = $conexao->consulta("$sql");

$sql = "SELECT MAX(id_foto) id_foto FROM tb_foto_noticia";
$result = $conexao->consulta("$sql");
$row = $conexao->criaArray($result);
$id_foto = $row[0]['id_foto'];
$id_foto++;

// tenta copiar a imagem.

if (!copy($_FILES['Filedata']['tmp_name'], $diretorio . "$id_foto.$ext_foto")) {
    echo 'Erro ao transferir a Imagem.';
    exit();
} else {
    $objImage = new Imagem();
    $img = $objImage->resizeImage($diretorio, "$id_foto.$ext_foto", 1000);

//    copy($_FILES['Filedata']['tmp_name'], $diretorio . "orig_$id_foto.$ext_foto");
//    $img2 = $objImage->resizeMinImage($diretorio, "orig_$id_foto.$ext_foto", 665);
}

$sql2 = "SELECT COUNT(id_foto) AS contador FROM tb_foto_noticia WHERE id_noticia = $id_noticia AND destaque_foto = 1";
$result2 = $conexao->consulta("$sql2");
$row2 = $conexao->criaArray($result2);

$contador = $row2[0]['contador'];

$destaque_foto = ($contador < 1) ? 1 : 0;

$sql = "SELECT MAX(ordem_foto) ordem_foto FROM tb_foto_noticia WHERE id_noticia = $id_noticia AND status_foto = \"A\"";
$result = $conexao->consulta("$sql");
$row = $conexao->criaArray($result);

$ordem_foto = $row[0]['ordem_foto'];
$ordem_foto++;

// cria o usuario

$sql = "INSERT INTO tb_foto_noticia 
        VALUES($id_foto, $id_noticia, \"\", \"$ext_foto\", $destaque_foto, $ordem_foto, \"A\")";
//echo $sql;
$result = $conexao->consulta("$sql");
// desbloqueia as tabelas usadas

$sql = "UNLOCK TABLES";
$result = $conexao->consulta("$sql");
echo "OK";

?>