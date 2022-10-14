<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT

        
JAVASCRIPT;

$vetor_conteudo['nome_link'] = "REDEFINIÇÃO DE SENHA";


/* * ***************************************************************************
 * MONTA FORMULÁRIO
 * *************************************************************************** */

$ctr_associado = new Associado_Control($post_request);
$associado = $ctr_associado->Pega_Associado_Condicao(" AND token='" . $post_request['token'] . "'");

if (isset($associado['id_associado']) && $associado['id_associado'] > 0) {

    $vetor_conteudo['conteudo'] = '
        
        <div id="formulario_redefinir_senha">
            <form id="formRedefinirSenha" name="formRedefinirSenha" onSubmit="return false">	
                <input name="id_associado" type="hidden" id="id_associado" value="' . $associado['id_associado'] . '"/>
                <div class="box_item_form">
                    <label>Nova senha*</label>
                    <input name="senha_1" type="password" id="senha_1" value=""/>	
                </div>
                <div class="box_item_form">
                    <label>Confirmação de senha*</label>
                    <input name="senha_2" type="password" id="senha_2" value=""/>	
                </div>

                <div class="form_botao">			
                    <input id="botao-enviar" type="submit" value="REDEFINIR" name="enviar" class="botao-enviar" />	
                    <div id="msg_formulario"></div>	
                </div>
            </form>
        </div>
        ';
}else{
     $vetor_conteudo['conteudo'] = "Este link expirou. Por favor, solicite uma nova redefinição de senha.";
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