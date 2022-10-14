<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$ctr_depoimentos = new Depoimento_Control($post_request);
$array_depoimentos = $ctr_depoimentos->Lista_Depoimentos();


$li = '';
$i = 0;
foreach ($array_depoimentos as $dados) {
    extract($dados);
    $li .= '<li class="depo">
                <div class="texto_depoimento">                    
                    <p>"' . $dados['texto_depoimento'] . '"</p>
                    <div class="nome_depoimento">' . $dados['nome_depoimento'] . '</div>    
                </div>
            </li>';
}
$depoimentos = '<div class="carousel_depoimentos">
                    <ul class="slides">' . $li . '</ul>
                </div>';

echo $depoimentos;
?>