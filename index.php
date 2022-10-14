<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
$post_request = array_merge($_POST, $_REQUEST);

$detect = new Mobile_Detect();

$js_head = <<<JAVASCRIPT
        
    <script src="./scripts/jquery-1.12.3.min.js" type="text/javascript"></script>    
    <script src="./scripts/flexslider/jquery.flexslider.js"></script>
    <link href="./scripts/flexslider/flexslider.css" rel="stylesheet" type="text/css">
    
    <script type="text/javascript">   
        
        $(document).ready(function () {
            
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: true,
                directionNav: false,
            });
        });
        
    </script>
   
JAVASCRIPT;


/* * ***************************************************************************
 * NOTÍCIAS CAPA
 * *************************************************************************** */
$ctr_noticia = new Noticia_Control($post_request);
if (!$detect->isMobile()) {
    $array_noticias = $ctr_noticia->Listar_Noticias(" AND status_noticia = 'A' AND data_publicacao_noticia <= now()", "data_noticia DESC", 0, 6);
} else {
    $array_noticias = $ctr_noticia->Listar_Noticias(" AND status_noticia = 'A' AND data_publicacao_noticia <= now()", "data_noticia DESC", 0, 3);
}

$data = new Data();

$html_noticia = "";

foreach ($array_noticias as $noticia) {

    $destaque = $ctr_noticia->Pega_Foto_Destaque($noticia['id_noticia']);
    $foto_destaque = $destaque[0]['id_foto'] . "." . $destaque[0]['ext_foto'];

    $html_noticia .= '
            <div class="noticia">
                <a href="noticia/' . $noticia['url_amigavel'] . '">
                    <div class="imagem_noticia" style="background-image: url(\'/sistema/sys/arquivos/img_noticias/'.$foto_destaque.'\')"></div>
                    <div class="publicado_em">Publicado em: '.$data->get_dataFormat('BD', $noticia["data_noticia"], 'DMA').'</div>
                    <div class="titulo_noticia">'.$noticia["titulo_noticia"].'</div>
                    <div class="linha_fina_noticia">'.$noticia["description_noticia"].'</div>
                 </a>
            </div>
            ';
}
$vetor_conteudo['noticias'] = '<div class="noticias">' . $html_noticia . '</div>';


$ctr_conteudo = new Conteudo_Control($post_request);
$vetor_conteudo['o_sindiasea'] = $ctr_conteudo->Pega_Conteudo(8);

TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template1.php', $js_head, '', '', $vetor_conteudo);
} else {
    TemplateManager::show('template1.php', $js_head, '', '', $vetor_conteudo);
}

?>
