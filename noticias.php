<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT
        
  <!--  lightGallery --------------------------------------------------------->
      <link type="text/css" rel="stylesheet" href="/scripts/lightgallery/dist/css/lightgallery.css" />
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lightgallery.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lg-fullscreen.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lg-thumbnail.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lg-video.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lg-autoplay.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lg-zoom.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lg-hash.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/dist/js/lg-pager.js"></script>
      <script type="text/javascript" src="/scripts/lightgallery/lib/jquery.mousewheel.min.js"></script>
      <script type="text/javascript">
      $(document).ready(function(){
          $('.lightgallery1').lightGallery({
                download: false,
		thumbnail: true,
                exThumbImage: 'data-exthumbimage'
          }); 
      });
      </script>
  <!--  lightGallery ------------------------------------------------------- -->

        

JAVASCRIPT;

/**
 * CONTEUO 
 */
$ctr_conteudo = new Conteudo_Control($post_request);

$vetor_conteudo['nome_link'] = "";

$condicao = (isset($post_request['id_noticia'])) ? " AND status_noticia = 'A' AND id_noticia = " . $post_request['id_noticia'] :
        ((isset($post_request['url_amigavel'])) ? " AND status_noticia = 'A' AND url_amigavel = '" . $post_request['url_amigavel'] . "'" : "");

/**
 * NOTÍCIA
 */
$data = new Data();
$ctr_noticia = new Noticia_Control($post_request);
$noticia = $ctr_noticia->Pega_Noticia("$condicao", "data_noticia DESC");


/* ATUALIZA O CONTATO DE VISUALIZAÇOES DA NOTICIA */
$ctr_noticia->Atualiza_Contado($noticia['id_noticia']);

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > <a href='/noticias'>Notícias</a> > ".$noticia['titulo_noticia'];



$ctr_tag_noticia = new TagNoticia_Control($post_request);
$tags_noticia = $ctr_tag_noticia->Lista_Tags_Noticia($noticia['id_noticia']);

$tag = new Tags_Control($post_request);
$html_tags = $keywords = "";
foreach ($tags_noticia as $tags) {
    $tag_value = $tag->Pega_Tag($tags['id_tag']);
    $html_tags .= "<input name=\"busca_tag\" type=\"submit\" value=\"$tag_value\" />";
    $keywords .= $tag->Pega_Tag($tags['id_tag']) . ", ";
}

$dados_fotos_noticia = $ctr_noticia->Lista_Fotos_Noticia($noticia['id_noticia']);

$fotos_galeria = "";

for ($i = 0; $i < count($dados_fotos_noticia); $i++) {
    if ($dados_fotos_noticia[$i]['destaque_foto'] == 1) {
        $foto_destaque = $dados_fotos_noticia[$i]['id_foto'] . "." . $dados_fotos_noticia[$i]['ext_foto'];
        $foto_meta = $foto_destaque;
        $leg = $dados_fotos_noticia[$i]['leg_foto'];
    }else{
        $fotos_galeria .= "
            <li data-exthumbimage=\"/sistema/sys/arquivos/img_noticias/" . $dados_fotos_noticia[$i]['id_foto'] . "." . $dados_fotos_noticia[$i]['ext_foto'] . "\" data-src=\"/sistema/sys/arquivos/img_noticias/" . $dados_fotos_noticia[$i]['id_foto'] . "." . $dados_fotos_noticia[$i]['ext_foto'] . "\" data-sub-html=\"" . $foto_galeria['leg'] . "\">                
                <a href=\"/sistema/sys/arquivos/img_noticias/" . $dados_fotos_noticia[$i]['id_foto'] . "." . $dados_fotos_noticia[$i]['ext_foto'] . "\"  title=\"" . $dados_fotos_noticia[$i]['leg'] . "\">
                    <div class='foto_galeria' style='background-image: url(\"/sistema/sys/arquivos/img_noticias/" . $dados_fotos_noticia[$i]['id_foto'] . "." . $dados_fotos_noticia[$i]['ext_foto'] . "\")'></div>
                </a>
            </li>";
    }
}

if($fotos_galeria != ""){
    $galeria = '
    <div id="galeria_noticia">
        <div class="titulo_galeria_noticia">Galeria de Fotos</div>
        <ul class="lightgallery1">
            '.$fotos_galeria.'
        </ul>
    </div>
    ';
}else{
    $galeria = "";
}


$url = "http://" . $_SERVER['SERVER_NAME'] . "/noticia/".$noticia['url_amigavel']."";

//$bar_email = '<a href="" target="_blank"><div class="share email"></div></a>';
//$bar_insta = '<a href="" target="_blank"><div class="share insta"></div></a>';
//$bar_behance = '<a href="" target="_blank"><div class="share behance"></div></a>';
$bar_pinterest = '<a href="http://pinterest.com/pin/create/link/?url=' . urlencode($url) . '" target="_blank"><div class="share pinterest"></div></a>';
$bar_print = '<a href="javascript:window.print()"" target="_blank"><div class="share print"></div></a>';
$bar_tumbler = '<a href="http://www.tumblr.com/share/link?url=' . urlencode($url) . '" target="_blank"><div class="share tumbler"></div></a>';
$bar_facecebook = '<!-- FACEBOOK --><a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url) . '" target="_blank"><div class="share facebook"></div></a>';
$bar_twitter = '<!-- TWITTER --><a href="https://twitter.com/share?url=' . urlencode($url) . '&text=' . rawurlencode($noticia['titulo_noticia']) . '" target="_blank"><div class="share twitter"></div></a>';
$bar_likedin = '<!-- LINKEDIN --><a href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($url) . '" target="_blank"><div class="share linkedin"></div></a>';
$bar_google = '<!-- G+ --><a href="https://plus.google.com/share?url=' . urlencode($url) . '" target="_blank"><div class="share_google"></div></a>';
$bar_whatsapp = '<!-- WHATSAPP --><a href="whatsapp://send?text=' . urlencode($url) . '" target="_blank"><div class="share whatsapp"></div></a>';

if ($detect->isMobile() && !$detect->isTablet()) {
  $share_bar = '<div id="share_bar">' . $bar_pinterest . $bar_tumbler . $bar_facecebook . $bar_twitter . $bar_likedin . $bar_google . $bar_whatsapp . '</div>';
	$foto_noticia = '<div class="foto_noticia" style="background-image: url(\'/sistema/sys/arquivos/img_noticias/'.$foto_destaque.'\')"></div><span id="leg_foto">'.$leg.' </span>';
} else {
    $share_bar = '<div id="share_bar">' . $bar_pinterest . $bar_tumbler . $bar_facecebook . $bar_twitter . $bar_likedin . $bar_google . $bar_print . '</div>';
	$foto_noticia = '<div class="foto_noticia" style="background-image: url(\'/sistema/sys/arquivos/img_noticias/'.$foto_destaque.'\')"><span id="leg_foto">'.$leg.' </span></div>';
}

$html_post = '
            <style>section#conteudo_2nivel .titulo{display: none;}</style>
            <form name="form_tags" id="form_tags" method="get" action="/noticias" class="tags_noticia"><p>' . $html_tags . '</p></form>
            <div class="busca">
                <form name="form_busca" id="form_busca" method="post" action="/noticias">
                    <input type="text" name="busca" id="busca" value="" placeholder="Buscar">
                    <input type="submit" id="btn_buscar" value="">
                </form>
            </div>
            <div class="noticia">
                    '.($noticia['id_categoria_noticia'] != 3 ? $foto_noticia : '').'
                        
                <div class="box_lado_foto" '.($noticia['id_categoria_noticia'] == 3 ? "style='height: auto;'" : '').'>
                    <div class="data_noticia">Publicado em ' . date("d/m/Y", strtotime($noticia['data_noticia'])) . '</div>  
                    <div class="titulo_noticia">' . $noticia['titulo_noticia'] . '</div>
                </div>
                <div class="texto_noticia">
                    ' . $noticia['texto_noticia'] . '            
                </div>  
                ' . $share_bar . '
            </div>';

/**
 * MONTA HTML MAIS POSTS
 */
$dados_mais = $ctr_noticia->Listar_Noticias(" AND status_noticia = 'A' AND data_publicacao_noticia <= now() AND id_noticia <> ".$noticia['id_noticia']."", "data_noticia DESC", 0, 3);
$html_outras_noticias = "";
foreach ($dados_mais as $posts) {
    $destaque = $ctr_noticia->Pega_Foto_Destaque($posts['id_noticia']);
    $foto_destaque = $destaque[0]['id_foto'] . "." . $destaque[0]['ext_foto'];
     
    $html_outras_noticias .= '
                <div class="noticia">
                    <a href="/noticia/' . $posts['url_amigavel'] . '">
                        <div class="imagem_noticia" style="background-image: url(\'/sistema/sys/arquivos/img_noticias/'.$foto_destaque.'\')"></div>
                        <div class="publicado_em">Publicado em: 18/09/2018 às 10h30</div>
                        <div class="titulo_noticia">'.$posts["titulo_noticia"].'</div>
                        <div class="linha_fina_noticia">'.$posts["description_noticia"].'</div>
                     </a>
                </div>
                ';
}

$html_mais_posts = '        
        <div id="mais_noticias">
            <div class="titulo_outras_noticias">Outras notícias</div>
            <div class="outras_noticias">' . $html_outras_noticias . '</div>
        </div>    
    ';


/**
 * CONFIGURA METATAGS PARA COMPARTILHAMENTO NAS REDES SOCIAIS 
 */
$vetor_conteudo['meta_noticia']['title'] = $noticia['titulo_noticia'];
$vetor_conteudo['meta_noticia']['description'] = $noticia['description_noticia'];
$vetor_conteudo['meta_noticia']['keywords'] = $keywords;
$vetor_conteudo['meta_noticia']['image'] = 'http://' . $_SERVER['SERVER_NAME'] . '/sistema/sys/arquivos/img_noticias/' . $foto_meta;




/* HTML DA PÁGINA */
$vetor_conteudo['conteudo'] = '        
    <div id="noticia_exibe">
        ' . $html_post . '        
    </div>
    ' . $galeria . '
    ' . $html_mais_posts . '';
?>

<?php

$bg = ($detect->isMobile() && !$detect->isTablet()) ? "background-image: url(/mobile/imagens/topo_cinza.png)" : "background-image: url(/imagens/seg_nivel/bg_cinza.jpg)";
$det = 'background: url(/imagens/item_noticias.png) left center / 12px 14px no-repeat;';

TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, $bg, $det, $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, $bg, $det, $vetor_conteudo);
}
?>
