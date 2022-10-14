<?php

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");
$post_request = "";

$con = mysqli_connect("localhost", "root", "rootpass", "sindiasea");

$sql_statement = "SELECT * FROM tb_importacao";

$result = mysqli_query($con, "$sql_statement");

$got = Array();

$ctr_associado = new Associado_Control($post_request);

if (@mysqli_num_rows($result) > 0) {
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        array_push($got, $row);
    }
}

foreach ($got as $associado){
    $ctr_associado->Associado_Add_Script($associado);
}
