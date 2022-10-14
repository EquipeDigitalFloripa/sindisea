<?php
$post_request = array_merge($_POST, $_REQUEST);

$url_atual = Site_Helper::exibirUrlAtual();

$ctr_configuracoes = new Configuracoes_Control($post_request);
$dados_metatags = $ctr_configuracoes->Pega_Metatags();

$metatags = Array();
//print_r($dados_metatags); die;
/* METATAGS DEFAULT P�GINAS */
$metatags[] = '<meta http-equiv="Content-Type" content="' . $dados_metatags["content_type"] . '"/>';
$metatags[] = '<meta http-equiv="pragma" content="' . $dados_metatags["pragma"] . '" />';
$metatags[] = '<meta http-equiv="cache-control" content="' . $dados_metatags["cache_control"] . '" />';
$metatags[] = '<meta http-equiv="author" content="' . $dados_metatags["author"] . '" />';
$metatags[] = '<meta http-equiv="content-language" content="' . $dados_metatags["content_language"] . '" />';
$metatags[] = '<meta name="reply-to" content="' . $dados_metatags["reply_to"] . '" />';
$metatags[] = '<meta name="url" content="' . $dados_metatags["url"] . '" />';
$metatags[] = '<meta name="copyright" content="' . $dados_metatags["copyright"] . '" />';
$metatags[] = '<meta name="owner" content="' . $dados_metatags["owner"] . '" />';
$metatags[] = '<meta name="rating" content="' . $dados_metatags["rating"] . '" />';
$metatags[] = '<meta name="robots" content="' . $dados_metatags["robots"] . '" />';
$metatags[] = '<meta name="googlebot" content="' . $dados_metatags["googlebot"] . '" />';
$metatags[] = '<meta name="Classification" content="' . $dados_metatags["classification"] . '" />';
$metatags[] = '<meta name="revisit-after" content="' . $dados_metatags["revisit_after"] . '" />';
$metatags[] = '<meta name="geo.placename" content="' . $dados_metatags["geo_placename"] . '" />';
$metatags[] = '<meta name="geo.country" content="' . $dados_metatags["geo_country"] . '" />';
$metatags[] = '<meta name="dc.language" content="' . $dados_metatags["dc_language"] . '" />';


/* METATAGS PARA COMPARTILHAMENTO NO FACEBOOK P�GINAS */
$metatags[] = '<meta property="fb:app_id" content="193201834162798"/>';
$metatags[] = '<meta property="og:locale" content="pt_BR" />';
$metatags[] = '<meta property="og:site_name" content="' . $dados_metatags["url"] . '" />';
$metatags[] = '<meta property="og:image:type" content="image/jpeg" />';
$metatags[] = '<meta property="og:image:width" content="800" />';
$metatags[] = '<meta property="og:image:height" content="400" />';
$metatags[] = '<meta name="facebook-domain-verification" content="jlya4l8e7ho27akrjiv4dq9ki9x2hc" />';


/* METATAGS PARA COMPARTILHAMENTO NO FACEBOOK NOT�CIAS */
if (isset($vetor_conteudo['meta_noticia']) && $vetor_conteudo['meta_noticia'] != NULL) {
    $metatags[] = '<title>' . $vetor_conteudo['meta_noticia']['title'] . '</title>';
    $metatags[] = '<meta name="description" content="' . $vetor_conteudo['meta_noticia']['description'] . '" />';
    $metatags[] = '<meta name="keywords" content="' . $vetor_conteudo['meta_noticia']['keywords'] . '" />';
    $metatags[] = '<meta property="og:url" content="' . $vetor_conteudo['meta_noticia']['title'] . '" />';
    $metatags[] = '<meta property="og:title" content="' . $vetor_conteudo['meta_noticia']['title'] . '">';
    $metatags[] = '<meta property="og:description" content="' . $vetor_conteudo['meta_noticia']['description'] . '">';
    $metatags[] = '<meta property="og:image" content="' . $vetor_conteudo['meta_noticia']['image'] . '">';
} else {
    $metatags[] = '<title>' . $dados_metatags["title"] . '</title>';
    $metatags[] = '<meta name="description" content="' . $dados_metatags["description"] . '" />';
    $metatags[] = '<meta name="keywords" content="' . $dados_metatags["keywords"] . '" />';
    $metatags[] = '<meta property="og:url" content="' . $url_atual . '" />';
    $metatags[] = '<meta property="og:description" content="' . $dados_metatags["description"] . '">';
    $metatags[] = '<meta property="og:title" content="' . $dados_metatags["title"] . '">';
    $metatags[] = '<meta property="og:image" content="http://sindiasea.org.br/sistema/sys/arquivos/img_metatags/1.png">';    
}
foreach ($metatags as $meta) {

    echo $meta . "\r\n";
}
?>


<link rel="shortcut icon" type="image/x-icon" href="/favicons/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
<link rel="manifest" href="/favicons/manifest.json">
<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#0B5F4B">
<meta name="theme-color" content="#0B5F4B">



<!-- Facebook Pixel Code -->
<!-- End Facebook Pixel Code -->


