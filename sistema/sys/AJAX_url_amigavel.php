<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
$post_request = array_merge($_POST, $_REQUEST);

$texto = strtolower(trim($_REQUEST["login"]));
$id_membro = trim($_REQUEST["id_membro"]);

if ($id_membro != "") {
    $config = new Config();
    $factory = $config->get_banco();
    $banco = new $factory();
    $conexao = $banco->getInstance();

    if ($texto != "" and strlen($texto) > 2) {
        $sql = "SELECT id_conteudo FROM tb_conteudo WHERE url_amigavel = \"$texto\"";
        $result = $conexao->consulta("$sql");
        $row = $conexao->criaArray($result);
        $confere = $row[0][0];

        if ($confere == $id_membro or $confere == "") { // se o id retornado for igual ao meu id
            $contador = 0;
        } else {  // se o id retornado for diferente ou nulo
            $contador = 1;
        }
    } else {

        $contador = 1;
    }


    if ($contador > 0) {
        echo true;
    } else {
        echo false;
    }
}


if (isset($post_request['string'])) {
    $json = array();
    $json["sucesso"] = 0;



    $noticia = new Noticia_Control($post_request);
    $verificado = $noticia->Verificar_URL($post_request['string']);
    if ($verificado > 0 && $verificado != "") {
        $json["sucesso"] = $verificado;
    }
    echo json_encode($json);
}
?>
