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

//	exit(0);
//-------------------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$config = new Config();
$factory = $config->get_banco();
$banco = new $factory();
$conexao = $banco->getInstance();

$id_galeria = trim($_REQUEST['id_galeria']);
$arquivo = $_FILES['Filedata']['name'];
$ext = trim(strtolower(substr($arquivo, -3)));
$diretorio = "arquivos/img_galerias/";

$sql = "LOCK TABLES tb_foto_galeria WRITE";
$result = $conexao->consulta("$sql");

$sql = "select max(id_foto) id_foto from tb_foto_galeria";
$result = $conexao->consulta("$sql");
$row = $conexao->criaArray($result);
$id_foto = $row[0]['id_foto'];
$id_foto++;

// tenta copiar a imagem.

if (!copy($_FILES['Filedata']['tmp_name'], $diretorio . "$id_foto.$ext")) {

    echo 'Erro ao transferir a Imagem.';
    exit();
} else {

    $objImage = new Imagem();
    $img = $objImage->resizeImage($diretorio, "$id_foto.$ext", 900);
}

// trata o destaque

$sql2 = "select count(id_foto) contador from tb_foto_galeria where id_galeria = $id_galeria and destaque = 1";
$result2 = $conexao->consulta("$sql2");
$row2 = $conexao->criaArray($result2);
;
$contador = $row2[0]['contador'];

if ($contador < 1) {
    $destaque = 1;
} else {
    $destaque = 0;
}

$sql = "select max(ordem) ordem from tb_foto_galeria where id_galeria = $id_galeria and status_foto = \"A\"";
$result = $conexao->consulta("$sql");
$row = $conexao->criaArray($result);
;
$ordem = $row[0]['ordem'];
mysqli_free_result($result);
$ordem++;

// cria o usuario

$sql = "INSERT INTO tb_foto_galeria values($id_foto, $id_galeria,
                                         \"$leg\",
                                         \"$ext\",$destaque,$ordem,
                                         \"A\")";

$result = $conexao->consulta("$sql");
//echo $sql;
// desbloqueia as tabelas usadas

$sql = "UNLOCK TABLES";
$result = $conexao->consulta("$sql");
?>