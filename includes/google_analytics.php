<?php
//CONFIGURAR ANALYTICS VIA SISTEMA

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$ctr_config = new Configuracoes_Control($post_request);
$analytics = $ctr_config->Pega_Analytics();

echo $analytics;
?>



<!-- Código do Google para tag de remarketing -->
<!--------------------------------------------------
As tags de remarketing não podem ser associadas a informações pessoais de identificação nem inseridas em páginas relacionadas a categorias de confidencialidade. Veja mais informações e instruções sobre como configurar a tag em: http://google.com/ads/remarketingsetup
--------------------------------------------------->
