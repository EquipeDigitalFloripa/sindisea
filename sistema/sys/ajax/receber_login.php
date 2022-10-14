<?php
$texto = strtolower(trim($_REQUEST["login_usuario"]));

 require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

    $config        = new Config();
    $factory       = $config->get_banco();
    $banco         = new $factory();
    $conexao       = $banco->getInstance();

 if($texto != ""){
			$sql        = "select count(id_usuario) contador from tb_usuario where login_usuario = \"$texto\"";
			$result     = mysql_query("$sql") or die ("ERRO: " . mysql_error());
			$result     = $conexao->consulta("$sql");
                        $row        = $conexao->criaArray($result);
                        print_r($row);
			
                        $contador   = $row["contador"];

 } else {

    $contador = 0;

 }



if($contador > 0) {
    echo true;
} else {
    echo false;
}
?>
