<?
#echo mysql_get_client_info();
$conexao = mysql_connect("localhost", "root", "rootpass")
       or die("N�o foi poss�vel efetuar conex�o com banco de dados : " . mysql_error());

$aux = $conexao;

mysql_select_db("liana");

?>
