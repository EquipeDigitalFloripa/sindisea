<?php

ini_set("display_errors", true);

session_start();
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if ($_SESSION['id_associado'] == NULL || !isset($_SESSION['id_associado'])) {
    header("Location: /inicio");
} else {
    $id_associado = $_SESSION['id_associado'];
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$detect = new Mobile_Detect();

$js_head = <<<JAVASCRIPT
        
        <script type="text/javascript">
        
            function menu_selecao() {
                var dados = jQuery("#selecao").serialize();
                var mes = $('#mes_balancete').val();
                var ano = $('#ano_balancete').val();
                $.ajax({
                    url: "webservice.php?acao=listar_arquivos&aba=Balancetes",
                    data: dados,
                    type: "POST",
                    cache: false,
                    async: false,
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {
                        $("#lista_arquivos").html(data["lista_arquivos"]);
                        $('#mes_balancete').val(mes).prop('selected', true);
                        $('#ano_balancete').val(ano).prop('selected', true);
                    }
                });
            }
        
        var offset = 12;
        
        function carrega_bal() {
            var dados = jQuery("#selecao").serialize();
            $.ajax({
                url: 'webservice.php?acao=carrega_balancetes&limit=12&offset=' + offset,
                type: 'POST',
                data: dados,
                dataType: "json",
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    var liData = $(data.conteudo).hide();
                    $('#lista_arquivos .arquivos_l').append(liData);                            
                    liData.slideDown('slow');
                    if(data.total == 1){
                        $('#ver_mais_balancetes').hide();
                    }
                    offset = offset + 12;
                }
            });
        }
        
        </script>
        
      <!--lightGallery--------------------------------------------------------->
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
      <!--lightGallery--------------------------------------------------------->

JAVASCRIPT;


$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Área Restrita";

$vetor_conteudo['nome_link'] = "Área restrita";

$ctr_categoria_arquivo = new CategoriaArquivo_Control($post_request);
$categorias = $ctr_categoria_arquivo->Lista_Categorias();
$outras_abas = "";
$outras_abas_mobile = "";
$lista_balancetes = "";

foreach ($categorias as $categoria) {
    $outras_abas .= "
        <div class='aba'>" . $categoria['nome_categoria'] . "</div>
        ";

    $outras_abas_mobile .= "
        <option value=\"" . $categoria['nome_categoria'] . "\">" . $categoria['nome_categoria'] . "</option>
        ";
}

$ctr_balancetes = new Balancete_Control($post_request);

$balancetes = $ctr_balancetes->Lista_Balancetes(12, 0, 'data DESC');


//LISTAR ANOS DOS BALANCETES
$balancete_mais_antigo = $ctr_balancetes->Lista_Balancetes(1, 0, 'data ASC');
$balancete_mais_novo = $ctr_balancetes->Lista_Balancetes(1, 0, 'data DESC');

$lista_anos = range(gmdate('Y', strtotime($balancete_mais_antigo[0]['data'])), gmdate('Y', strtotime($balancete_mais_novo[0]['data'])));

$opcoes = "";

foreach ($lista_anos as $ano) {
    $opcoes .= "
        <option value=\"$ano\">$ano</option>
        ";
}

$select_ano = "<select onchange='menu_selecao()' name='ano_balancete' id='ano_balancete'>
                <option value=\"0\">Selecione o ano</option>
                $opcoes
               </select>
        ";

$select_mes = '<select onchange="menu_selecao()" name="mes_balancete" id="mes_balancete">
	<option value="0">Escolha o mês</option>
	<option value="01">Janeiro</option>
	<option value="02">Fevereiro</option>
	<option value="03">Março</option>
	<option value="04">Abril</option>
	<option value="05">Maio</option>
	<option value="06">Junho</option>
	<option value="07">Julho</option>
	<option value="08">Agosto</option>
	<option value="09">Setembro</option>
	<option value="10">Outubro</option>
	<option value="11">Novembro</option>
	<option value="12">Dezembro</option>
</select>';

foreach ($balancetes as $balancete) {

    $lista_balancetes .= "
        <div class='balancete'>
            <div class='data_balancete'>" . ucfirst(strftime('%B de %Y', strtotime($balancete['data']))) . "</div>
            <a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['completo'] . "' download><div class='arquivo'><span>Completo</span></div></a>
            <!--<a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['movimento_caixa'] . "' download><div class='arquivo'><span>Movimento caixa</span></div></a>-->
            <a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['resumido'] . "' download><div class='arquivo_img'><span>Resumido</span></div></a>
        </div>
        ";
}

$botao_ver_mais = "";

if ($ctr_balancetes->get_Total() > 12) {
    $botao_ver_mais .= '<div onclick="carrega_bal()" id="ver_mais_balancetes">Ver mais balancetes</div>';
}

if ($detect->isMobile() && !$detect->isTablet()) {
    $vetor_conteudo['conteudo'] = "
    <div id='arquivos'>
        <select id='aba'>
            <option value='Balancetes'>Balancetes</option>
            $outras_abas_mobile
        </select>
        <div id='lista_arquivos'>
            <form id='selecao'>
                $select_mes
                $select_ano
            </form>
            $lista_balancetes
        </div>
    </div>
    ";
} else {
    $vetor_conteudo['conteudo'] = "
    <div id='arquivos'>
        <div class='aba aba_selecionada'>Balancetes</div>
        $outras_abas
        <div id='lista_arquivos'>
            <form id='selecao'>
                $select_mes
                $select_ano
            </form>
            <div class='arquivos_l'>
            $lista_balancetes
            </div>
            $botao_ver_mais
        </div>
    </div>
    ";
}
/*
$ctr_galeria = new Galeria_Control($post_request);
$lista_galeria = $ctr_galeria->Lista_Galerias(3, 0, 'id_galeria DESC', 1);
$html_galerias = "";

$num_galeria = 1;

foreach ($lista_galeria as $galeria) {

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

$vetor_conteudo['conteudo'] .= "
    <div id='lista_galerias'>
        <div class='titulo'>Galerias</div>
        <div class='galerias'>
            $html_galerias
        </div>
        <a href='/galerias'><div class='veja_mais veja_mais_galerias'>Veja mais galerias</div></a>
    </div>
    ";

*/
TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}
?>