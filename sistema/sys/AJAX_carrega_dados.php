<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$ctr_contato = new Contato_Control($post_request);

$json = Array();

if (isset($post_request['ano'])) {

    $condicao_ano = "AND DATE_FORMAT(data_contato, '%Y') = '" . $post_request['ano'] . "'";
    $condicao_mes = "";
    $condicao_periodo = "";

    $sql = "SELECT DATE_FORMAT(data_contato, '%m') AS var, COUNT(*) AS qtde 
            FROM tb_contato 
            WHERE status_contato = 'A' $condicao_ano
            GROUP BY var 
            ORDER BY var ASC";

    if (isset($post_request['mes']) && $post_request['mes'] > 0) {
        $condicao_mes = " AND DATE_FORMAT(data_contato, '%m') = '" . $post_request['mes'] . "'";

        $sql = "SELECT DATE_FORMAT(data_contato, '%d') AS var, COUNT(*) AS qtde 
                FROM tb_contato 
                WHERE status_contato = 'A' $condicao_ano $condicao_mes
                GROUP BY var 
                ORDER BY var ASC";
    }
    if ((isset($post_request['data_inicio']) && $post_request['data_inicio'] != "") && (isset($post_request['data_fim']) && $post_request['data_fim'] != "")) {

        $condicao_periodo = " AND DATE_FORMAT(data_contato, '%Y-%m-%d') BETWEEN date('" . $post_request['data_inicio'] . "') AND date('" . $post_request['data_fim'] . "')";

        $sql = "SELECT DATE_FORMAT(data_contato, '%d') AS var, COUNT(*) AS qtde 
                FROM tb_contato 
                WHERE status_contato = 'A' $condicao_periodo
                GROUP BY var 
                ORDER BY var ASC";
    }
    if (isset($post_request['tipo']) && $post_request['tipo'] != 0) {

        $tipo = ($post_request['tipo'] == 1) ? 'assunto' : 'onde_conheceu';

        $sql = "SELECT $tipo AS var, COUNT(*) AS qtde 
                FROM tb_contato 
                WHERE status_contato = 'A' $condicao_mes $condicao_periodo
                GROUP BY var";
    }
    if (((isset($post_request['mes']) && $post_request['mes'] == 0) && (isset($post_request['tipo']) && $post_request['tipo'] == 0)) && ((isset($post_request['data_inicio']) && $post_request['data_inicio'] == "") && (isset($post_request['data_fim']) && $post_request['data_fim'] == ""))) {
        $sql = "SELECT DATE_FORMAT(data_contato, '%m') AS var, COUNT(*) AS qtde 
                FROM tb_contato 
                WHERE status_contato = 'A' $condicao_ano
                GROUP BY var 
                ORDER BY var ASC";
    }

    $objetos = $ctr_contato->Carrega_Dados($sql);

    $array_mes = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');

    $linha = Array();
    $i = $count = 0;
    while ($i < count($objetos)) {
        
        $count = $count + $objetos[$i]['qtde'];
        $s = ($objetos[$i]['qtde'] > 1) ? " contatos" : " contato";
        $linha[] = array('c' => array(
                array("v" => utf8_encode($objetos[$i]['var']), "f" => NULL),
                array("v" => $objetos[$i]['qtde'], "f" => NULL),
                array("v" => $objetos[$i]['qtde'] . "$s", "f" => NULL))
        );

        $i++;
    }

    $json['contador'] = $count;
    $json['grafico'] = array(
        'cols' => array(
            array("id" => "A", "label" => "Bairros", "type" => "string"),
            array("id" => "B", "label" => "Contatos", "type" => "number"),
            array("id" => "C", "label" => "Contato", "role" => 'annotation', "type" => "string")
        ), 'rows' => $linha
    );
}

echo json_encode($json);
?>