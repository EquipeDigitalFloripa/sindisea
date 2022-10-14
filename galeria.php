<?php

session_start();

if ($_SESSION['id_associado'] == NULL || !isset($_SESSION['id_associado'])) {
    header("Location: /inicio");
} else {
    $id_associado = $_SESSION['id_associado'];
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT
        
        
        <script type="text/javascript">
        
            function executa_lightgallery(i) {
                $('.lightgallery'+i).lightGallery({
                    download: false,
                    thumbnail: true,
                    exThumbImage: 'data-exthumbimage'
                });
            };
        
        
            $(document).ready(function () {
                var offset = 6;
                $("#load").click(function(){
                    $.ajax({
                        url: 'webservice.php',
                        type: 'POST',
                        data: 'acao=galeria_carrega&limit=6&offset=' + offset,
                        dataType: "json",
                        success: function (data, textStatus, jqXHR) {
                            var liData = $(data.conteudo).hide();
                            $('#lista_galerias .galerias').append(liData);                            
                            liData.slideDown('slow');
                            if(data.total == 1){
                                $('#load').hide();
                            }
                            var i;
                            for (i = offset+1; i < offset+7; i++) {
                                executa_lightgallery(i);
                            }
                            offset = offset + 6;
                        }
                    });
                });          
            });
        </script>
        
              
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
          $('.lightgallery1, .lightgallery2, .lightgallery3').lightGallery({
                download: false,
		thumbnail: true,
                exThumbImage: 'data-exthumbimage'
          }); 
      });
      </script>
  <!--  lightGallery ------------------------------------------------------- -->


JAVASCRIPT;


$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > <a href='/area-restrita'>Área Restrita</a> > Galerias";


$vetor_conteudo['nome_link'] = "Galerias";


$ctr_galeria = new Galeria_Control($post_request);
$array_galerias = $ctr_galeria->Lista_Galerias(6, 0, 'data_galeria DESC', 0);

$total_galerias = count($ctr_galeria->Lista_Galerias(9999999999, 0, 'data_galeria DESC', 0));
$html_galerias = "";

$num_galeria = 1;

foreach ($array_galerias as $galeria) {

    $foto_destaque = $ctr_galeria->Pega_Foto_Destaque($galeria['id_galeria']);

    $foto = $foto_destaque['id_foto'] . "." . $foto_destaque['ext_img'];

    $fotos = $ctr_galeria->Lista_Fotos($galeria['id_galeria']);

    $imagens_galeria = "";

    foreach ($fotos as $foto_galeria) {
        $imagens_galeria .= "
                <li data-exthumbimage=\"/sistema/sys/arquivos/img_galerias/" . $foto_galeria['id_foto'] . "." . $foto_galeria['ext_img'] . "\" style=\"display: none;\" data-src=\"/sistema/sys/arquivos/img_galerias/" . $foto_galeria['id_foto'] . "." . $foto_galeria['ext_img'] . "\" data-sub-html=\"" . $foto_galeria['leg'] . "\">                
                </li>
            ";
    }


    $html_galerias .= "
        <div class='box_galeria'>
            <ul class='galeria lightgallery$num_galeria'>
                <li data-exthumbimage=\"/sistema/sys/arquivos/img_galerias/$foto\" data-src=\"/sistema/sys/arquivos/img_galerias/$foto\" data-sub-html=\"" . $foto_destaque['leg'] . "\">                
                    <a href=\"/sistema/sys/arquivos/img_galerias/$foto\"  title=\"" . $foto_destaque['leg'] . "\">
                        <div class='destaque_galeria' style='background-image: url(\"/sistema/sys/arquivos/img_galerias/$foto\")'></div>
                    </a>
                </li>
                $imagens_galeria
            </ul>
            <div class='titulo_galeria'>" . $galeria['titulo'] . "</div>
        </div>
        ";

    $num_galeria++;
}


$vetor_conteudo['conteudo'] = "
    <div id='lista_galerias'>
        <div class='galerias'>
            $html_galerias
        </div>
    </div>
    ";



if ($total_galerias > 6) {
    $vetor_conteudo['conteudo'] .= '<div class="veja_mais" id="load" style="cursor: pointer; margin-top: 30px;">Carregar mais</div>';
}
?>

<?php

TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}
?>
