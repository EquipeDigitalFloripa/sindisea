<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
$post_request = array_merge($_POST, $_REQUEST);

header("Content-type: text/html; charset=ISO-8859-1");

$config = new Config();
$factory = $config->get_banco();
$banco = new $factory();
$conexao = $banco->getInstance();

//========== AJAX para a categoria de posts;
if (isset($post_request['id_tipo_noticia']) && !empty($post_request['id_tipo_noticia'])) {
    $action = $post_request['id_tipo_noticia'];
    $sql = "SELECT * FROM tb_categoria_noticia WHERE id_tipo_noticia = '$action'";
    $result = $conexao->consulta("$sql");
    $row = $conexao->criaArray($result);

    if ($row != null) {
        foreach ($row as $r) {
            $value = $r['id_categoria_noticia'];
            $nome = $r['desc_categoria_noticia'];
            echo "<option value='$value'>$nome</option>";
        }
    } else {
        echo "<option value='0'>Não existe categorias</option>";
    }
}

if (isset($post_request['titulo_noticia_relacionada']) && !empty($post_request['titulo_noticia_relacionada'])) {
    $pesquisa = $post_request['titulo_noticia_relacionada'];

    $sql = "SELECT id_noticia, titulo_noticia, data_noticia
            FROM tb_noticia 
            WHERE status_noticia = 'A' AND titulo_noticia LIKE '%" . $pesquisa . "%'
            ORDER BY data_noticia DESC
            ";
    $result = $conexao->consulta("$sql");
    $row = $conexao->criaArray($result);

    if ($row != null) {
        $i = 0;
        foreach ($row as $r) {
            if (($i % 2) == 0) {
                $bg = "style='background:#F0F0F0;'";
            } else {
                $bg = "style='background:#FFFFFF;'";
            }
            $i++;
            $value = $r['id_noticia'];
            $nome = $r['titulo_noticia'];
            $data = $r['data_noticia'];
            $tr .= "<tr $bg>
                        <td><input type='checkbox' name='relacao[]' id='relacao[]' value='$value'/></td>
                        <td>$value</td>
                        <td>$nome</td>
                        <td>" . date("d/m/Y", strtotime($data)) . "</td>
                    </tr>";
        }
        echo "<table width=\"100%\" cellspacing=\"5\">
                    <tr>
                        <td width=\"10%\">SELECIONAR</td>
                        <td width=\"10%\">ID</td>
                        <td width=\"70%\">TÍTULO DA NOTÍCIA</td>
                        <td width=\"10%\">DATA DA NOTÍCIA</td>
                    </tr>
                    $tr
                    </table>";
    } else {
        echo "<td>Nenhuma NOTÍCIA encontrada</td>";
    }
}
?>
