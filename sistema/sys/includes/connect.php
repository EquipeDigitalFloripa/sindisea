<?
#echo mysql_get_client_info();
$conexao = mysql_connect("localhost", "root", "rootpass")
       or die("Não foi possível efetuar conexão com banco de dados : " . mysql_error());

$aux = $conexao;

mysql_select_db("liana");

?>
