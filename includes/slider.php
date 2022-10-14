<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$ctr_noticia = new Noticia_Control($post_request);
$noticias_destaque = $ctr_noticia->Listar_Noticias('AND destaque_slider = 1 AND data_publicacao_noticia <= now() ', 'data_noticia DESC', 0, 6);
if (!$noticias_destaque){
    $noticias_destaque = $ctr_noticia->Listar_Noticias('AND data_publicacao_noticia <= now() ', 'data_noticia DESC', 0, 3);
}
else{
    $noticias_nao_destaque = $ctr_noticia->Listar_Noticias('AND data_publicacao_noticia <= now() ', 'data_noticia DESC', count($noticias_destaque)+1, 3);
    $noticias_destaque = array_merge($noticias_destaque, $noticias_nao_destaque);
}

$li = "";
foreach ($noticias_destaque as $noticia){
    
    $foto_destaque = $ctr_noticia->Pega_Foto_Destaque($noticia['id_noticia']);
    $foto = $foto_destaque[0]['id_foto'] . '.' . $foto_destaque[0]['ext_foto'];
    $li .= '
                    <li>
                        <div class="centraliza_conteudo">
                            <div class="foto_noticia" style="background-image: url(\'../sistema/sys/arquivos/img_noticias/'.$foto.'\')"></div>
                            <div class="titulo_noticia">'.$noticia['titulo_noticia'].'</div>
                            <div class="linha_fina_noticia">'.$noticia['description_noticia'].'</div>
                        </div>
                    </li>
        ';
}
$slider = '<div class="flexslider">
                <ul class="slides">' . $li . '</ul>
            </div>';

echo $slider;
?>