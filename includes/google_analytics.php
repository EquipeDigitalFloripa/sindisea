<?php
//CONFIGURAR ANALYTICS VIA SISTEMA

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$ctr_config = new Configuracoes_Control($post_request);
$analytics = $ctr_config->Pega_Analytics();

echo $analytics;
?>



<!-- C�digo do Google para tag de remarketing -->
<!--------------------------------------------------
As tags de remarketing n�o podem ser associadas a informa��es pessoais de identifica��o nem inseridas em p�ginas relacionadas a categorias de confidencialidade. Veja mais informa��es e instru��es sobre como configurar a tag em: http://google.com/ads/remarketingsetup
--------------------------------------------------->
