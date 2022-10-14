<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT

        
JAVASCRIPT;

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Fazer login";

$vetor_conteudo['nome_link'] = "LOGIN";


/* * ***************************************************************************
 * MONTA FORMULÁRIO
 * *************************************************************************** */

$vetor_conteudo['conteudo'] = '
        
        <div id="formulario_login">
            <form id="formLogin" name="formLogin" onSubmit="return false">	
                <div class="box_item_form">
                    <label>CPF*</label>
                    <input name="cpf_form" type="text" id="cpf_form" maxlength="60" value="""/>	
                </div>
                
                <div class="box_item_form">
                    <label>Senha*</label>
                    <input name="senha_form" type="password" id="senha_form" value="""/>	
                </div>
                
                <div class="form_botao">
                    <input id="botao-enviar" type="submit" value="ENTRAR" name="enviar" class="botao-enviar" />	
                    <div id="msg_formulario">CPF ou senha incorretos, tente novamente.</div>			
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