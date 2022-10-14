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
$id_plano = trim($_REQUEST['id_plano']);
$arquivo = $_FILES['Filedata']['name'];
$imagem_upload = $_FILES['Filedata']['tmp_name'];
$ext = trim(strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)));
// Seta pasta destino das imagens
$diretorio = "arquivos/img_planos/";

// tenta copiar a imagem.
if (!copy($imagem_upload, $diretorio . "$id_plano.$ext")) {
    echo '#1 Erro ao transferir a Imagem.';
    exit();
} else {

    $objImage = new Imagem();

    // Redimensiona a imagem
    $img = $objImage->resizeImage($diretorio, "$id_plano.$ext");

    if (!$img) {
        echo "#2 Erro ao tentar redimensioanr a imagem";
        exit();
    } else {
        if (!copy($imagem_upload, $diretorio . "orig_$id_plano.$ext")) {
            echo "#3 Erro ao tentar copiar a imagem";
            exit();
        } else {

            if (!$objImage->resizeMinImage($diretorio, "orig_$id_plano.$ext", 285)) {
                echo "#4 Erro ao tentar realizar o resizeMinImage ";
                exit();

            // Caso haja sucesso registra a foto no banco de dados
            } else {
                
                // Insere a foto no banco de dados
                
                $sql4 = "UPDATE tb_plano SET extensao='$ext' WHERE id_plano = $id_plano";
//                echo $sql4;
                $result4 = $conexao->consulta($sql4);
                
                sleep(2);
            }
        }
    }
}

// Desbloqueia as tabelas usadas
$sql5 = "UNLOCK TABLES";
$result5 = $conexao->consulta($sql5);
