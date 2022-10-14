<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT

        
JAVASCRIPT;

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Esqueci minha senha";


$vetor_conteudo['nome_link'] = "ESQUECEU SUA SENHA?";


/* * ***************************************************************************
 * MONTA FORMULÁRIO
 * *************************************************************************** */

if($detect->isMobile() && !$detect->isTablet()){
    $iframe_mapa = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3536.0122932110944!2d-48.56085504981266!3d-27.59314848275508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9527381fe2ea0cdd%3A0x3ad5183e2162971!2sSINDIASEA!5e0!3m2!1spt-BR!2sbr!4v1537814992741" width="100%" height="220" frameborder="0" style="border:0" allowfullscreen></iframe>';
}else{
    $iframe_mapa = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3536.0122932110944!2d-48.56085504981266!3d-27.59314848275508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9527381fe2ea0cdd%3A0x3ad5183e2162971!2sSINDIASEA!5e0!3m2!1spt-BR!2sbr!4v1537814992741" width="100%" height="425" frameborder="0" style="border:0" allowfullscreen></iframe>';
}

$vetor_conteudo['conteudo'] = '
        
        <div id="formulario_esqueceu_senha">
            <form id="formEsqueceuSenha" name="fromEsqueceuSenha" onSubmit="return false">	
                <div class="box_item_form">
                    <label>CPF*</label>
                    <input name="cpf_form" type="text" id="cpf_form" maxlength="60" value="""/>	
                </div>

                <div class="form_botao">			
                    <input id="botao-enviar" type="submit" value="ENVIAR" name="enviar" class="botao-enviar" />	
                    <div id="msg_formulario"></div>			
                </div>
            </form>
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