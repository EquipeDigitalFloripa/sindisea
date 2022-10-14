<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$ctr_associado = new Associado_Control($post_request);
$array = $ctr_associado->Lista_Associados();

$titulo[] = "ID";
$titulo[] = "Nome";
$titulo[] = "E-mail - Empresarial";
$titulo[] = "E-mail - Pessoal";
$titulo[] = "CPF";
$titulo[] = "Data de Nascimento";
$titulo[] = "Matrícula";
$titulo[] = "Unidade Organizacional";
$titulo[] = "Categoria";
$titulo[] = "Telefone Residencial";
$titulo[] = "Telefone Empresarial";
$titulo[] = "Telefone Celular";
$titulo[] = "CEP";
$titulo[] = "Endereço";
$titulo[] = "Número";
$titulo[] = "Complemento";
$titulo[] = "Bairro";
$titulo[] = "Cidade";
$titulo[] = "Estado";
$titulo[] = "Data de Cadastro";
$titulo[] = "Data Início";
$titulo[] = "Data Fim";
$titulo[] = "Observações";

header("Content-Disposition: attachment; filename=\"Filiados.xls\"");
header("Content-Type: application/vnd.ms-excel;");
header("Pragma: no-cache");
header("Content-Type: text/csv; charset=utf-8");
header("Expires: 0");
$out = fopen("php://output", 'w');

fputcsv($out, $titulo, "\t");

foreach ($array as $data) {
//    $data = array_map("utf8_encode", $data);
    unset($data["senha"]);
    fputcsv($out, $data, "\t");
}
fclose($out);
?>