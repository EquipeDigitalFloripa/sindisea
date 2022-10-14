<?php

// Work-around for setting up a session because Flash Player doesn't send the cookies
if (isset($_POST["PHPSESSID"])) {
    session_id($_POST["PHPSESSID"]);
}

session_start();

// The Demos don't save files
if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
    echo "Problema durante o UPLOAD";
    exit(0);
}

//-------------------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

// Pega configs do banco
$config = new Config();
$factory = $config->get_banco();
$banco = new $factory();
$conexao = $banco->getInstance();

// Recebe informaçõe do formulário e faz o devido tratamento
$id_slider = trim($_REQUEST['id_slider']);
$arquivo = $_FILES['Filedata']['name'];
$imagem_upload = $_FILES['Filedata']['tmp_name'];
$ext_foto = trim(strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)));

// Seta pasta destino das imagens
$diretorio = "arquivos/img_slider/";

// Bloqueia as tabelas a serem usadas
$sql = "LOCK TABLES tb_slider_foto WRITE";
$result = $conexao->consulta("$sql");

// Pega o ultimo id da foto e incrementa
$sql = "SELECT MAX(id_foto) AS id_foto FROM tb_slider_foto";
$result = $conexao->consulta("$sql");
$row = $conexao->criaArray($result);
$id_foto = $row[0]['id_foto'];
$id_foto++;

// tenta copiar a imagem.
if (!copy($_FILES['Filedata']['tmp_name'], $diretorio . "$id_foto.$ext_foto")) {
    echo 'Erro ao transferir a Imagem.';
    exit();
} else {
    chmod("$diretorio/$id_foto.$ext_foto", 0777);

    // verifica se existe foto destaque
    $sql2 = "SELECT COUNT(id_foto) AS contador FROM tb_slider_foto WHERE id_slider = $id_slider";
    $result2 = $conexao->consulta("$sql2");
    $row2 = $conexao->criaArray($result2);

    $contador = $row2[0]['contador'];
    $destaque = ($contador < 1) ? 1 : 0;

    // pega a ultima ordem_foto  e inscrementa
    $sql3 = "SELECT MAX(ordem_foto) ordem FROM tb_slider_foto WHERE id_slider = $id_slider AND status_foto = 'A'";
    
    $result3 = $conexao->consulta($sql3);
    $row3 = $conexao->criaArray($result);
    
    $ordem_foto = $row3[0][0];
    $ordem_foto++;
    
    // Insere a foto no banco de dados
    $sql4 = "INSERT INTO tb_slider_foto(id_foto, id_slider, titulo_foto, legenda_foto, link_foto, ext_foto, ordem_foto, status_foto) VALUES ($id_foto, $id_slider, '', '', '', '$ext_foto', $ordem_foto, 'A')";

    $result4 = $conexao->consulta($sql4);
}

// Desbloqueia as tabelas usadas
$sql5 = "UNLOCK TABLES";
$result5 = $conexao->consulta($sql5);

sleep(2);
?>
