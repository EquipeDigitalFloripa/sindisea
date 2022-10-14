<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$detect = new Mobile_Detect();

$js_head = <<<JAVASCRIPT
    
        
JAVASCRIPT;

/* * ***************************************************************************
 * CONTEÚDO
 * *************************************************************************** */

$vetor_conteudo = Array();

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Assessoria Jurídica";

$vetor_conteudo['nome_link'] = 'Assessoria Jurídica';

$ctr_convenio = new Convenio_Control($post_request);
$convenios = $ctr_convenio->Lista_Juridico(9999, 0, 'nome ASC');

$html_convenios = "";
foreach ($convenios as $convenio){
    $html_convenios .= "
        <div class='convenio'>
            <div class='foto_convenio' style='background-image: url(\"/sistema/sys/arquivos/img_convenio/".$convenio['foto'].".".$convenio['ext_foto']."\")'></div>
            <div class='nome_convenio'>".$convenio['nome']."</div>
            <div class='descricao_convenio'>".$convenio['info']."</div>
        </div>
        ";
}

$vetor_conteudo['conteudo'] = "<div class='convenios'>$html_convenios</div>";


TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}

?>