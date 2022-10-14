<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT
        <script type="text/javascript">
            $(document).ready(function () {
                var offset = 9;
                $("#load").click(function(){
                    $.ajax({
                        url: 'webservice.php',
                        type: 'POST',
                        data: 'acao=noticias&limit=9&offset=' + offset,
                        dataType: "json",
                        success: function (data, textStatus, jqXHR) {
                            offset = offset + 9;
                            var liData = $(data.conteudo).hide();
                            $('#noticias_historico .noticias').append(liData);                            
                            liData.slideDown('slow');
                            if(data.total == 1){
                                $('#load').hide();
                            }
                        }
                    });
                });          
            });
        </script>
JAVASCRIPT;

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Notícias";

$vetor_conteudo['nome_link'] = "Notícias";

//Essa condiçao so e aplicada quando a busca for em noticias.php
if ((isset($post_request['busca_tag']))) {
    $desc_tag = $post_request['busca_tag'];

    $ctr_tags = new Tags_Control($post_request);
    $id_tag = $ctr_tags->Pega_Id_Tag($desc_tag);

    $ctr_tag_noticia = new TagNoticia_Control($post_request);
    $noticias = $ctr_tag_noticia->Lista_Noticias_Tag($id_tag);


    $ctr_noticia = new Noticia_Control($post_request);
    $i = 0;

    foreach ($noticias as $noticia) {
        $array_noticias[$i] = $ctr_noticia->Pega_Noticia(" AND status_noticia = 'A' AND id_noticia = '" . $noticia['id_noticia'] . "' ", "data_noticia DESC");

        $i++;
    }
} else {
    $condicao = (isset($post_request['busca'])) ? " AND (titulo_noticia LIKE '%" . $post_request['busca'] . "%' OR texto_noticia LIKE '%" . $post_request['busca'] . "%') AND status_noticia = 'A'" : "";

    $ctr_noticia = new Noticia_Control($post_request);
    $array_noticias = $ctr_noticia->Listar_Noticias(" AND status_noticia = 'A' AND data_publicacao_noticia <= now() $condicao", "data_noticia DESC", 0, 9);

    $total_noticias = $ctr_noticia->Listar_Noticias(" AND status_noticia = 'A' AND data_publicacao_noticia <= now() $condicao", "data_noticia DESC", 0, 200);
}

$html_noticia = "";
$nao = "";


if (count($array_noticias) == 0) {
    $nao = "<div class='sem_noticias'>Não há notícias cadastradas.</div>";
}

$data = new Data();

foreach ($array_noticias as $noticia) {

    if ($noticia == NULL) {
        continue;
    }

    $destaque = $ctr_noticia->Pega_Foto_Destaque($noticia['id_noticia']);
    $foto_destaque = $destaque[0]['id_foto'] . "." . $destaque[0]['ext_foto'];

    $html_noticia .= '
            <div class="noticia">         
                <a href="noticia/' . $noticia['url_amigavel'] . '">
                    <div class="imagem_noticia" style="background-image: url(\'/sistema/sys/arquivos/img_noticias/' . $foto_destaque . '\')"></div>
                    <div class="publicado_em">Publicado em: ' . $data->get_dataFormat('BD', $noticia["data_noticia"], 'DMA') . '</div>
                    <div class="titulo_noticia">' . $noticia["titulo_noticia"] . '</div>
                    <div class="linha_fina_noticia">' . $noticia["description_noticia"] . '</div>
                 </a>
            </div>
            ';
}
$noticias = '<div class="noticias">' . $html_noticia . '</div>';

if (count($total_noticias) > 3) {
    $noticias .= '<div id="load" class="veja_mais carregar_mais_noticias">Carregar mais</div>';
}


/**
 * MONTA HTML DA LISTA DE TAGS  
 */
$ctr_tags = new Tags_Control($post_request);
$array_tags = $ctr_tags->Lista_Tags();
$li_tags = "";
foreach ($array_tags as $tags) {
    $li_tags .= '<li><a href="?id_tag=' . $tags['id_tag'] . '">' . $tags['desc_tag'] . '</a></li>';
}
$tags_historico = '<ul class="tags_noticias">' . $li_tags . '</ul>';

/* HTML DA PÁGINA */
$vetor_conteudo['conteudo'] = '
    <div id="noticias_historico">
        <div class="busca">
            <form name="form_busca" id="form_busca" method="post" action="/noticias">
                <input type="text" name="busca" id="busca" value="" placeholder="Buscar">
                <input type="submit" id="btn_buscar" value="">
            </form>
        </div>
        ' . $nao . '   
        ' . $noticias . '    
    </div>
    ';
?>

<?php

TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}
?>
