<?php

//header('Content-Type: text/html; charset=ISO-8859-1');
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
$post_request = array_merge($_POST, $_REQUEST);

$ctr_associado = new Associado_Control($post_request);
$condicao = "AND cpf = '$post_request[cpf]' AND telefone_celular = '$post_request[telefone]'";
$associado = $ctr_associado->Pega_Associado_Condicao($condicao);

$ctr_voto = new VotoEleicao_Control($post_request);

$voto1 = $ctr_voto->Verifica_Voto($associado['id_associado'], 1);
$voto2 = $ctr_voto->Verifica_Voto($associado['id_associado'], 2);

$sms = new SMS();

$telefoneFormat = preg_replace("/[^0-9]/", "", $post_request['telefone']);




if (isset($post_request['p']) && $post_request['p'] == 1) {
    if ($associado) {
        $codigo = rand(10000, 99999);

        if ($voto1['status_voto_eleicao'] == 'A' && $voto2['status_voto_eleicao'] == 'A') {
            $retorno['codigo'] = -1;
        } else if ($voto1['status_voto_eleicao'] == "A" && $voto2['status_voto_eleicao'] == "E") {
            $result = $sms->Send($telefoneFormat, "Confirme seu codigo novamente no site do Sindisea. Codigo: " . $codigo);
            $ctr_voto->Atualiza_Codigo($voto2['id_voto_eleicao'], $codigo);
            if ($result) {
                $retorno['codigo'] =-2;
                $retorno['passa'] = 1;
            } else {
                $retorno['codigo'] = -3;
            }
        } else if ($voto1['status_voto_eleicao'] == "E" && $voto2['status_voto_eleicao'] == "E") {
            $result = $sms->Send($telefoneFormat, "Confirme seu codigo novamente no site do Sindisea. Codigo: " . $codigo);
            
            $ctr_voto->Atualiza_Codigo($voto2['id_voto_eleicao'], $codigo);
            $ctr_voto->Atualiza_Codigo($voto1['id_voto_eleicao'], $codigo);

            if ($result || true) {
                $retorno['codigo'] = 1;
                $retorno['passa'] = 1;
            } else {
                $retorno['codigo'] = -3;
            }
        } else {
            $result = $sms->Send($telefoneFormat, "Confirme seu codigo no site do Sindisea. Codigo: " . $codigo);

            $ctr_voto->Guarda_Codigo($associado['id_associado'], 1, $codigo);
            $ctr_voto->Guarda_Codigo($associado['id_associado'], 2, $codigo);
            if ($result) {
                $retorno['codigo'] = 1;
                $retorno['passa'] = 1;
            } else {
                $retorno['codigo'] = -3;
            }
        }
    } else {
        $retorno['codigo'] = 0;
    }
} else if (isset($post_request['p']) && $post_request['p'] == 2) {
    if ($ctr_voto->Verifica_Voto($associado['id_associado'], 2, $post_request['codigo'])) {
        $retorno['passa'] = 1;
    } else {
        $retorno['codigo'] = 0;
    }

    // retirar quando em producao
    // $retorno['passa'] = 1;

} else if (isset($post_request['p']) && $post_request['p'] == 3) {    
    
    $ctr_voto->Votar($voto1['id_voto_eleicao'], $post_request['voto']);
    $retorno['passa'] = 1;
} else if (isset($post_request['p']) && $post_request['p'] == 4) {
    $result = $sms->Send($telefoneFormat, "Seu voto no site do Sindisea foi computado com sucesso!");
    $ctr_voto->Votar($voto2['id_voto_eleicao'], $post_request['voto']);
    $ctr_voto->Finaliza_Voto($voto1['id_voto_eleicao']);
    $ctr_voto->Finaliza_Voto($voto2['id_voto_eleicao']);


    $retorno['passa'] = 1;
}


echo json_encode($retorno);
