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
$ctr_conteudo = new Conteudo_Control($post_request);
$vetor_conteudo = $ctr_conteudo->Conteudo_Exibe();

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Diretoria Sindiasea";


TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}

?>