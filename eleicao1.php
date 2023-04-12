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

$vetor_conteudo['nome_link'] = "Eleições 2023";


TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template3.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template3.php', $js_head, "", "", $vetor_conteudo);
}

?>